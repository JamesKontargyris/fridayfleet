<?php get_header(); ?>

<?php get_template_part( 'template-parts/partials/partial', 'nav-bar' ); ?>

    <main id="primary" class="site__body">
        <div id="content-top"></div>

		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', 'page' );
		}
		?>


		<?php get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>

    </main>

<?php get_footer();