<?php
$copy = get_sub_field('copy');
$image_id = get_sub_field('image');
$order = get_sub_field('order');
$heading = get_sub_field('heading');
$button = get_sub_field('button');
$id = get_sub_field('id');

$image_class = '';
if ($order == 'copy_image') {
	$image_class = 'order-md-2';
	// $col_up = 5;
	// $col_down = 7;
} else{
	$image_copy = "image_copy";
	// $col_up = 6;
	// $col_down = 6;
}?>


<section class="module module__copy-image " id="<?= $id?>">
<div class="container">

			<div class="module__copy-image__image <?= $image_class?>">
				<?php echo wp_get_attachment_image($image_id, 'medium'); ?>
			</div>


			<div class="module__copy-image__copy  ">
				<div class="module__copy-image__copy__inner">
					<h1><?php echo $heading; ?></h1>
					<?php echo $copy; ?>
					<?php
					if ($button) {
						$url = $button['url'];
						$label = $button['title'];
						$target = $button['target']; ?>
						<a class="btn" href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php echo $label; ?></a>
					<?php } ?>


				</div>
			</div>
		</div>
		</div>
</section>