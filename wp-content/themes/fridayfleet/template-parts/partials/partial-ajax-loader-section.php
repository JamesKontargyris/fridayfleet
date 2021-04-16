<?php // $args is made available to get_template_part by WordPress ?>
<div <?php if($args['id']) : ?>id="<?php echo $args['id']; ?>"<?php endif; ?> class="ajax-loader ajax-loader--section">
    <img src="<?php echo get_template_directory_uri(); ?>/img/ajax-loader.svg" alt="Loading">
</div>
