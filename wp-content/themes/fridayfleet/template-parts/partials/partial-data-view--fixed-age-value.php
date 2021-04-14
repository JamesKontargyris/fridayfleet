<?php

use FridayFleet\FridayFleetController;

$ff                 = new FridayFleetController;
$ship_type_db_slugs = get_ship_type_database_slugs(); // get all ship type database slugs for comparison to the one passed in, if any
?>

<main id="primary" class="site__body">

    <div id="content-top"></div>

	<?php

	$ship_db_slug = $_GET['ship'] ? $_GET['ship'] : '0';
	if ( ! in_array( $ship_db_slug, $ship_type_db_slugs ) ) : // ship type not found
		?>
        <div class="message message--error">ERROR: invalid ship type.</div>
		<?php exit();
	endif; ?>

	<?php if ( ! $ship_type_data = get_ship_type_by_database_slug( $ship_db_slug ) ) : ?>
        <div class="message message--error">ERROR: ship not found.</div>
		<?php exit();
	endif; ?>

	<?php
	$ship_type_id                        = $ship_type_data->ID;
	$graph_colours                       = $ff->getColours();
	$fixed_age_value_graph_data_quarters = $ff->getFixedAgeValueDataForGraph( $ship_db_slug, 'quarters' );
	$fixed_age_value_graph_data_years    = $ff->getFixedAgeValueDataForGraph( $ship_db_slug, 'years' );
	$fixed_age_value_table_data_quarters = $ff->getFixedAgeValueDataForTable( $ship_db_slug, 'quarters' );
	$fixed_age_value_table_data_years    = $ff->getFixedAgeValueDataForTable( $ship_db_slug, 'years' );

	//	var_dump( $fixed_age_value_table_data_quarters );
	// Precision digits in BC math.
	bcscale( 10 );
	$poly_regression_data_25yr = new PolynomialRegression( 4 );
	$array_index               = 0;
	foreach ( $fixed_age_value_table_data_quarters[ $ship_db_slug ] as $dataset ) {
		$poly_regression_data_25yr->addData( $array_index, $dataset['average_25_year'] );
		$array_index ++;
	}
	$coefficients = $poly_regression_data_25yr->getCoefficients();

	for ( $i = 0; $i <= $array_index; $i ++ ) {
//	    var_dump($poly_regression_data_25yr->interpolate($coefficients, $i));

	}
	?>

	<?php
	// Get number of datasets
	$no_of_datasets = $ff->getNumberOfDatasets( $fixed_age_value_graph_data_years[ $ship_db_slug ] );
	// Get last year of data
	// Used to ensure annotations don't go off the edge of the years chart
	$last_year_of_data = $ff->getLastYearOfData( $fixed_age_value_table_data_years[ $ship_db_slug ] );
	?>

    <div class="data-view data-view--<?php echo $ship_db_slug; ?>">
        <div class="data-view__header--sticky">

            <div class="data-view__header">
                <h1 class="data-view__title">
                    <strong class="data-view__title--icon-ship"><?php echo $ship_db_slug; ?></strong>
                    <span class="data-view__title__divider">&rang;</span> <span
                            class="data-view__title__view-title-and-menu-toggle">Fixed Age Value</span>
                </h1>
            </div>

        </div>

        <div class="data-view__cols">

            <div class="data-view__main-col data-view__main-col--ship-view">
                <section class="box">
                    <div class="box__header">
                        <div class="box__header__titles">
                            <div class="box__header__title">Graph <span
                                        class="help-icon tooltip--help hide--no-touch"
                                        title="Drag out an area to zoom. Tap a datapoint to view data. Tap a legend label to show/hide other datasets."></span>
                                <span class="help-icon tooltip--help hide--touch"
                                      title="Drag out an area to zoom. Hover over a datapoint to view data. Click a legend label to show/hide other datasets."></span>
                            </div>
                            <div class="box__header__sub-title content--value-over-time-years">Data based on an average
                                of quarter figures for each year
                            </div>
                        </div>
                        <div class="box__header__controls">
                            <div class="switch">
                                <div class="switch__option-group">
                                    <button class="switch__option switch__option--quarters is-active"
                                            data-elements-to-show=".content--value-over-time-quarters"
                                            data-elements-to-hide=".content--value-over-time-years"
                                            onclick="resetZoom()">
                                        Quarters
                                    </button>
                                    <button class="switch__option switch__option--years"
                                            data-elements-to-show=".content--value-over-time-years"
                                            data-elements-to-hide=".content--value-over-time-quarters"
                                            onclick="resetZoom()">
                                        Years
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box__content">

                        <div class="graph-update-button-group">
                            <button onclick="resetZoom()" class="btn btn--graph-update btn--reset-zoom">Reset Zoom
                            </button>
                            <button onclick="clearAnnotations()"
                                    class="btn btn--graph-update btn--clear-annotations">
                                Remove Line
                            </button>
                        </div>


                        <div id="graphs" class="graphs-container">

                            <div class="graph-group graph-group--value-over-time-quarters content--value-over-time-quarters is-active">
                                <div class="graph-group__canvas-container">
                                    <canvas class="graph graph__value-over-time-quarters"
                                            id="graph__value-over-time-quarters"></canvas>
                                </div>
                                <div id="quarters-legend-container"></div>
                            </div>

                            <div class="graph-group graph-group--value-over-time-years content--value-over-time-years">
                                <div class="graph-group__canvas-container">
                                    <canvas class="graph graph__value-over-time-years"
                                            id="graph__value-over-time-years"></canvas>
                                </div>
                                <div id="years-legend-container"></div>
                            </div>

                        </div>


                    </div>
                </section>

                <section class="box">
                    <div class="box__header">
                        <div class="box__header__titles">
                            <div class="box__header__title">Data</div>
                            <div class="box__header__sub-title content--value-over-time-years">Data based on an
                                average of quarter figures for each year
                            </div>
                        </div>
                        <div class="box__header__controls">
                            <div class="toggle-switch">
                                <label for="view-trend-data" data-style="rounded" data-text="false" data-size="xs">
                                    <input checked type="checkbox" id="view-trend-data">
                                    <span class="toggle">
                                    <span class="switch"></span>
                                </span>
                                    <span class="toggle-switch__label">View trend data</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="box__content box__content--scrollable" style="max-height: 25vh;">
                        <!--                        <p class="data-table__key">Actual data <span class="is-trend-data">Trend data</span></p>-->


                        <table class="data-table data-table--first-col data-table--sticky-header"
                               cellpadding="0" cellspacing="0" border="0">

                            <thead>
                            <tr>
                                <th></th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[0]; ?>)">&bull;</span> New
                                </th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[1]; ?>)">&bull;</span> 5yr
                                </th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[2]; ?>)">&bull;</span> 10yr
                                </th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[3]; ?>)">&bull;</span> 15yr
                                </th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[4]; ?>)">&bull;</span> 20yr
                                </th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[5]; ?>)">&bull;</span> 25yr
                                </th>
                                <th><span class="hide--mobile"
                                          style="color:rgb(<?php echo $graph_colours[6]; ?>)">&bull;</span> Scrap
                                </th>
                            </tr>
                            </thead>

                            <tbody class="content--value-over-time-quarters is-active">
							<?php
							$year                    = 0;
							$display_on_page_load    = 1; // used to display the latest year's set of data on page load
							$latest_set_of_data_year = $fixed_age_value_table_data_quarters[ $ship_db_slug ][0]['year']; // gets the year from the latest set of data. Used to display the latest year's set of data on page load

							foreach ( $fixed_age_value_table_data_quarters[ $ship_db_slug ] as $key => $ship_data ) : ?>
								<?php if ( $year != $ship_data['year'] ) : $year = $ship_data['year']; ?>
                                    <tr class="data-table__sub-title<?php if ( $display_on_page_load && $latest_set_of_data_year == $year ) : ?> is-active<?php endif; ?>"
                                        data-year="<?php echo $year; ?>">
                                        <td colspan="8"><?php echo $ship_data['year']; ?></td>
                                    </tr>
								<?php endif; ?>
                                <tr data-year-data="<?php echo $year; ?>" <?php if ( $display_on_page_load && $latest_set_of_data_year == $year ) : ?> class="is-active"<?php endif; ?>>
                                    <td><?php echo 'Q' . $ship_data['quarter']; ?></td>
                                    <td data-poly-data-target-id="quarters-0-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_new_build'], 2 ); ?></td>
                                    <td data-poly-data-target-id="quarters-1-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_5_year'], 2 ); ?></td>
                                    <td data-poly-data-target-id="quarters-2-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_10_year'], 2 ); ?></td>
                                    <td data-poly-data-target-id="quarters-3-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_15_year'], 2 ); ?></td>
                                    <td data-poly-data-target-id="quarters-4-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_20_year'], 2 ); ?></td>
                                    <td data-poly-data-target-id="quarters-5-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_25_year'], 2 ); ?></td>
                                    <td data-poly-data-target-id="quarters-6-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_scrap'], 2 ); ?></td>
									<?php // data-poly-data-target-id="time_scale-JS_polynomial_dataset-data_index" ?>
                                </tr>
							<?php endforeach; ?>
                            </tbody>

                            <tbody class="content--value-over-time-years">
							<?php $year = 0;
							$key        = 0; // keep track of which key of the array corresponds to the current year's position
							foreach ( $fixed_age_value_table_data_years[ $ship_db_slug ] as $year => $ship_data ) : ?>
                                <tr>
                                    <td><?php echo $year; ?></td>
                                    <td data-poly-data-target-id="years-0-<?php echo $key; ?>"><?php echo number_format( $ship_data['new'], 2 ); ?></td>
                                    <td data-poly-data-target-id="years-1-<?php echo $key; ?>"><?php echo number_format( $ship_data['5yr'], 2 ); ?></td>
                                    <td data-poly-data-target-id="years-2-<?php echo $key; ?>"><?php echo number_format( $ship_data['10yr'], 2 ); ?></td>
                                    <td data-poly-data-target-id="years-3-<?php echo $key; ?>"><?php echo number_format( $ship_data['15yr'], 2 ); ?></td>
                                    <td data-poly-data-target-id="years-4-<?php echo $key; ?>"><?php echo number_format( $ship_data['20yr'], 2 ); ?></td>
                                    <td data-poly-data-target-id="years-5-<?php echo $key; ?>"><?php echo number_format( $ship_data['25yr'], 2 ); ?></td>
                                    <td data-poly-data-target-id="years-6-<?php echo $key; ?>"><?php echo number_format( $ship_data['scrap'], 2 ); ?></td>
                                </tr>
								<?php $key ++; endforeach; ?>
                            </tbody>

                        </table>

                    </div>
                </section>
            </div>

            <div class="data-view__side-col data-view__side-col--ship-view">

				<?php get_template_part( 'template-parts/partials/partial', 'ship-definition', [
					'ship_type_id' => $ship_type_id
				] ); ?>

                <section class="box">
                    <div class="box__header">
                        <div class="box__header__titles">
                            <div class="box__header__title">Market Notes</div>
                        </div>
                    </div>

                    <div class="box__content box__content--scrollable" style="max-height: 70vh;">

						<?php $market_notes = get_market_notes_by_ship_type_id( $ship_type_id ); ?>

						<?php if ( $market_notes->have_posts() ) : ?>

							<?php while ( $market_notes->have_posts() ) : $market_notes->the_post(); ?>
								<?php get_template_part( 'template-parts/partials/partial', 'market-note--ship-view' ); ?>
							<?php endwhile;
							wp_reset_postdata(); ?>

						<?php else : ?>
                            No notes found.
						<?php endif; ?>

                    </div>
                </section>
            </div>
        </div>

    </div>

</main>

<?php get_template_part( 'template-parts/partials/partial', 'data-view-selection-menu' ); ?>

<?php get_footer(); ?>

<script>
    (function ($) {
        var ctxQuarters = document.getElementById('graph__value-over-time-quarters');
        var ctxYears = document.getElementById('graph__value-over-time-years');

        var chartQuarters = new Chart(ctxQuarters, {
            type: 'line',
            data: {
                datasets: [
					<?php foreach($fixed_age_value_graph_data_quarters[ $ship_db_slug ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['label']; ?>',
                        data: [
							<?php foreach($dataset['data'] as $x => $y) : ?>
                            {x: moment('<?php echo $x; ?>', "YYYYMM"), y: <?php echo number_format( $y, 2 ); ?>},
							<?php endforeach; ?>
                        ],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        borderWidth: 2,
                        spanGaps: true,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        pointHitRadius: 10,
                        pointHoverRadius: 3,
                        pointHoverBorderColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        pointHoverBackgroundColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        lineTension: 0.3,
                    },
					<?php endforeach; ?>
                ]
            },

            options: fixedAgeValue_chartOptionsQuarters,

        });

		<?php reset( $graph_colours ); ?>

        // Keep track of which group of data we are working with so we can target the right data table cell with polynomial data
        var dataGroupIndex = 0;

        // Add polynomial lines to quarters chart and data table
		<?php foreach($fixed_age_value_graph_data_quarters[ $ship_db_slug ] as $dataset) : ?>
		<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

        // Build an array of raw data
        var rawData = [],
            i = 0;
		<?php foreach($dataset['data'] as $x => $y) : ?>
        rawData.push([i, <?php echo number_format( $y, 2 ); ?>]);
        i++;
		<?php endforeach; ?>

        polynomialData = regression.polynomial(rawData, {order: 3, precision: 10});

        chartQuarters.data.datasets.push({
            label: '<?php echo $dataset['label']; ?>',
            data: [
				<?php $i = 0; ?>
				<?php foreach($dataset['data'] as $x => $y) : ?>
                {
                    x: moment('<?php echo $x; ?>', "YYYYMM"),
                    y: +(polynomialData['points'][<?php echo $i; ?>][1].toFixed(2))
                },
				<?php $i ++; ?>
				<?php endforeach; ?>
            ],
            fill: false,
            borderColor: 'rgba(<?php echo $colour; ?>, 1)',
            backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
            borderWidth: 2,
            spanGaps: true,
            pointStyle: 'circle',
            pointRadius: 0,
            pointHitRadius: 0,
            pointHoverRadius: 0,
            lineTension: 0.3,
            options: fixedAgeValue_chartOptionsQuarters,
        });
        chartQuarters.update();

        // Reverse data as table data is descending while graph data is ascending
        var reversedPolyData = polynomialData['points'].reverse();
        // Append the polynomial data to the relevant data table cell
        reversedPolyData.forEach(function (data, index) {
            $('td[data-poly-data-target-id="quarters-' + dataGroupIndex + '-' + index + '"]').append('<br><span class="is-trend-data">' + data[1].toFixed(2) + '</span>');
        });

        dataGroupIndex++;

		<?php endforeach; ?>

		<?php reset( $graph_colours ); ?>

        var chartYears = new Chart(ctxYears, {
            type: 'line',
            data: {
                datasets: [
					<?php foreach($fixed_age_value_graph_data_years[ $ship_db_slug ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['label']; ?>',
                        data: [
							<?php foreach($dataset['data'] as $x => $y) : ?>
                            {x: moment('<?php echo $x; ?>', "YYYY"), y: <?php echo number_format( $y, 2 ); ?>},
							<?php endforeach; ?>
                        ],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        borderWidth: 2,
                        spanGaps: true,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        pointHoverRadius: 3,
                        pointHoverBorderColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        pointHoverBackgroundColor: 'rgba(<?php echo $colour; ?>, 0.2)',
                        lineTension: 0.3,
                    },

					<?php endforeach; ?>

                ]
            },

            options: fixedAgeValue_chartOptionsYears,

        });

        // Keep track of which group of data we are working with so we can target the right data table cell with polynomial data
        var dataGroupIndex = 0;

        // Add polynomial lines to years chart
		<?php foreach($fixed_age_value_graph_data_years[ $ship_db_slug ] as $dataset) : ?>
		<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

        // Build an array of raw data
        var rawData = [],
            i = 0;
		<?php foreach($dataset['data'] as $x => $y) : ?>
        rawData.push([i, <?php echo number_format( $y, 2 ); ?>]);
        i++;
		<?php endforeach; ?>

        polynomialData = regression.polynomial(rawData, {order: 3, precision: 10});

        chartYears.data.datasets.push({
            label: '<?php echo $dataset['label']; ?>',
            data: [
				<?php $i = 0; ?>
				<?php foreach($dataset['data'] as $x => $y) : ?>
                {
                    x: moment('<?php echo $x; ?>', "YYYYMM"),
                    y: +(polynomialData['points'][<?php echo $i; ?>][1].toFixed(2))
                },
				<?php $i ++; ?>
				<?php endforeach; ?>
            ],
            fill: false,
            borderColor: 'rgba(<?php echo $colour; ?>, 1)',
            backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
            borderWidth: 2,
            spanGaps: true,
            pointStyle: 'circle',
            pointRadius: 0,
            pointHitRadius: 5,
            pointHoverRadius: 0,
            lineTension: 0.3,
            options: fixedAgeValue_chartOptionsYears,
        });
        chartYears.update();

        // Reverse data as table data is descending while graph data is ascending
        var reversedPolyData = polynomialData['points'].reverse();
        // Append the polynomial data to the relevant data table cell
        reversedPolyData.forEach(function (data, index) {
            $('td[data-poly-data-target-id="years-' + dataGroupIndex + '-' + index + '"]').append('<br><span class="is-trend-data">' + data[1].toFixed(2) + '</span>');
        });

        dataGroupIndex++;

		<?php endforeach; ?>

		<?php reset( $graph_colours ); ?>

        // Custom legend
        var quartersLegendContainer = document.getElementById("quarters-legend-container"),
            yearsLegendContainer = document.getElementById("years-legend-container");

        // generate HTML legends
        quartersLegendContainer.innerHTML = chartQuarters.generateLegend();
        yearsLegendContainer.innerHTML = chartYears.generateLegend();

        // bind onClick event to all LI-tags of the legend
        var legendItems = quartersLegendContainer.getElementsByTagName('li');
        for (var i = 0; i < legendItems.length; i += 1) {
            legendItems[i].addEventListener("click", legendClickCallback, false);
        }
        var legendItems = yearsLegendContainer.getElementsByTagName('li');
        for (var i = 0; i < legendItems.length; i += 1) {
            legendItems[i].addEventListener("click", legendClickCallback, false);
        }

        function legendClickCallback(event) {
            event = event || window.event;

            var target = event.target || event.srcElement;
            while (target.nodeName !== 'LI') {
                target = target.parentElement;
            }
            var parent = target.parentElement;
            var chartId = parseInt(parent.classList[0].split("-")[0], 10);
            var chart = Chart.instances[chartId];
            var index = Array.prototype.slice.call(parent.children).indexOf(target);

            chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[index]);
            chart.legend.options.onClick.call(chart, event, chart.legend.legendItems[index + 7]); // +7 to hide polynomial line too
            if (chart.isDatasetVisible(index)) {
                target.classList.remove('hidden');
            } else {
                target.classList.add('hidden');
            }
        }

        window.resetZoom = function () {
            chartQuarters.resetZoom();
            chartYears.resetZoom();
            document.getElementsByClassName('btn--reset-zoom')[0].classList.remove('is-active');
        };

        window.clearAnnotations = function () {
            chartQuarters.options.annotation.annotations = [];
            chartQuarters.update();
            chartYears.options.annotation.annotations = [];
            chartYears.update();
            document.getElementsByClassName('btn--clear-annotations')[0].classList.remove('is-active');
        };

        window.addAnnotationVertical = function (year, month, day, text) {
            var line = year + ' ' + month + ' ' + day;
            var quarterGraphValue = year + ' ' + month + ' ' + day;

            // If annotation will go off the edge of the chart,
            // position it at the right-edge
            if (year >= <?php echo $last_year_of_data; ?>) {
                var yearGraphValue = <?php echo $last_year_of_data; ?> +' 01 01';
            } else {
                var yearGraphValue = year + ' ' + month + ' ' + day;
            }

            var newAnnotation = {
                drawTime: "afterDatasetsDraw",
                id: line,
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: quarterGraphValue,
                borderColor: "white",
                borderWidth: 1,
                borderDash: [2, 2],
                borderDashOffset: 5,
                label:
                    {
                        enabled: true,
                        backgroundColor: "rgba(0,0,0,0.4)",
                        cornerRadius: 3,
                        position: "center",
                        fontColor: "rgba(255,255,255,1)",
                        fontFamily: "Lato",
                        fontSize: 11,
                        content: text,
                        rotation: 90,
                        xAdjust: -12,
                    }
            };
            chartQuarters.options.annotation.annotations.push(newAnnotation);
            chartQuarters.update();

            // Update the value for the years chart
            newAnnotation.value = yearGraphValue;
            chartYears.options.annotation.annotations.push(newAnnotation);
            chartYears.update();

            document.getElementsByClassName('btn--clear-annotations')[0].className += ' is-active';
        }

        // Change the graph options based on window size
        function changeGraphOptions() {
            // Get width and height of the window excluding scrollbars
            var w = document.documentElement.clientWidth;

            if (w <= 767) {
                for (var i = 0; i < <?php echo $no_of_datasets; ?>; i++) {
                    chartQuarters.data.datasets[i].borderWidth = 1;
                    chartYears.data.datasets[i].borderWidth = 1;

                    chartQuarters.data.datasets[i].pointRadius = 2;
                    chartYears.data.datasets[i].pointRadius = 2;
                }
            } else {
                for (var i = 0; i < <?php echo $no_of_datasets; ?>; i++) {
                    chartQuarters.data.datasets[i].borderWidth = 2;
                    chartYears.data.datasets[i].borderWidth = 2;

                    chartQuarters.data.datasets[i].pointRadius = 3;
                    chartYears.data.datasets[i].pointRadius = 3;
                }
            }

            chartQuarters.update();
            chartYears.update();
        }

        // Run on page load
        changeGraphOptions();
        // Listen for screen resize and fire function
        window.addEventListener("resize", changeGraphOptions);


    })(jQuery);
</script>

<style type="text/css">
    /* Style legend colours according to $graph_colours */
    <?php reset($graph_colours); ?>

    <?php for($i = 1; $i <= count($graph_colours); $i++) : ?>
    .chartjs-legend li:nth-child(<?php echo $i; ?>) {
        color: rgb(<?php echo current( $graph_colours ); ?>);
    }

    .chartjs-legend li:nth-child(<?php echo $i; ?>):before {
        background: rgb(<?php echo current( $graph_colours ); ?>);
        border-color: rgb(<?php echo current( $graph_colours ); ?>);
    }

    <?php next( $graph_colours ); ?>
    <?php endfor; ?>
</style>
