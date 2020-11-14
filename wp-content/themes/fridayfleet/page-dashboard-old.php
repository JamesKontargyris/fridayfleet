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
?>

<main id="primary" class="site-main">

    <div class="dashboard">
        <nav class="nav-bar">
            <ul class="nav-bar__menu">
				<?php $first_item = 1;
				foreach ( $ships as $ship ) : ?>
                    <li class="nav-bar__menu__item">
                        <a class="nav-bar__menu__link change-ship <?php if ( $first_item ) : ?>is-active<?php $first_item = 0; endif; ?>"
                           href="#" data-ship="<?php echo $ship; ?>">
							<?php echo $ship; ?>
                        </a>
                    </li>
				<?php endforeach; ?>
            </ul>
        </nav>

        <div class="section-title-with-switcher">

            <h4 class="section-title">Value over time</h4>
            <ul class="switcher">
                <li class="switcher__option is-active"
                    data-switcher-element-to-hide=".switcher--graph-by-year, .switcher--data-table-by-year"
                    data-switcher-element-to-show=".switcher--graph-by-quarter, .switcher--data-table-by-quarter">
                    <a href="#" class="switcher__option__link">Quarters</a>
                </li>
                <li class="switcher__option"
                    data-switcher-element-to-hide=".switcher--graph-by-quarter, .switcher--data-table-by-quarter"
                    data-switcher-element-to-show=".switcher--graph-by-year, .switcher--data-table-by-year">
                    <a href="#" class="switcher__option__link">Years</a>
                </li>
            </ul>

        </div>

		<?php $first_item = 1;
		foreach ( $ships as $ship ) : ?>

            <div class="box ship-content ship-content--<?php echo $ship; ?> <?php if ( $first_item ) : ?>is-shown<?php else : ?>is-hidden<?php endif; ?>">

            </div>

			<?php $first_item = 0; endforeach; ?>

        <a class="h5 toggler" data-element-to-toggle=".data-tables-container">Data Table</a>

        <div class="data-tables-container">

			<?php $first_item = 1;
			foreach ( $ships as $ship ) : ?>

                <div class="box ship-content ship-content--<?php echo $ship; ?> <?php if ( $first_item ) : ?>is-shown<?php else : ?>is-hidden<?php endif; ?>">

                    <table class="data-table data-table--first-col data-table--value-over-time-years switcher--data-table-by-year"
                           cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <td>Time</td>
                            <td>New</td>
                            <td>5yr</td>
                            <td>10yr</td>
                            <td>15yr</td>
                            <td>20yr</td>
                            <td>25yr</td>
                            <td>Scrap</td>
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

                    <table class="data-table data-table--first-col data-table--value-over-time-quarters switcher--data-table-by-quarter is-active"
                           cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <td>Time</td>
                            <td>New</td>
                            <td>5yr</td>
                            <td>10yr</td>
                            <td>15yr</td>
                            <td>20yr</td>
                            <td>25yr</td>
                            <td>Scrap</td>
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

                </div>

			<?php $first_item = 0; endforeach; ?>

        </div>


    </div>

</main><!-- #main -->

<?php get_footer(); ?>


<script>
    (function () {
		<?php foreach($ships as $ship) : reset( $graph_colours ); ?>
        var ctxDesktopQuarters = document.getElementById('graph__value-over-time-quarters__desktop--<?php echo $ship; ?>');
        var ctxDesktopYears = document.getElementById('graph__value-over-time-years__desktop--<?php echo $ship; ?>');

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
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.5)",
                            lineStyle: "solid",
                            width: 2
                        }

                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptionsMobile,
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
                        trendlineLinear: {
                            style: "rgba(<?php echo $colour; ?>, 0.5)",
                            lineStyle: "solid",
                            width: 2
                        }
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptionsMobile,
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
                        borderWidth: 2,
                        spanGaps: true,
                        pointStyle: 'circle',
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptionsTablet
        });

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
                        borderWidth: 2,
                        spanGaps: true,
                        pointStyle: 'circle',
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptionsTablet
        });

		<?php reset( $graph_colours ); ?>

        // Desktop charts
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
                        spanGaps: true,
                        pointStyle: 'circle',
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptionsDesktop
        });

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
                        spanGaps: true,
                        pointStyle: 'circle',
                    },

					<?php endforeach; ?>
                ]
            },
            options: chartOptionsDesktop
        });

		<?php endforeach; ?>
    })();
</script>
