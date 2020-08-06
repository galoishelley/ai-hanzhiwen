<?php
$copy = get_sub_field('copy');
$googlemap = get_sub_field('googlemap');
$order = get_sub_field('order');
$title = get_sub_field('title');

$image_class = '';
if ($order == 'copy_image') {
	$image_class = 'order-md-2';
} ?>
<section class="module module__contact">
	<div class="container">
		<div class="row">
			<div class="module__contact__image col-12 col-md-6 <?php echo $image_class; ?>">
				<?php //echo wp_get_attachment_image($image_id, 'medium'); ?>
			</div>
			<div class="module__contact__copy col-12 col-md-6">
				<div class="module__contact__copy__inner typography">
					<h1><?php echo $title; ?></h1>
					<?php echo $copy; ?>
					<?php if($form_shortcode = get_sub_field('ninja_form_shortcode')) { ?>
						
							<?= do_shortcode($form_shortcode); ?>
						
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>