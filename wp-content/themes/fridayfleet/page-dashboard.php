<?php

use FridayFleet\FridayFleetController;

get_header(); ?>

<?php
$ff                                  = new FridayFleetController;
$ships                               = $ff->getShips();
$graph_colours                       = $ff->getColours();
$value_over_time_graph_data_years    = $ff->getValueOverTime_GraphData( $ships, 'years' );
$value_over_time_graph_data_quarters = $ff->getValueOverTime_GraphData( $ships, 'quarters' );
$value_over_time_table_data_years    = $ff->getValueOverTime_TableData( $ships, 'years' );
$value_over_time_table_data_quarters = $ff->getValueOverTime_TableData( $ships, 'quarters' );
$xaxis_labels_years                  = $ff->getValueOverTime_XAxisLabels( $ships, 'years' );
$xaxis_labels_quarters               = $ff->getValueOverTime_XAxisLabels( $ships, 'quarters' );

$ship = '3600';
?>

<main id="primary" class="site__main">

    <div class="tab tab--3600">
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
                                data-elements-to-hide=".content--value-over-time-years" onclick="resetZoom()">Quarters
                        </button>
                        <button class="switch__option switch__option--years"
                                data-elements-to-show=".content--value-over-time-years"
                                data-elements-to-hide=".content--value-over-time-quarters" onclick="resetZoom()">Years
                        </button>
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
                    </div>
                </div>

                <div class="box__content">

                    <button onclick="resetZoom()" class="btn btn--reset-zoom">Reset Zoom</button>

                    <div class="graph-group graph-group--value-over-time-quarters content--value-over-time-quarters is-active">
                        <canvas class="graph graph__value-over-time-quarters graph--mobile"
                                id="graph__value-over-time-quarters__mobile--3600"
                                width="600" height="800"></canvas>
                        <canvas class="graph graph__value-over-time-quarters graph--tablet"
                                id="graph__value-over-time-quarters__tablet--3600"
                                width="600" height="600"></canvas>
                        <canvas class="graph graph__value-over-time-quarters graph--desktop"
                                id="graph__value-over-time-quarters__desktop--3600" width="600" height="300"></canvas>
                    </div>

                    <div class="graph-group graph-group--value-over-time-years content--value-over-time-years">
                        <canvas class="graph graph__value-over-time-years graph--mobile"
                                id="graph__value-over-time-years__mobile--3600"
                                width="600" height="800"></canvas>
                        <canvas class="graph graph__value-over-time-years graph--tablet"
                                id="graph__value-over-time-years__tablet--3600"
                                width="600" height="600"></canvas>
                        <canvas class="graph graph__value-over-time-years graph--desktop"
                                id="graph__value-over-time-years__desktop--3600" width="600" height="300"></canvas>
                    </div>


                </div>
            </section>

            <section class="box box--is-closed">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Data</div>
                    </div>
                </div>

                <div class="box__content">

                    <table class="data-table data-table--first-col data-table--value-over-time-quarters content--value-over-time-quarters is-active"
                           cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <th>Yr/Q</th>
                            <th>New</th>
                            <th>5yr</th>
                            <th>10yr</th>
                            <th>15yr</th>
                            <th>20yr</th>
                            <th>25yr</th>
                            <th>Scrap</th>
                        </tr>
                        </thead>
                        <tbody>
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
                    </table>

                    <table class="data-table data-table--first-col data-table--value-over-time-years content--value-over-time-years"
                           cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>New</th>
                            <th>5yr</th>
                            <th>10yr</th>
                            <th>15yr</th>
                            <th>20yr</th>
                            <th>25yr</th>
                            <th>Scrap</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php $year = 0;
						foreach ( $value_over_time_table_data_years[ $ship ] as $ship_data ) : ?>
                            <tr>
                                <td><?php echo $ship_data['year']; ?></td>
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
                    </table>

                </div>
            </section>

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title">Comments</div>
                    </div>
                </div>

                <div class="box__content">
                    Comments
                </div>
            </section>
        </div>
    </div>

</main>

<?php get_footer(); ?>


<script>
    (function ($) {
        // Mobile charts
        var ctxMobileQuarters = document.getElementById('graph__value-over-time-quarters__mobile--<?php echo $ship; ?>');
        var ctxMobileYears = document.getElementById('graph__value-over-time-years__mobile--<?php echo $ship; ?>');

        var mobileChartQuarters = new Chart(ctxMobileQuarters, {
            type: 'line',
            data: {
                labels: [<?php echo $xaxis_labels_quarters[ $ship ]; ?>],
                datasets: [
					<?php foreach($value_over_time_graph_data_quarters[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['data_label']; ?>',
                        data: [<?php echo $dataset['data']; ?>],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 1,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 2,
                        lineTension: 0.2,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }

                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptions,
            plugins: chartOptionsPlugins
        });

		<?php reset( $graph_colours ); ?>

        var mobileChartYears = new Chart(ctxMobileYears, {
            type: 'line',
            data: {
                labels: [<?php echo $xaxis_labels_years[ $ship ]; ?>],
                datasets: [
					<?php foreach($value_over_time_graph_data_years[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['data_label']; ?>',
                        data: [<?php echo $dataset['data']; ?>],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 1,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 2,
                        lineTension: 0.3,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptions,
            plugins: chartOptionsPlugins
        });

		<?php reset( $graph_colours ); ?>

        // Tablet charts
        var ctxTabletQuarters = document.getElementById('graph__value-over-time-quarters__tablet--<?php echo $ship; ?>');
        var ctxTabletYears = document.getElementById('graph__value-over-time-years__tablet--<?php echo $ship; ?>');

        var tabletChartQuarters = new Chart(ctxTabletQuarters, {
            type: 'line',
            data: {
                labels: [<?php echo $xaxis_labels_quarters[ $ship ]; ?>],
                datasets: [
					<?php foreach($value_over_time_graph_data_quarters[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['data_label']; ?>',
                        data: [<?php echo $dataset['data']; ?>],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 1.5,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        lineTension: 0.3,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }

                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptions,
            plugins: chartOptionsPlugins
        });

		<?php reset( $graph_colours ); ?>

        var tabletChartYears = new Chart(ctxTabletYears, {
            type: 'line',
            data: {
                labels: [<?php echo $xaxis_labels_years[ $ship ]; ?>],
                datasets: [
					<?php foreach($value_over_time_graph_data_years[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['data_label']; ?>',
                        data: [<?php echo $dataset['data']; ?>],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 1.5,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        lineTension: 0.3,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptions,
            plugins: chartOptionsPlugins
        });

		<?php reset( $graph_colours ); ?>

        // Desktop charts
        var ctxDesktopQuarters = document.getElementById('graph__value-over-time-quarters__desktop--<?php echo $ship; ?>');
        var ctxDesktopYears = document.getElementById('graph__value-over-time-years__desktop--<?php echo $ship; ?>');

        var desktopChartQuarters = new Chart(ctxDesktopQuarters, {
            type: 'line',
            data: {
                labels: [<?php echo $xaxis_labels_quarters[ $ship ]; ?>],
                datasets: [
					<?php foreach($value_over_time_graph_data_quarters[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['data_label']; ?>',
                        data: [<?php echo $dataset['data']; ?>],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 2,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        lineTension: 0.3,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }

                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptions,
            plugins: chartOptionsPlugins
        });

		<?php reset( $graph_colours ); ?>

        var desktopChartYears = new Chart(ctxDesktopYears, {
            type: 'line',
            data: {
                labels: [<?php echo $xaxis_labels_years[ $ship ]; ?>],
                datasets: [
					<?php foreach($value_over_time_graph_data_years[ $ship ] as $dataset) : ?>
					<?php $colour = ( ! current( $graph_colours ) ) ? reset( $graph_colours ) : current( $graph_colours ); next( $graph_colours ); ?>

                    {
                        label: '<?php echo $dataset['data_label']; ?>',
                        data: [<?php echo $dataset['data']; ?>],
                        fill: false,
                        borderColor: 'rgba(<?php echo $colour; ?>, 1)',
                        backgroundColor: 'rgba(<?php echo $colour; ?>, 1)',
                        borderWidth: 2,
                        spanGaps: false,
                        pointStyle: 'circle',
                        pointRadius: 3,
                        lineTension: 0.3,
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.3)",
                            lineStyle: "solid",
                            width: 2,
                        }
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptions,
            plugins: chartOptionsPlugins
        });

		<?php reset( $graph_colours ); ?>

        window.resetZoom = function () {
            mobileChartQuarters.resetZoom();
            mobileChartYears.resetZoom();
            tabletChartQuarters.resetZoom();
            tabletChartYears.resetZoom();
            desktopChartQuarters.resetZoom();
            desktopChartYears.resetZoom();
            document.getElementsByClassName('btn--reset-zoom')[0].classList.remove('is-active');
        };

    })(jQuery);
</script>