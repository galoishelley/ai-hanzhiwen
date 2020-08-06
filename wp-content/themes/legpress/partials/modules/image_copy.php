<?php
$copy = get_sub_field('copy');
$image_id = get_sub_field('image');
$order = get_sub_field('order');
$heading = get_sub_field('heading');
$button = get_sub_field('button');

$image_class = '';
if ($order == 'copy_image') {
	$image_class = 'order-md-2';
} ?>
<section class="module module__copy-image">
	<div class="container">
		<div class="row">
			<div class="module__copy-image__image col-12 col-md-6 <?php echo $image_class; ?>">
				<?php echo wp_get_attachment_image($image_id, 'medium'); ?>
			</div>
			<div class="module__copy-image__copy col-12 col-md-6">
				<div class="module__copy-image__copy__inner typography">
					<h1><?php echo $heading; ?></h1>
					<?php echo $copy; ?>
					<?php
					if ($button) {
						$url = $button['url'];
						$label = $button['title'];
						$target = $button['target']; ?>
						<a class="btn btn-white btn-white--hollow" href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $label; ?></a>
					<?php } ?>


				</div>
			</div>
		</div>
	</div>
</section>