<?php get_header(); ?>
<?php $ship_groups = get_ship_groups(); ?>

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

                <li>
                    <a href="<?php echo get_the_permalink(); ?>" class="icon--grid nav-bar__link__overview is-active">
                        Overview<br><?php the_title(); ?>
                    </a>
                </li>

				<?php foreach ( get_field( 'ship_group_ship_types' ) as $ship_type_id ) : ?>
                    <li>
                        <a href="<?php echo get_the_permalink($ship_type_id); ?>" class="icon--ship">
							<?php echo get_the_title( $ship_type_id ); ?>
                        </a>
                    </li>
				<?php endforeach; ?>

			<?php endwhile;
			wp_reset_postdata(); ?>
        </ul>

    </section>

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


