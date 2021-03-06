<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

	<?php if (is_singular() && pings_open(get_queried_object())) : ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php endif; ?>

	<title><?php wp_title(); ?></title>

	<?php wp_head(); ?>

	<script type="text/javascript">
		var _ajaxurl = '<?= admin_url("admin-ajax.php"); ?>';
		var _pageid = '<?= get_the_ID(); ?>';
		var _imagedir = '<?php lp_image_dir(); ?>';
	</script>

</head>

<body <?php body_class(); ?>>

	<?php

	// This fixes an issue where wp_nav_menu applied the_title filter which causes WC and plugins to change nav menu labels
	print '<!--';
	the_title();
	print '-->';

	?>

	<div class="wrapper">
		<header class="site-header">
			<div class="container">
				<div class="site-header__logo">
					<a href="<?php echo bloginfo('url'); ?>" title="Return to the homepage" class="primary-logo"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="Logo"></a>
				</div>
				<div class="site-header__menu">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'header-menu'
					)); ?>
				</div>

				<div class="site-header__right_search">
					<form id="desktop-search" class="search" action="/" method="get" style="display:inline-flex;">
						<input type="text" name="s" id="site-search" placeholder="搜索...">
		
					</form>



					<a href="#" title="search" class="primary-logo"><img src="<?php bloginfo('template_directory'); ?>/images/search icon.svg" alt="search_icon"></a>

				</div>
			</div>
		</header>

		<header class="mobile-header">
			<div class="container">
				<div class="mobile-header__logo">
					<a href="<?php echo bloginfo('url'); ?>" title="Return to the homepage" class="primary-logo"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="Logo"></a>
				</div>


				<div class="c-mobile-menu">
					<input class="e-mobile-menu-input" type="checkbox">
					<div class="e-mobile-menu__hamburger">
						<span class="e-mobile-menu__hamburger__block"></span>
						<span class="e-mobile-menu__hamburger__block"></span>
						<span class="e-mobile-menu__hamburger__block"></span>
					</div>

					<div class="e-mobile-menu__wrapper">
						<div class="e-mobile-menu__content">
							<div class="e-mobile-menu__main-menu">
								<?php
								wp_nav_menu(array(
									'theme_location' => 'main-menu',
									'menu' => 'Main Menu',
									'container' => false,
									'items_wrap' => '<ul class="">%3$s</ul>'
								));
								?>
							</div>
						</div>
					</div> 
				</div>
			</div>
		</header>

	</div>

	<a id="back_to_top"></a>