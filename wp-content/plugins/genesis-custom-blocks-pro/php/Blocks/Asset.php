<?php
/**
 * Handles plugin assets.
 *
 * @package Genesis\CustomBlocksPro
 */

namespace Genesis\CustomBlocksPro\Blocks;

use Genesis\CustomBlocks\ComponentAbstract;

/**
 * Class Asset
 */
class Asset extends ComponentAbstract {

	/**
	 * Asset paths and urls for blocks.
	 *
	 * @var array
	 */
	protected $assets = [];

	/**
	 * An associative array of block config data for the blocks that will be registered.
	 *
	 * The key of each item in the array is the block name.
	 *
	 * @var array
	 */
	protected $blocks = [];

	/**
	 * Initiates the class.
	 *
	 * @return $this
	 */
	public function init() {
		$this->assets = [
			'path' => [
				'entry'        => $this->plugin->get_path( 'js/dist/editor-blocks-pro.js' ),
				'editor_style' => $this->plugin->get_path( 'css/dist/blocks-editor-pro.css' ),
			],
			'url'  => [
				'entry'        => $this->plugin->get_url( 'js/dist/editor-blocks-pro.js' ),
				'editor_style' => $this->plugin->get_url( 'css/dist/blocks-editor-pro.css' ),
			],
		];

		return $this;
	}

	/**
	 * Registers all the hooks.
	 */
	public function register_hooks() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'editor_assets' ] );
	}

	/**
	 * Launches the blocks inside Gutenberg.
	 */
	public function editor_assets() {
		$js_config  = require $this->plugin->get_path( 'js/dist/editor-blocks-pro.asset.php' );
		$css_config = require $this->plugin->get_path( 'css/dist/blocks-editor-pro.asset.php' );

		wp_enqueue_script(
			'genesis-custom-blocks-pro-blocks',
			$this->assets['url']['entry'],
			$js_config['dependencies'],
			$js_config['version'],
			true
		);

		// Enqueue optional editor only styles.
		wp_enqueue_style(
			'genesis-custom-blocks-pro-editor-css',
			$this->assets['url']['editor_style'],
			$css_config['dependencies'],
			$css_config['version']
		);
	}
}
