<?php
$googlemap = get_sub_field('googlemap');
$title = get_sub_field('title');

 ?>
<section class="module module__contact" id="contact">
	<div class="container">
		<div class="row">
			<div class="module__contact__image col-12 col-lg-6">
			<div id="map"></div>
			</div>
			<div class="module__contact__copy col-12 col-lg-6">
				<div class="module__contact__copy__inner typography">
					<h1><?php echo $title; ?></h1>
					<?php if ($form_shortcode = get_sub_field('ninja_form_shortcode')) { ?>

						<?= do_shortcode($form_shortcode); ?>

					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>

<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDy-oTTAiaGtvDzHKxHBkXYvGe9Uqhq0Bw&callback=initMap">
</script>