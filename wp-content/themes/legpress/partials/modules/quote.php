<?php
$image_id = get_sub_field('background_image');
$copy = get_sub_field('copy');
?>
<section class="module module__quote">
	<div class="container">
		<div class="module__quote__image">
			<?php echo wp_get_attachment_image($image_id, 'large'); ?>
		</div>
		<div class="module__quote__copy">
			<div class="container">
				<div class="row">
					<div class="col-12 col-md-8 col-lg-6 typography typography--white">
						<?= $copy ?> 
					</div>
				</div>
			</div>
		</div>
	</div>
</section>