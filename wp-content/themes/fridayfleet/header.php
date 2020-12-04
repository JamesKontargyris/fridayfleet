<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <script>
        // no-js/js class toggle
        (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement);
    </script>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,900;1,300;1,400;1,900&display=swap"
          rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'template-parts/partials/partial', 'ajax-loader' ); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'fridayfleet' ); ?></a>

    <header id="masthead" class="site__header">
        <div class="site__header__logo hide--desktop">FRIDAY FLEET</div>
        <div class="site__header__tools">
            <?php // get_template_part('template-parts/partials/partial', 'data-view-select-mobile'); ?>
            <?php get_template_part('template-parts/partials/partial', 'user-summary'); ?>
        </div>
    </header><!-- #masthead -->
