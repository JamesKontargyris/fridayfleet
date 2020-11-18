<?php get_header(); ?>


<div class="nav-bar">
    <div class="nav-bar__logo">
        <div class="site__header__logo">FRIDAY FLEET</div>
    </div>
    <ul class="nav-bar__menu">
        <li><a href="#page" class="icon--grid is-active">Overview</a></li>
        <li><a href="#page" class="icon--ship" data-ship="3600">3600</a></li>
        <li><a href="#page" class="icon--ship" data-ship="5000">5000</a></li>
        <li><a href="#page" class="icon--ship" data-ship="6500">6500</a></li>
        <li><a href="#page" class="icon--ship" data-ship="8500">8500</a></li>
    </ul>
    <div class="nav-bar__powered-by">
		<?php get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>
    </div>
</div>

<div class="ajax-page">

	<?php get_template_part( 'template-parts/partials/partial', 'data-view--value-over-time' ); ?>

</div>

<?php get_template_part( 'template-parts/partials/partial', 'ajax-loader' ); ?>

<div class="footer__powered-by">
	<?php get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>
</div>

