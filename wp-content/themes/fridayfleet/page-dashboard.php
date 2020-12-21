<?php get_header(); ?>

<input type="hidden" name="data-view" value="fixed-age-value" id="data-view-value">
<input type="hidden" name="current-url" value="/overview" id="current-url">
<input type="hidden" name="page-type" value="page" id="page-type">


<div class="nav-bar">
    <div class="nav-bar__logo">
        <div class="site__header__logo">FRIDAY FLEET</div>
    </div>

    <section class="nav-bar__section hide--mobile hide--tablet">
		<?php get_template_part( 'template-parts/partials/partial', 'user-summary' ); ?>
    </section>

    <section class="nav-bar__section nav-bar__section--no-pad">
        <ul class="nav-bar__menu">
            <li><a href="/overview" class="icon--grid nav-bar__link__overview is-active" data-page-type="page"
                   data-show-data-view-select="0">Overview<br>Dry Gearless</a></li>
            <li><a href="/data-view?ship=3600" class="icon--ship nav-bar__link__3600" data-ship="3600"
                   data-page-type="data-view" data-show-data-view-select="1">3600 DWT</a></li>
            <li><a href="/data-view?ship=5000" class="icon--ship nav-bar__link__5000" data-ship="5000"
                   data-page-type="data-view" data-show-data-view-select="1">5000 DWT</a></li>
            <li><a href="/data-view?ship=6500" class="icon--ship nav-bar__link__6500" data-ship="6500"
                   data-page-type="data-view" data-show-data-view-select="1">6500 DWT</a></li>
            <li><a href="/data-view?ship=8500" class="icon--ship nav-bar__link__8500" data-ship="8500"
                   data-page-type="data-view" data-show-data-view-select="1">8500 DWT</a></li>
            <!--            <li><a href="/notes" class="icon--note" data-page-type="page">Notes</a></li>-->
        </ul>
    </section>

</div>

<div class="ajax-page">

	<?php get_template_part( 'template-parts/partials/partial', 'data-view--overview' ); ?>

</div>

<nav class="sub-menu--desktop">
	<?php wp_nav_menu( [
		'menu'       => 'sub-menu',
		'menu_class' => 'sub-menu',
		'depth'      => 1,
		'container'  => '',
	] ); ?>
</nav>

<div class="footer__powered-by">
	<?php get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>
</div>


