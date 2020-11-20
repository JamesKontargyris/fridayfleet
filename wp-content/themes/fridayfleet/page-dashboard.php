<?php get_header(); ?>

<input type="hidden" name="data-view" value="value-over-time" id="data-view-value">
<input type="hidden" name="current-url" value="/overview" id="current-url">
<input type="hidden" name="page-type" value="page" id="page-type">


<div class="nav-bar">
    <div class="nav-bar__logo">
        <div class="site__header__logo">FRIDAY FLEET</div>
    </div>

    <section class="nav-bar__section hide--mobile hide--tablet">
        <?php get_template_part('template-parts/partials/partial', 'user-summary'); ?>
    </section>

    <section class="nav-bar__section nav-bar__section--no-pad">
        <ul class="nav-bar__menu">
            <li><a href="/overview" class="icon--grid is-active" data-page-type="page" data-show-data-view-select="0">Overview</a></li>
            <li><a href="/data-view?ship=3600" class="icon--ship" data-ship="3600" data-page-type="data-view" data-show-data-view-select="1">3600</a></li>
            <li><a href="/data-view?ship=5000" class="icon--ship" data-ship="5000" data-page-type="data-view" data-show-data-view-select="1">5000</a></li>
            <li><a href="/data-view?ship=6500" class="icon--ship" data-ship="6500" data-page-type="data-view" data-show-data-view-select="1">6500</a></li>
            <li><a href="/data-view?ship=8500" class="icon--ship" data-ship="8500" data-page-type="data-view" data-show-data-view-select="1">8500</a></li>
<!--            <li><a href="/notes" class="icon--note" data-page-type="page">Notes</a></li>-->
        </ul>
    </section>

    <div class="nav-bar__powered-by">
<!--		--><?php //get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>
    </div>
</div>

<div class="ajax-page">

	<?php get_template_part( 'template-parts/partials/partial', 'data-view--overview' ); ?>

</div>

<div class="footer__powered-by">
	<?php get_template_part( 'template-parts/partials/partial', 'powered-by-message' ); ?>
</div>

