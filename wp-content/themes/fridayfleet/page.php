<main id="primary" class="site__body">

    <div id="content-top"></div>

	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile; // End of the loop.
	?>

</main><!-- #main -->