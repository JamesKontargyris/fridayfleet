<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <script>
        // no-js/js class toggle
        (function (H) {
            H.className = H.className.replace(/\bno-js\b/, 'js')
        })(document.documentElement);
    </script>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,900;1,300;1,400;1,900&display=swap"
          rel="stylesheet">

    <?php get_template_part('template-parts/partials/partial', 'favicon'); ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/partials/partial', 'loader-page' ); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'fridayfleet' ); ?></a>

    <header id="masthead" class="site__header">
        <?php if(is_front_page()) : ?>
            <h1 class="site__header__logo hide--desktop">FRIDAY FLEET - SHORTSEA VALUES</h1>
        <?php else : ?>
            <div class="site__header__logo hide--desktop">FRIDAY FLEET - SHORTSEA VALUES</div>
        <?php endif; ?>
        <div class="site__header__tools">
			<?php get_template_part( 'template-parts/partials/partial', 'user-summary' ); ?>

            <button class="hamburger hamburger--stand" type="button"
                    aria-label="Menu" aria-controls="navigation">
                <span class="hamburger-box">
                  <span class="hamburger-inner"></span>
                </span>
            </button>

        </div>
        <nav class="sub-menu--mobile sub-menu--tablet">
			<?php wp_nav_menu( [
				'menu'       => 'sub-menu',
				'menu_class' => 'sub-menu',
				'depth'      => 1,
				'container'  => '',
			] ); ?>
        </nav>
    </header><!-- #masthead -->



