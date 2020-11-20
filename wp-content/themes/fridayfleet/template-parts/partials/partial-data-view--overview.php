<?php

use FridayFleet\FridayFleetController;

$ff = new FridayFleetController;
?>

<main id="primary" class="site__body page__overview">

    <div id="content-top"></div>

	<?php

	$ships                               = $ff->getShips();
	$graph_colours                       = $ff->getColours();
	$value_over_time_graph_data_quarters = $ff->getValueOverTimeDataForGraph( $ships, 'quarters' );
	$value_over_time_graph_data_years    = $ff->getValueOverTimeDataForGraph( $ships, 'years' );
	$value_over_time_table_data_quarters = $ff->getValueOverTimeDataForTable( $ships, 'quarters' );
	$value_over_time_table_data_years    = $ff->getValueOverTimeDataForTable( $ships, 'years' );
	?>

    <div class="data-view">
        <div class="data-view__header">
            <h2 class="data-view__title">
                Overview
            </h2>
            <div class="data-view__controls">
                <button class="btn btn--key">Key</button>
            </div>
        </div>

        <div class="data-view__main-col">

            <div class="data-view__legend">
                <ul class="data-view__legend__labels">
                    <li><span style="color:rgb(<?php echo $graph_colours[0]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> New
                    </li>
                    <li><span style="color:rgb(<?php echo $graph_colours[1]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> 5yr
                    </li>
                    <li><span style="color:rgb(<?php echo $graph_colours[2]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> 10yr
                    </li>
                    <li><span style="color:rgb(<?php echo $graph_colours[3]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> 15yr
                    </li>
                    <li><span style="color:rgb(<?php echo $graph_colours[4]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> 20yr
                    </li>
                    <li><span style="color:rgb(<?php echo $graph_colours[5]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> 25yr
                    </li>
                    <li><span style="color:rgb(<?php echo $graph_colours[6]; ?>);"
                              class="data-view__legend__colour-circle">&bull;</span> Scrap
                    </li>
                </ul>
            </div>

            <div class="box-group">

				<?php foreach ( $ships as $ship ) : ?>
                    <section class="box">
                        <div class="box__header">
                            <div class="box__header__titles">
                                <div class="box__header__title--no-toggle box__header__title--icon-ship">
                                    <strong><?php echo $ship; ?></strong>
                                    &rang; Value Over Time
                                </div>
                            </div>
                        </div>

                        <div class="box__content">

                            <div id="graphs" class="graphs-container">

                                <div class="graph-group__canvas-container">
                                    <canvas class="graph graph__value-over-time-years"
                                            id="graph__value-over-time-years--<?php echo $ship; ?>"></canvas>
                                </div>

                            </div>


                        </div>
                    </section>
				<?php endforeach; ?>

            </div>


        </div>

        <div class="data-view__side-col">

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title--no-toggle">Recent Notes</div>
                    </div>
                </div>

                <div class="box__content">
                    <div class="note" data-year="2020">
                        <div class="note__meta">
                            <div class="note__meta__ship">5000</div>
                        </div>
                        <div class="note__timestamp has-note-indicator note-indicator--neutral">
                            5 September 2019 <br>Optional note title here
                        </div>
                        <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                            do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis
                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                    <div class="note" data-year="2014">
                        <div class="note__meta">
                            <div class="note__meta__ship">8500</div>
                        </div>
                        <div class="note__timestamp has-note-indicator note-indicator--negative">
                            10 August 2018 <br>Optional note title here
                        </div>
                        <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                            do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis
                            nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                    <div class="note" data-year="2013">
                        <div class="note__meta">
                            <div class="note__meta__ship">3600</div>
                        </div>
                        <div class="note__timestamp has-note-indicator note-indicator--positive">
                            1 June 2016 <br>Optional note title here
                        </div>

                        <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                            do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis
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

		<?php foreach($ships as $ship) : ?>

        var ctxValueOverTime<?php echo $ship; ?> = document.getElementById('graph__value-over-time-years--<?php echo $ship; ?>'),
            chartValueOverTime<?php echo $ship; ?> = new Chart(ctxValueOverTime<?php echo $ship; ?>, {
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
                            pointRadius: 2,
                            lineTension: 0.4,
                            spanGaps: true,
                        },

						<?php endif; ?>

						<?php endforeach; ?>

                    ]
                },

                options: chartOptionsOverview,

            });

		<?php endforeach; ?>

    })(jQuery);
</script>