<?php

use FridayFleet\FridayFleetController;

$ff = new FridayFleetController;

$ship_group_id = get_the_ID();
$ships         = get_ships_by_ship_group( $ship_group_id );
$graph_colours = $ff->getColours();
?>

<div class="data-view">
    <div class="data-view__header">
        <h2 class="data-view__title data-view__title--icon-grid">
            <strong>Overview</strong>
            <span class="data-view__title__divider">&rang;</span> <?php the_title(); ?>
        </h2>
    </div>

    <div class="data-view__cols data-view__cols--overview">

        <div class="data-view__main-col data-view__main-col--overview">

            <section class="box">
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title--no-toggle">Latest Market Notes</div>
                    </div>
                </div>

                <div class="box__content">
					<?php $market_notes = get_market_notes( 3 ); ?>

					<?php if ( $market_notes->have_posts() ) : ?>

						<?php while ( $market_notes->have_posts() ) : $market_notes->the_post(); ?>
							<?php get_template_part( 'template-parts/partials/partial', 'market-note--overview' ); ?>
						<?php endwhile;
						wp_reset_postdata(); ?>

					<?php else : ?>
                        No notes found.
					<?php endif; ?>


                </div>
            </section>


        </div>

        <div class="data-view__side-col data-view__side-col--overview">

			<?php while($ships->have_posts()) : $ships->the_post(); ?>
            <section class="box">
                <a href="<?php echo get_the_permalink(); ?>" class="box__full-size-link"></a>
                <div class="box__header">
                    <div class="box__header__titles">
                        <div class="box__header__title--no-toggle box__header__title--icon-ship">
							<?php the_title(); ?>
                            <span class="box__header__title__divider">&rang;</span>
                            Fixed Age Value
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
                                      style="color:rgb(<?php echo $graph_colours[6]; ?>)">&bull;</span>
                                Scrap
                            </th>
                        </tr>
                        </thead>

                        <tbody class="is-active">
						<?php $ship_data = $ff->getFixedAgeValueLatestDataPoint( get_field( 'ship_type_database_slug' ) ); ?>
                        <tr>
                            <td><?php echo $ship_data['year'] . ' Q' . $ship_data['quarter']; ?></td>
                            <td><?php echo number_format( $ship_data['average_new_build'], 2 ); ?></td>
                            <td><?php echo number_format( $ship_data['average_5_year'], 2 ); ?></td>
                            <td><?php echo number_format( $ship_data['average_10_year'], 2 ); ?></td>
                            <td><?php echo number_format( $ship_data['average_15_year'], 2 ); ?></td>
                            <td><?php echo number_format( $ship_data['average_20_year'], 2 ); ?></td>
                            <td><?php echo number_format( $ship_data['average_25_year'], 2 ); ?></td>
                            <td><?php echo number_format( $ship_data['average_scrap'], 2 ); ?></td>
                        </tr>
                        </tbody>

                    </table>

					<?php
					$latest_market_note = get_market_notes_by_ship_type( get_the_ID(), 1 );
					while ( $latest_market_note->have_posts() ) : $latest_market_note->the_post();
						?>

						<?php get_template_part( 'template-parts/partials/partial', 'market-note--short' ); ?>

					<?php endwhile;
					wp_reset_postdata(); ?>

                </div>
            </section>
            <?php endwhile; wp_reset_postdata(); ?>

        </div>

    </div>

