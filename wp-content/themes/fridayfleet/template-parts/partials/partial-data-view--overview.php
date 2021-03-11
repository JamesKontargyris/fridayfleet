<?php

use FridayFleet\FridayFleetController;

$ff = new FridayFleetController;
?>

    <main id="primary" class="site__body page__overview">

        <div id="content-top"></div>

		<?php
		$ship_group_id = 0;

		if ( $_GET['group'] ) { // ship group ID is passed in as query var
			$ship_group_id = $_GET['group'];
		} else { // no query var passed in so get first ship group
			$all_ship_groups = get_ship_groups( 1 );
			while ( $all_ship_groups->have_posts() ) {
				$all_ship_groups->the_post();
				$ship_group_id = get_the_ID();
			}
			wp_reset_postdata();
		}

		$ship_group = get_post( $ship_group_id );
		?>

		<?php if ( ! $ship_group ) : // no ship group found ?>
            <div class="message message--error">ERROR: Invalid ship group.</div>
			<?php exit();
		endif; ?>



		<?php
		$ships         = get_field( 'ship_group_ship_types', $ship_group_id );
		$graph_colours = $ff->getColours();
		//		$fixed_age_value_latest_data_point = $ff->getFixedAgeValueLatestDataPoint( $ships );
		?>

        <div class="data-view">
            <div class="data-view__header">
                <h2 class="data-view__title">
                    <strong>Overview</strong> <span
                            class="data-view__title__divider">&rang;</span> <?php echo $ship_group->post_title; ?>
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

					<?php foreach ( $ships as $ship ) : $ship_type = get_post( $ship );
						$ship_type_db_slug = get_field( 'ship_type_database_slug', $ship_type->ID ); ?>
                        <section class="box">
                            <a href="/data-view?ship=<?php echo $ship_type_db_slug; ?>"
                               class="box__full-size-link change-ship"
                               data-ship="<?php echo $ship_type_db_slug; ?>" data-page-type="data-view"
                               data-show-data-view-select="1"></a>
                            <div class="box__header">
                                <div class="box__header__titles">
                                    <div class="box__header__title--no-toggle box__header__title--icon-ship">
										<?php echo get_the_title( $ship_type->ID ); ?> <span
                                                class="box__header__title__divider">&rang;</span>
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
									<?php $ship_data = $ff->getFixedAgeValueLatestDataPoint( $ship_type_db_slug ); ?>
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
								$latest_market_note = get_market_notes_by_ship_type_id( $ship_type->ID, 1 );
								while ( $latest_market_note->have_posts() ) : $latest_market_note->the_post();
									?>

                                    <?php get_template_part('template-parts/partials/partial', 'market-note--short'); ?>

								<?php endwhile;
								wp_reset_postdata(); ?>

                            </div>
                        </section>
					<?php endforeach; ?>

                </div>

            </div>

        </div>

    </main>

<?php get_footer(); ?>