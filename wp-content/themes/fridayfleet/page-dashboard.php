<?php get_header(); ?>
<?php $ship_groups = get_ship_groups(); ?>

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
			<?php while ( $ship_groups->have_posts() ) : $ship_groups->the_post(); ?>

                <li><a href="/overview?group=<?php the_ID(); ?>" class="icon--grid nav-bar__link__overview is-active"
                       data-page-type="page"
                       data-show-data-view-select="0">Overview<br><?php the_title(); ?></a></li>

				<?php foreach ( get_field( 'ship_group_ship_types' ) as $ship_type_id ) : ?>
                    <li>
                        <a href="/data-view?ship=<?php echo get_field( 'ship_type_database_slug', $ship_type_id ); ?>"
                           class="icon--ship nav-bar__link__<?php echo get_field( 'ship_type_database_slug', $ship_type_id ); ?>"
                           data-ship="<?php echo get_field( 'ship_type_database_slug', $ship_type_id ); ?>"
                           data-page-type="data-view">
							<?php echo get_the_title( $ship_type_id ); ?>
                        </a>
                    </li>
				<?php endforeach; ?>

			<?php endwhile;
			wp_reset_postdata(); ?>
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


