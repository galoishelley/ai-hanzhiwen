<?php
$image_id = get_sub_field('image');
$heading = get_sub_field('heading');
$button = get_sub_field('button');
?>
<section class="module module__hero">
	<div class="container">
		<div class="row">
			<div class="module__hero__image">
				<?php echo wp_get_attachment_image($image_id, 'large'); ?>
			</div>
			<div class="module__hero__copy">

				<div class="">
					<h1><?php echo $heading; ?></h1>
					<?= get_sub_field('copy'); ?>
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