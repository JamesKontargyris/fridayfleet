<?php

ini_set( 'xdebug.var_display_max_depth', '10' );
ini_set( 'xdebug.var_display_max_children', '256' );
ini_set( 'xdebug.var_display_max_data', '1024' );

use FridayFleet\FridayFleetController;

get_header(); ?>

<?php
$ff                                  = new FridayFleetController;
$ships                               = $ff->getShips();
$graph_colours                       = $ff->getColours();
$value_over_time_graph_data_quarters = $ff->getValueOverTimeDataForGraph( $ships, 'quarters' );
$value_over_time_graph_data_years    = $ff->getValueOverTimeDataForGraph( $ships, 'years' );
$value_over_time_table_data_quarters = $ff->getValueOverTimeDataForTable( $ships, 'quarters' );
$value_over_time_table_data_years    = $ff->getValueOverTimeDataForTable( $ships, 'years' );

$ship = '3600';

// Get number of datasets
$no_of_datasets = 0;
foreach($value_over_time_graph_data_years[$ship] as $dataset) {
    if(array_key_exists('data', $dataset)) {
        $no_of_datasets++;
    }
}

// Get last year of data
// Used to ensure annotations don't go off the edge of the years chart
$last_year = 0;
foreach($value_over_time_table_data_years[$ship] as $year => $dataset) {
    $last_year = $year;
}
?>

<main id="primary" class="site__main">

    <div id="content-top"></div>

    <div class="tab tab--3600">
        <div class="tab__header--sticky">

            <div class="tab__header">
                <h2 class="tab__title">
                    <strong class="tab__title--icon-ship">3600</strong>
                    <span class="tab__title__divider">&rang;</span> Value Over Time
                </h2>

                <div class="tab__controls">
                    <div class="switch">
                        <div class="switch__option-group">
                            <button class="switch__option switch__option--quarters is-active"
                                    data-elements-to-show=".content--value-over-time-quarters"
                                    data-elements-to-hide=".content--value-over-time-years" onclick="resetZoom()">
                                Quarters
                            </button>
                            <button class="switch__option switch__option--years"
                                    data-elements-to-show=".content--value-over-time-years"
                                    data-elements-to-hide=".content--value-over-time-quarters" onclick="resetZoom()">
                                Years
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="box-group">
            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Graph <span class="help-icon tooltip--help hide--no-touch"
                                                                    title="Pinch and drag to zoom in/out and scroll. Tap a datapoint to view data. Tap a legend label to show/hide a dataset."></span>
                            <span class="help-icon tooltip--help hide--touch"
                                  title="Use your mouse wheel/gestures to zoom in/out and scroll. Click a datapoint to view data. Click a legend label to show/hide a dataset."></span>
                        </div>
                        <div class="box__header__sub-title content--value-over-time-years">Data based on an average of
                            quarter figures for each year
                        </div>
                    </div>
                </div>

                <div class="box__content">

                    <button onclick="resetZoom()" class="btn btn--reset-zoom">Reset Zoom</button>

                    <div id="graphs" class="graphs-container">

                        <div class="graph-group graph-group--value-over-time-quarters content--value-over-time-quarters is-active">
                            <div class="graph-group__canvas-container">
                                <canvas class="graph graph__value-over-time-quarters"
                                        id="graph__value-over-time-quarters--3600"></canvas>
                            </div>
                        </div>

                        <div class="graph-group graph-group--value-over-time-years content--value-over-time-years">
                            <div class="graph-group__canvas-container">
                                <canvas class="graph graph__value-over-time-years"
                                        id="graph__value-over-time-years--3600"></canvas>
                            </div>
                        </div>

                    </div>


                </div>
            </section>

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Data</div>
                        <div class="box__header__sub-title content--value-over-time-years">Data based on an average of
                            quarter figures for each year
                        </div>
                    </div>
                </div>

                <div class="box__content">

                    <table class="data-table data-table--first-col"
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
						<?php $year = 0;
						foreach ( $value_over_time_table_data_quarters[ $ship ] as $ship_data ) : ?>
							<?php if ( $year != $ship_data['year'] ) : $year = $ship_data['year']; ?>
                                <tr class="data-table__sub-title">
                                    <td colspan="8"><?php echo $ship_data['year']; ?></td>
                                </tr>
							<?php endif; ?>
                            <tr>
                                <td><?php echo 'Q' . $ship_data['quarter']; ?></td>
                                <td><?php echo $ship_data['new_build']; ?></td>
                                <td><?php echo $ship_data['average_5_year']; ?></td>
                                <td><?php echo $ship_data['average_10_year']; ?></td>
                                <td><?php echo $ship_data['average_15_year']; ?></td>
                                <td><?php echo $ship_data['average_20_year']; ?></td>
                                <td><?php echo $ship_data['average_25_year']; ?></td>
                                <td><?php echo $ship_data['average_scrap']; ?></td>
                            </tr>
						<?php endforeach; ?>
                        </tbody>

                        <tbody class="content--value-over-time-years">
						<?php $year = 0;
						foreach ( $value_over_time_table_data_years[ $ship ] as $year => $ship_data ) : ?>
                            <tr>
                                <td><?php echo $year; ?></td>
                                <td><?php echo $ship_data['new']; ?></td>
                                <td><?php echo $ship_data['5yr']; ?></td>
                                <td><?php echo $ship_data['10yr']; ?></td>
                                <td><?php echo $ship_data['15yr']; ?></td>
                                <td><?php echo $ship_data['20yr']; ?></td>
                                <td><?php echo $ship_data['25yr']; ?></td>
                                <td><?php echo $ship_data['scrap']; ?></td>
                            </tr>
						<?php endforeach; ?>
                        </tbody>

                    </table>

                </div>
            </section>

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Notes</div>
                    </div>
                </div>

                <div class="box__content">
                    <div class="note" data-year="2020">
                        <div class="note__timestamp has-note-indicator note-indicator--neutral">1 February 2020 <span class="text--red">/</span> Optional note title here
                            <a href="#content-top" onclick="addAnnotationVertical('2020', '02', '01', '1 February 2020')"
                               class="btn--plot-on-graph scroll-to-link">Plot on graph</a></div>
                        <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                    <div class="note" data-year="2014">
                        <div class="note__timestamp has-note-indicator note-indicator--negative">10 August 2014 <span class="text--red">/</span> Optional note title here
                            <a href="#content-top" onclick="addAnnotationVertical('2014', '08', '10', '10 August 2014')"
                               class="btn--plot-on-graph scroll-to-link">Plot on graph</a></div>
                        <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                    <div class="note" data-year="2013">
                        <div class="note__timestamp has-note-indicator note-indicator--positive">Q3 2013 <span class="text--red">/</span> Optional note title here</div>
                        <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</main>

<?php get_footer(); ?>


<script>
    (function ($) {
        var ctxQuarters = document.getElementById('graph__value-over-time-quarters--<?php echo $ship; ?>');
        var ctxYears = document.getElementById('graph__value-over-time-years--<?php echo $ship; ?>');

        var chartQuarters = new Chart(ctxQuarters, {
            type: 'line',
            data: {
                datasets: [
					<?php foreach($value_over_time_graph_data_quarters[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>
					<?php if($dataset['data']) : ?>

                    {
                        label: '<?php echo $dataset['label']; ?>',
                        data: [
							<?php foreach($dataset['data'] as $x => $y) : ?>
							<?php if($y) : ?>
                            {x: moment('<?php echo $x; ?>', "YYYYMM"), y: <?php echo $y; ?>},
							<?php endif; ?>
							<?php endforeach; ?>
                        ],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 2,
                        spanGaps: true,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        lineTension: 0.3,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }

                    },

					<?php endif; ?>

					<?php endforeach; ?>
                ]
            },

            options: chartOptionsQuarters,

        });


		<?php reset( $graph_colours ); ?>

        var chartYears = new Chart(ctxYears, {
            type: 'line',
            data: {
                datasets: [
					<?php foreach($value_over_time_graph_data_years[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

					<?php if($dataset['data']) : ?>

                    {
                        label: '<?php echo $dataset['label']; ?>',
                        data: [
							<?php foreach($dataset['data'] as $x => $y) : ?>
                            {x: moment('<?php echo $x; ?>', "YYYY"), y: <?php echo $y; ?>},
							<?php endforeach; ?>
                        ],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 2,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        lineTension: 0.3,
                    },

					<?php endif; ?>

					<?php endforeach; ?>

                ]
            },

            options: chartOptionsYears,

        });

        window.resetZoom = function () {
            chartQuarters.resetZoom();
            chartYears.resetZoom();
            document.getElementsByClassName('btn--reset-zoom')[0].classList.remove('is-active');
        };

        window.addAnnotationVertical = function (year, month, day, text) {
            var line = year + ' ' + month + ' ' + day;
            var quarterGraphValue = year + ' ' + month + ' ' + day;

            // If annotation will go off the edge of the chart,
            // position it at the right-edge
            if(year >= <?php echo $last_year; ?>) {
                var yearGraphValue = <?php echo $last_year; ?> + ' 01 01';
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
                        rotation:90,
                        xAdjust: -12,
                    }
            };
            chartQuarters.options.annotation.annotations = [newAnnotation];
            chartQuarters.update();

            // Update the value for the years chart
            newAnnotation.value = yearGraphValue;
            chartYears.options.annotation.annotations = [newAnnotation];
            chartYears.update();
        }

        // Change the graph options based on window size
        function changeGraphOptions() {
            // Get width and height of the window excluding scrollbars
            var w = document.documentElement.clientWidth;

            if (w <= 767) {
                for(var i = 0; i < <?php echo $no_of_datasets; ?>; i++) {
                    chartQuarters.data.datasets[i].borderWidth = 1;
                    chartYears.data.datasets[i].borderWidth = 1;

                    chartQuarters.data.datasets[i].pointRadius = 2;
                    chartYears.data.datasets[i].pointRadius = 2;
                }
            } else {
                for(var i = 0; i < <?php echo $no_of_datasets; ?>; i++) {
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