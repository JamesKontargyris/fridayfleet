<?php

use FridayFleet\FridayFleetController;

$ff                 = new FridayFleetController;
$ship_type_db_slugs = get_ship_type_database_slugs(); // get all ship type database slugs for comparison to the one passed in, if any
?>

<?php
// Fixed age value stuff
$ship_type_id                        = get_the_ID();
$ship_db_slug                        = get_field( 'ship_type_database_slug' );
$graph_colours                       = $ff->getColours();
$fixed_age_value_graph_data_quarters = $ff->getFixedAgeValueDataForGraph( $ship_db_slug, 'quarters' );
$fixed_age_value_graph_data_years    = $ff->getFixedAgeValueDataForGraph( $ship_db_slug, 'years' );
$fixed_age_value_table_data_quarters = $ff->getFixedAgeValueDataForTable( $ship_db_slug, 'quarters' );
$fixed_age_value_table_data_years    = $ff->getFixedAgeValueDataForTable( $ship_db_slug, 'years' );

// Vessel Finance Calculator / depreciation stuff
$depreciation_data     = [];
$build_date            = '';
$date_of_finance       = '';
$date_of_finance_array = [];
$graph_is_visible      = 0; // if this turns to one, market notes can be plotted on the graph, otherwise hide the plot on graph link

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
                <strong class="data-view__title--icon-ship"><?php the_title(); ?></strong>
            </h1>
        </div>

    </div>

    <div class="data-view__cols">

        <div class="data-view__main-col data-view__main-col--ship-view">

            <section class="tools">

                <ul class="tool-menu">
                    <li class="tool-menu__item">
                        <button class="tool-menu__button tool-menu__button--vessel-finance-calculator with-icon--calculator">
                            Vessel Finance Calculator
                        </button>
                    </li>
                </ul>

                <div class="tool-drawer">
                    <div class="tool-drawer__tool tool-drawer__tool--vessel-finance-calculator">
						<?php get_template_part( 'template-parts/partials/partial', 'ajax-loader-section', [ 'id' => 'ajax-loader--vessel-finance-calculator' ] ); ?>

                        <div class="form-errors">
                            Please address the following errors:
                            <div class="form-errors__errors"></div>
                        </div>

                        <form action="" method="POST" class="vessel-finance-calculator is-active">
                            <div class="vessel-finance-calculator__input-group">
                                <label for="build_date" class="vessel-finance-calculator__label">Build date
                                    (dd/mm/yyyy)</label>
                                <input type="text" autocomplete="off"
                                       class="vessel-finance-calculator__text-input datepicker"
                                       name="build_date"
                                       placeholder="Select date...">
                            </div>

                            <div class="vessel-finance-calculator__input-group">
                                <label for="date_of_finance" class="vessel-finance-calculator__label">Date of
                                    finance (dd/mm/yyyy)</label>
                                <input type="text" autocomplete="off"
                                       class="vessel-finance-calculator__text-input datepicker"
                                       name="date_of_finance" placeholder="Select date...">
                            </div>

                            <div class="vessel-finance-calculator__input-group vessel-finance-calculator__input-group--shrink">
                                <label for="percentage_of_finance" class="vessel-finance-calculator__label">Percentage of finance</label>
                                <input type="number" autocomplete="off"
                                       class="vessel-finance-calculator__text-input"
                                       name="percentage_of_finance" placeholder="Enter number...">
                            </div>

                            <div class="vessel-finance-calculator__input-group vessel-finance-calculator__input-group--shrink">
                                <input type="hidden" autocomplete="off" name="form_submitted" value="1">
                                <input type="hidden" autocomplete="off" name="ship" value="<?php echo $ship_db_slug ?>">
                                <input type="submit"
                                       class="vessel-finance-calculator__button depreciation-form__submit-button"
                                       name="submit" value="Calculate">
                            </div>
                        </form>

                        <div class="ajax-section ajax-section--vessel-finance-calculator"></div>
                    </div>

                </div>
            </section>

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Fixed Age Value | Graph <span
                                    class="help-icon tooltip--help hide--no-touch"
                                    title="Drag out an area to zoom. Tap a datapoint to view data. Tap a legend label to show/hide other datasets."></span>
                            <span class="help-icon tooltip--help hide--touch"
                                  title="Drag out an area to zoom. Hover over a datapoint to view data. Click a legend label to show/hide other datasets."></span>
                        </div>
                        <div class="box__header__sub-title content--fixed-age-value-years">
                            Data based on an average of quarter figures for each year
                        </div>
                    </div>
                    <div class="box__header__controls">
                        <div class="switch">
                            <div class="switch__option-group">
                                <button class="switch__option switch__option--quarters is-active"
                                        data-elements-to-show=".content--fixed-age-value-quarters"
                                        data-elements-to-hide=".content--fixed-age-value-years"
                                        onclick="resetZoom(['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years'], 'btn--reset-zoom--fixed-age-value')">
                                    Quarters
                                </button>
                                <button class="switch__option switch__option--years"
                                        data-elements-to-show=".content--fixed-age-value-years"
                                        data-elements-to-hide=".content--fixed-age-value-quarters"
                                        onclick="resetZoom(['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years'], 'btn--reset-zoom--fixed-age-value')">
                                    Years
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box__content">

                    <div class="graph-update-button-group">
                        <button onclick="resetZoom(['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years'], 'btn--reset-zoom--fixed-age-value')"
                                class="btn btn--graph-control btn--graph-update btn--reset-zoom--fixed-age-value">Reset
                            Zoom
                        </button>
                        <button onclick="clearAnnotations(['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years'], 'btn--clear-annotations--fixed-age-value')"
                                class="btn btn--graph-control btn--graph-update btn--clear-annotations--fixed-age-value">
                            Remove Line(s)
                        </button>
                    </div>


                    <div class="graphs-container">

                        <div class="graph-group graph-group--fixed-age-value-quarters content--fixed-age-value-quarters is-active">
                            <div class="graph-group__canvas-container">
                                <canvas class="graph graph__fixed-age-value-quarters"
                                        id="graph__fixed-age-value-quarters"></canvas>
                            </div>
                            <div id="quarters-legend-container"></div>
                        </div>

                        <div class="graph-group graph-group--fixed-age-value-years content--fixed-age-value-years">
                            <div class="graph-group__canvas-container">
                                <canvas class="graph graph__fixed-age-value-years"
                                        id="graph__fixed-age-value-years"></canvas>
                            </div>
                            <div id="years-legend-container"></div>
                        </div>

                    </div>


                </div>
            </section>

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Fixed Age Value | Data</div>
                        <div class="box__header__sub-title content--fixed-age-value-years">Data based on an
                            average of quarter figures for each year
                        </div>
                    </div>
                    <div class="box__header__controls">
                        <div class="toggle-switch">
                            <label for="view-fixed-age-value-trend-data" data-style="rounded" data-text="false"
                                   data-size="xs">
                                <input checked type="checkbox" id="view-fixed-age-value-trend-data"
                                       class="toggle-trend-data"
                                       data-class-to-toggle=".is-fixed-age-value-trend-data, .data-table__key--fixed-age-value">
                                <span class="toggle">
                                    <span class="switch"></span>
                                </span>
                                <span class="toggle-switch__label">View trend data</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="box__content box__content--scrollable" style="max-height: 25vh;">
					<?php get_template_part( 'template-parts/partials/partial', 'data-table-key', [ 'unique_class' => 'data-table__key--fixed-age-value' ] ); ?>


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

                        <tbody class="content--fixed-age-value-quarters is-active">
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
                                <td data-fixed-age-value-poly-data-target-id="quarters-0-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_new_build'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="quarters-1-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_5_year'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="quarters-2-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_10_year'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="quarters-3-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_15_year'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="quarters-4-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_20_year'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="quarters-5-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_25_year'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="quarters-6-<?php echo $key; ?>"><?php echo number_format( $ship_data['average_scrap'], 2 ); ?></td>
								<?php // explanation: data-fixed-age-value-poly-data-target-id="time_scale-JS_polynomial_dataset-data_index" ?>
                            </tr>
						<?php endforeach; ?>
                        </tbody>

                        <tbody class="content--fixed-age-value-years">
						<?php $year = 0;
						$key        = 0; // keep track of which key of the array corresponds to the current year's position
						foreach ( $fixed_age_value_table_data_years[ $ship_db_slug ] as $year => $ship_data ) : ?>
                            <tr>
                                <td><?php echo $year; ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-0-<?php echo $key; ?>"><?php echo number_format( $ship_data['new'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-1-<?php echo $key; ?>"><?php echo number_format( $ship_data['5yr'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-2-<?php echo $key; ?>"><?php echo number_format( $ship_data['10yr'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-3-<?php echo $key; ?>"><?php echo number_format( $ship_data['15yr'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-4-<?php echo $key; ?>"><?php echo number_format( $ship_data['20yr'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-5-<?php echo $key; ?>"><?php echo number_format( $ship_data['25yr'], 2 ); ?></td>
                                <td data-fixed-age-value-poly-data-target-id="years-6-<?php echo $key; ?>"><?php echo number_format( $ship_data['scrap'], 2 ); ?></td>
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

					<?php $market_notes = get_market_notes_by_ship_type( $ship_type_id ); ?>

					<?php if ( $market_notes->have_posts() ) : ?>

						<?php while ( $market_notes->have_posts() ) : $market_notes->the_post(); ?>
							<?php get_template_part( 'template-parts/partials/partial', 'market-note--ship-view', ['last_year_of_data' => $last_year_of_data]); ?>
						<?php endwhile;
						wp_reset_postdata(); ?>

					<?php else : ?>
                        No notes found.
					<?php endif; ?>

                </div>
            </section>
        </div>
    </div>

	<?php get_footer(); ?>

    <script>
        (function ($) {
            var ctxQuarters = document.getElementById('graph__fixed-age-value-quarters');
            var ctxYears = document.getElementById('graph__fixed-age-value-years');

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
                            //pointBackgroundColor: 'rgba(<?php //echo $colour; ?>//, 0.2)',
                            backgroundColor: [
								<?php foreach($dataset['data'] as $ds) : ?>
                                'rgba(<?php echo $colour; ?>, 0.2)',
								<?php endforeach; ?>
                            ],
                            borderWidth: 2,
                            spanGaps: true,
                            pointStyle: 'circle',
                            pointRadius: 3,
                            pointHitRadius: 10,
                            pointHoverRadius: 3,
                            pointHoverBorderColor: 'rgba(<?php echo $colour; ?>, 1)',
                            pointHoverBackgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                            lineTension: 0.3,
                        },
						<?php endforeach; ?>
                    ]
                },

                options: fixedAgeValue_chartOptions.quarters,

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
                pointHitRadius: 10,
                pointHoverRadius: 3,
                lineTension: 0.3,
                pointHoverBackgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                options: fixedAgeValue_chartOptions.quarters,
            });
            chartQuarters.update();

            // Reverse data as table data is descending while graph data is ascending
            var reversedPolyData = polynomialData['points'].reverse();
            // Append the polynomial data to the relevant data table cell
            reversedPolyData.forEach(function (data, index) {
                $('td[data-fixed-age-value-poly-data-target-id="quarters-' + dataGroupIndex + '-' + index + '"]').append('<br><span class="is-trend-data is-fixed-age-value-trend-data">' + data[1].toFixed(2) + '</span>');
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
                            pointHitRadius: 10,
                            pointHoverRadius: 3,
                            pointHoverBorderColor: 'rgba(<?php echo $colour; ?>, 1)',
                            pointHoverBackgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                            lineTension: 0.3,
                        },

						<?php endforeach; ?>

                    ]
                },

                options: fixedAgeValue_chartOptions.years,

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
                pointHitRadius: 10,
                pointHoverRadius: 3,
                lineTension: 0.3,
                options: fixedAgeValue_chartOptions.years,
            });
            chartYears.update();

            // Reverse data as table data is descending while graph data is ascending
            var reversedPolyData = polynomialData['points'].reverse();
            // Append the polynomial data to the relevant data table cell
            reversedPolyData.forEach(function (data, index) {
                $('td[data-fixed-age-value-poly-data-target-id="years-' + dataGroupIndex + '-' + index + '"]').append('<br><span class="is-depreciation-trend-data">' + data[1].toFixed(2) + '</span>');
            });

            dataGroupIndex++;

			<?php endforeach; ?>

			<?php reset( $graph_colours ); ?>

            // Generate custom legends for each graph
            generateCustomLegend(['graph__fixed-age-value-quarters'], '#quarters-legend-container', ['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years']);
            generateCustomLegend(['graph__fixed-age-value-years'], '#years-legend-container', ['graph__fixed-age-value-quarters', 'graph__fixed-age-value-years']);

            // Change graph options depending on window width
            // Run on page load
            changeGraphOptions(<?php echo $no_of_datasets; ?>);
            // Listen for screen resize and fire function
            window.addEventListener("resize", function () {
                changeGraphOptions(<?php echo $no_of_datasets; ?>);
            });





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
