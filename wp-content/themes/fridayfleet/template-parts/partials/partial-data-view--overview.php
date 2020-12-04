<?php

use FridayFleet\FridayFleetController;

$ff = new FridayFleetController;
?>

    <main id="primary" class="site__body page__overview">

        <div id="content-top"></div>

		<?php

		$ships                             = $ff->getShips();
		$graph_colours                     = $ff->getColours();
		$value_over_time_latest_data_point = $ff->getValueOverTimeLatestDataPoint( $ships );
		?>

        <div class="data-view">
            <div class="data-view__header">
                <h2 class="data-view__title">
                    Overview
                </h2>
            </div>

            <div class="data-view__cols data-view__cols--overview">

                <div class="data-view__main-col data-view__main-col--overview">

                    <section class="box">
                        <div class="box__header">
                            <div class="box__header__titles">
                                <div class="box__header__title--no-toggle">Market Notes</div>
                            </div>
                        </div>

                        <div class="box__content">
                            <div class="note" data-year="2020">
                                <div class="note__meta">
                                    <div class="note__meta__ship"><a href="/data-view?ship=5000" class="change-ship"
                                                                     data-ship="5000" data-page-type="data-view"
                                                                     data-show-data-view-select="1">5000 DWT</a></div>
                                </div>
                                <div class="note__timestamp has-note-indicator note-indicator--neutral">
                                    5 September 2019 <br>Note title here
                                </div>
                                <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                    do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam,
                                    quis
                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                            <div class="note" data-year="2014">
                                <div class="note__meta">
                                    <div class="note__meta__ship"><a href="/data-view?ship=3600" class="change-ship"
                                                                     data-ship="3600" data-page-type="data-view"
                                                                     data-show-data-view-select="1">3600 DWT</a>, <a
                                                href="/data-view?ship=8500" class="change-ship" data-ship="8500"
                                                data-page-type="data-view" data-show-data-view-select="1">8500 DWT</a>
                                    </div>
                                </div>
                                <div class="note__timestamp has-note-indicator note-indicator--negative">
                                    10 August 2018 <br>Note title here
                                </div>
                                <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                    do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam,
                                    quis
                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                            <div class="note" data-year="2013">
                                <div class="note__meta">
                                    <div class="note__meta__ship"><a href="/data-view?ship=3600" class="change-ship"
                                                                     data-ship="3600" data-page-type="data-view"
                                                                     data-show-data-view-select="1">3600 DWT</a></div>
                                </div>
                                <div class="note__timestamp has-note-indicator note-indicator--positive">
                                    1 June 2016 <br>Note title here
                                </div>

                                <div class="note__content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                    do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam,
                                    quis
                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                            </div>
                        </div>
                    </section>


                </div>

                <div class="data-view__side-col data-view__side-col--overview">

					<?php foreach ( $ships as $ship ) : ?>
                        <section class="box">
                            <a href="/data-view?ship=<?php echo $ship; ?>" class="box__full-size-link change-ship"
                               data-ship="<?php echo $ship; ?>" data-page-type="data-view"
                               data-show-data-view-select="1"></a>
                            <div class="box__header">
                                <div class="box__header__titles">
                                    <div class="box__header__title--no-toggle box__header__title--icon-ship">
										<?php echo $ship; ?> DWT
                                    </div>
                                </div>
                            </div>

                            <div class="box__content">
                                <div class="box__content__title">Value Over Time</div>

                                <table class="data-table data-table--first-col data-table--large-text"
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
                                                  style="color:rgb(<?php echo $graph_colours[6]; ?>)">&bull;</span>
                                            Scrap
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody class="content--value-over-time-quarters is-active">
									<?php $ship_data = $value_over_time_latest_data_point[ $ship ][0]; ?>
                                    <tr>
                                        <td><?php echo $ship_data['year'] . ' Q' . $ship_data['quarter']; ?></td>
                                        <td><?php echo number_format($ship_data['average_new_build'], 2); ?></td>
                                        <td><?php echo number_format($ship_data['average_5_year'], 2); ?></td>
                                        <td><?php echo number_format($ship_data['average_10_year'], 2); ?></td>
                                        <td><?php echo number_format($ship_data['average_15_year'], 2); ?></td>
                                        <td><?php echo number_format($ship_data['average_20_year'], 2); ?></td>
                                        <td><?php echo number_format($ship_data['average_25_year'], 2); ?></td>
                                        <td><?php echo number_format($ship_data['average_scrap'], 2); ?></td>
                                    </tr>
                                    </tbody>

                                </table>

                                <div class="note" data-year="2014">
                                    <div class="note__timestamp has-note-indicator note-indicator--positive">
                                        10 August 2018<br>Note title here
                                    </div>
                                </div>
                            </div>
                        </section>
					<?php endforeach; ?>

                </div>

            </div>

        </div>

    </main>

<?php get_footer(); ?>