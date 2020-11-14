<?php
/**
 * Handles Repeater filters.
 *
 * @package Genesis\CustomBlocksPro
 */

namespace Genesis\CustomBlocksPro\Blocks;

use Genesis\CustomBlocks\Blocks\Block;
use Genesis\CustomBlocks\Blocks\Field;
use Genesis\CustomBlocks\ComponentAbstract;

/**
 * Class RepeaterFilter
 */
class RepeaterFilter extends ComponentAbstract {

	/**
	 * Initiates the class.
	 */
	public function init() {}

	/**
	 * Registers all the hooks.
	 */
	public function register_hooks() {
		add_filter( 'genesis_custom_blocks_field_to_array', [ $this, 'to_array_sub_fields' ], 10, 2 );
		add_filter( 'genesis_custom_blocks_settings_from_array', [ $this, 'from_array_sub_fields' ] );
		add_filter( 'genesis_custom_blocks_template_attributes', [ $this, 'add_default_values' ], 10, 2 );
		add_action( 'genesis_custom_blocks_render_field', [ $this, 'render_sub_rows' ], 10, 2 );
		add_filter( 'genesis_custom_blocks_block_to_save', [ $this, 'save_repeater_fields' ], 10, 5 );
		add_action( 'genesis_custom_blocks_render_field_templates', [ $this, 'add_repeater_template' ], 10, 5 );
	}

	/**
	 * Handles the sub-fields setting used by the Repeater when converting to an array.
	 *
	 * @param array $config   The field config.
	 * @param array $settings The field settings.
	 * @return array $config The filtered field config, with any sub_fields added.
	 */
	public function to_array_sub_fields( $config, $settings ) {
		if ( ! isset( $settings['sub_fields'] ) ) {
			return $config;
		}

		foreach ( $settings['sub_fields'] as $key => $field ) {
			if ( method_exists( $field, 'to_array' ) ) {
				$config['sub_fields'][ $key ] = $field->to_array();
			}
		}

		return $config;
	}

	/**
	 * Handles the sub-fields setting used by the Repeater when converting from an array.
	 *
	 * @param array $settings The field settings.
	 * @return array $settings The filtered field settings, with any sub_fields added.
	 */
	public function from_array_sub_fields( $settings ) {
		if ( ! isset( $settings['sub_fields'] ) ) {
			return $settings;
		}

		foreach ( $settings['sub_fields'] as $key => $field ) {
			$settings['sub_fields'][ $key ] = new Field( $field );
		}

		return $settings;
	}

	/**
	 * Adds the default values for the Repeater.
	 *
	 * @param array   $attributes The block attributes.
	 * @param Field[] $fields     The block fields.
	 * @return array $attributes The filtered attributes.
	 */
	public function add_default_values( $attributes, $fields ) {
		if ( is_admin() ) {
			return $attributes;
		}

		foreach ( $fields as $field ) {
			if ( ! isset( $field->settings['sub_fields'], $attributes[ $field->name ]['rows'] ) ) {
				continue;
			}

			$sub_field_settings = $field->settings['sub_fields'];
			$rows               = $attributes[ $field->name ]['rows'];

			// In each row, apply a field's default value if a value doesn't exist in the attributes.
			foreach ( $rows as $row_index => $row ) {
				foreach ( $sub_field_settings as $sub_field_name => $sub_field ) {
					if ( ! isset( $row[ $sub_field_name ] ) && isset( $sub_field_settings[ $sub_field_name ]->settings['default'] ) ) {
						$rows[ $row_index ][ $sub_field_name ] = $sub_field_settings[ $sub_field_name ]->settings['default'];
					}
				}
			}

			$attributes[ $field->name ]['rows'] = $rows;
		}

		return $attributes;
	}

	/**
	 * Renders the sub-rows for a Repeater field.
	 *
	 * @param Field  $field The field to render.
	 * @param string $uid   The UID of the field.
	 */
	public function render_sub_rows( $field, $uid ) {
		if ( 'repeater' === $field->control ) {
			$sub_fields = isset( $field->settings['sub_fields'] ) ? $field->settings['sub_fields'] : [];
			$this->render_fields_sub_rows( $sub_fields, $uid );
		}
	}

	/**
	 * Render the actions row when adding a Repeater field.
	 *
	 * @param Field[] $fields     The sub fields to render.
	 * @param string  $parent_uid The unique ID of the field's parent.
	 */
	public function render_fields_sub_rows( $fields = [], $parent_uid = '' ) {
		?>
		<div class="block-fields-sub-rows">
			<?php
			if ( ! empty( $fields ) ) {
				foreach ( $fields as $field ) {
					$this->render_fields_meta_box_row( $field, uniqid(), $parent_uid );
				}
			}
			?>
		</div>
		<div class="block-fields-sub-rows-actions">
			<p class="repeater-no-fields <?php echo esc_attr( empty( $fields ) ? '' : 'hidden' ); ?>">
				<button type="button" aria-label="<?php esc_attr_e( 'Add Sub-Field', 'genesis-custom-blocks-pro' ); ?>" id="block-add-sub-field">
					<span class="dashicons dashicons-plus"></span>
					<?php esc_html_e( 'Add your first Sub-Field', 'genesis-custom-blocks-pro' ); ?>
				</button>
			</p>
			<p class="repeater-has-fields <?php echo esc_attr( empty( $fields ) ? 'hidden' : '' ); ?>">
				<button type="button" aria-label="<?php esc_attr_e( 'Add Sub-Field', 'genesis-custom-blocks-pro' ); ?>" id="block-add-sub-field">
					<span class="dashicons dashicons-plus"></span>
					<?php esc_html_e( 'Add Sub-Field', 'genesis-custom-blocks-pro' ); ?>
				</button>
			</p>
		</div>
		<?php
	}

	/**
	 * Render a single Field as a row.
	 *
	 * @param Field $field      The Field containing the options to render.
	 * @param mixed $uid        A unique ID to used to unify the HTML name, for, and id attributes.
	 * @param mixed $parent_uid The parent's unique ID, if the field has a parent.
	 *
	 * @return void
	 */
	public function render_fields_meta_box_row( $field, $uid = false, $parent_uid = false ) {
		// Use a template placeholder if no UID provided.
		if ( ! $uid ) {
			$uid = '{{ data.uid }}';
		}

		?>
		<div class="block-fields-row" data-uid="<?php echo esc_attr( $uid ); ?>">
			<div class="block-fields-row-columns">
				<div class="block-fields-sort">
					<span class="block-fields-sort-handle"></span>
				</div>
				<div class="block-fields-label">
					<a class="row-title" href="javascript:" id="block-fields-label_<?php echo esc_attr( $uid ); ?>">
						<?php echo esc_html( $field->label ); ?>
					</a>
					<div class="block-fields-actions">
						<a class="block-fields-actions-edit" href="javascript:">
							<?php esc_html_e( 'Edit', 'genesis-custom-blocks-pro' ); ?>
						</a>
						&nbsp;|&nbsp;
						<a class="block-fields-actions-duplicate" href="javascript:">
							<?php esc_html_e( 'Duplicate', 'genesis-custom-blocks-pro' ); ?>
						</a>
						&nbsp;|&nbsp;
						<a class="block-fields-actions-delete" href="javascript:">
							<?php esc_html_e( 'Delete', 'genesis-custom-blocks-pro' ); ?>
						</a>
					</div>
				</div>
				<div class="block-fields-name" id="block-fields-name_<?php echo esc_attr( $uid ); ?>">
					<code id="block-fields-name-code_<?php echo esc_attr( $uid ); ?>"><?php echo esc_html( $field->name ); ?></code>
				</div>
				<div class="block-fields-control" id="block-fields-control_<?php echo esc_attr( $uid ); ?>">
				</div>
			</div>
			<div class="block-fields-edit">
				<table class="widefat">
					<tr class="block-fields-edit-label">
						<td class="spacer"></td>
						<th scope="row">
							<label for="block-fields-edit-label-input_<?php echo esc_attr( $uid ); ?>">
								<?php esc_html_e( 'Field Label', 'genesis-custom-blocks-pro' ); ?>
							</label>
							<p class="description">
								<?php
								esc_html_e(
									'A label describing your block\'s custom field.',
									'genesis-custom-blocks-pro'
								);
								?>
							</p>
						</th>
						<td>
							<input
								name="block-fields-label[<?php echo esc_attr( $uid ); ?>]"
								type="text"
								id="block-fields-edit-label-input_<?php echo esc_attr( $uid ); ?>"
								class="regular-text"
								value="<?php echo esc_attr( $field->label ); ?>"
								data-sync="block-fields-label_<?php echo esc_attr( $uid ); ?>"
							/>
						</td>
					</tr>
					<tr class="block-fields-edit-name">
						<td class="spacer"></td>
						<th scope="row">
							<label for="block-fields-edit-name-input_<?php echo esc_attr( $uid ); ?>">
								<?php esc_html_e( 'Field Name', 'genesis-custom-blocks-pro' ); ?>
							</label>
							<p class="description">
								<?php esc_html_e( 'Single word, no spaces.', 'genesis-custom-blocks-pro' ); ?>
							</p>
						</th>
						<td>
							<input
								name="block-fields-name[<?php echo esc_attr( $uid ); ?>]"
								type="text"
								id="block-fields-edit-name-input_<?php echo esc_attr( $uid ); ?>"
								class="regular-text"
								value="<?php echo esc_attr( $field->name ); ?>"
								data-sync="block-fields-name-code_<?php echo esc_attr( $uid ); ?>"
							/>
						</td>
					</tr>
					<tr class="block-fields-edit-control">
						<td class="spacer"></td>
						<th scope="row">
							<label for="block-fields-edit-control-input_<?php echo esc_attr( $uid ); ?>">
								<?php esc_html_e( 'Field Type', 'genesis-custom-blocks-pro' ); ?>
							</label>
						</th>
						<td>
							<select
								name="block-fields-control[<?php echo esc_attr( $uid ); ?>]"
								id="block-fields-edit-control-input_<?php echo esc_attr( $uid ); ?>"
								data-sync="block-fields-control_<?php echo esc_attr( $uid ); ?>"
							>
								<?php
								$controls_for_select = genesis_custom_blocks()->block_post->get_controls();

								// Don't allow nesting repeaters inside repeaters.
								if ( ! empty( $field->settings['parent'] ) ) {
									unset( $controls_for_select['repeater'] );
								}

								foreach ( $controls_for_select as $control_for_select ) :
									?>
									<option
										value="<?php echo esc_attr( $control_for_select->name ); ?>"
										<?php selected( $field->control, $control_for_select->name ); ?>>
										<?php echo esc_html( $control_for_select->label ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<?php $this->render_field_settings( $field, $uid ); ?>
					<tr class="block-fields-edit-actions-close">
						<td class="spacer"></td>
						<th scope="row">
						</th>
						<td>
							<a class="button" title="<?php esc_attr_e( 'Close Field', 'genesis-custom-blocks-pro' ); ?>" href="javascript:">
								<?php esc_html_e( 'Close Field', 'genesis-custom-blocks-pro' ); ?>
							</a>
						</td>
					</tr>
				</table>
			</div>
			<?php
			if ( 'repeater' === $field->control ) {
				if ( ! isset( $field->settings['sub_fields'] ) ) {
					$field->settings['sub_fields'] = [];
				}
				$this->render_fields_sub_rows( $field->settings['sub_fields'], $uid );
			}
			if ( $parent_uid ) {
				?>
				<input
					type="hidden"
					name="block-fields-parent[<?php echo esc_attr( $uid ); ?>]"
					value="<?php echo esc_attr( $parent_uid ); ?>"
				/>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * Render the settings for a given field.
	 *
	 * @param Field  $field The Field containing the options to render.
	 * @param string $uid   A unique ID to used to unify the HTML name, for, and id attributes.
	 */
	public function render_field_settings( $field, $uid ) {
		$controls = genesis_custom_blocks()->block_post->get_controls();
		if ( isset( $controls[ $field->control ] ) ) {
			$controls[ $field->control ]->render_settings( $field, $uid );
		}
	}

	/**
	 * Saves repeater sub-fields.
	 *
	 * Get sub-fields that were sent via a form POST request in the CPT 'Edit Block' page.
	 * Then, add them to the block, so they're saved correctly.
	 *
	 * @param Block      $block  The block where the field is.
	 * @param Field      $field  The block field to save.
	 * @param array      $fields The block fields to save, as sent from the form's POST request.
	 * @param int|string $key    The field key.
	 * @param string     $name   The name.
	 */
	public function save_repeater_fields( $block, $field, $fields, $key, $name ) {
		if ( empty( $_POST['block-fields-parent'][ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			return $block;
		}

		$parent_uid = sanitize_key( $_POST['block-fields-parent'][ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Missing

		// The parent's name should have been submitted.
		if ( ! isset( $fields[ $parent_uid ] ) ) {
			return $block;
		}

		$parent = $fields[ $parent_uid ];

		// The parent field should be set by now. We expect it to always precede the child field.
		if ( ! isset( $block->fields[ $parent ] ) ) {
			return $block;
		}

		if ( ! isset( $block->fields[ $parent ]->settings['sub_fields'] ) ) {
			$block->fields[ $parent ]->settings['sub_fields'] = [];
		}

		$field->settings['parent'] = $parent;
		$field->order              = count(
			$block->fields[ $parent ]->settings['sub_fields']
		);

		$block->fields[ $parent ]->settings['sub_fields'][ $name ] = $field;

		return $block;
	}

	/**
	 * Adds the repeater templates to the field.
	 */
	public function add_repeater_template() {
		?>
		<script type="text/html" id="tmpl-sub-field-rows">
			<?php $this->render_fields_sub_rows(); ?>
		</script>
		<?php
	}
}
