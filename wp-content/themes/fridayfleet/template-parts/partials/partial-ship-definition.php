<?php if ( isset( $args ) && $args['ship_type_id'] ) : ?>

	<?php
	$ship_type_id          = esc_html( $args['ship_type_id'] );
	$ship_definition_intro = get_field( 'ship_definition_intro', $ship_type_id );
	?>

	<?php if ( $ship_definition_intro || have_rows( 'ship_definition_data_table', $ship_type_id ) ) : ?>

        <div class="box box--is-closed">
            <div class="box__header">
                <div class="box__header__titles">
                    <div class="box__header__title">Ship Definition</div>
                </div>
            </div>
            <div class="box__content box__content--medium-font-size">
				<?php if ( $ship_definition_intro ) : ?>
                    <p><?php echo $ship_definition_intro; ?></p>
				<?php endif; ?>

				<?php if ( have_rows( 'ship_definition_data_table', $ship_type_id ) ) : ?>
                    <table cellspacing="0" cellpadding="0" border="0" class="data-table data-table--first-col data-table--standard-font-size">
                        <tbody class="is-active">
						<?php while ( have_rows( 'ship_definition_data_table', $ship_type_id ) ) : the_row(); ?>
                            <tr>
                                <td><?php the_sub_field( 'ship_definition_data_table_label' ); ?></td>
                                <td><?php the_sub_field( 'ship_definition_data_table_value' ); ?></td>
                            </tr>
						<?php endwhile;
						wp_reset_postdata(); ?>
                        </tbody>
                    </table>
				<?php endif; ?>
            </div>
        </div>

	<?php endif; ?>

<?php endif;
