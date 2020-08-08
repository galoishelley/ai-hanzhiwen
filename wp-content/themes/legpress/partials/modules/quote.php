<?php
$image_id = get_sub_field('background_image');
$copy = get_sub_field('copy');
?>
<section class="module module__quote">
	<div class="container">
		<div class="module__quote-image" style="background:url(<?= wp_get_attachment_image_src($image_id, 'full')[0]; ?>) no-repeat center/ 100% 100%;">

			<p><?= $copy ?><p>
		</div>
	</div>
</section>