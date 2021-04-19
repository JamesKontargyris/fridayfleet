<?php get_header(); ?>

<?php get_template_part( 'template-parts/partials/partial', 'nav-bar' ); ?>

    <main id="primary" class="site__body">
        <div id="content-top"></div>

		<?php
		switch ( get_post_type() ) {
			case 'ship_group':
				get_template_part( 'template-parts/content', 'overview' );
				break;
			case 'ship_type':
				get_template_part( 'template-parts/content', 'ship' );
				break;
		}
		?>

        <div class="footer__powered-by">
			<?php get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>
        </div>

    </main>

<?php get_footer();