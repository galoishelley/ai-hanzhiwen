<?php
$image_id = get_sub_field('background_image');
$title = get_sub_field('title');
?>
<section class="module module__team" id="team">
	<div class="container">
		<div class="module__team__image" style="background:url(<?= wp_get_attachment_image_src($image_id, 'full')[0]; ?>) repeat center/ 100% 100%;">
			<div class="module__team__copy">

				<div class="member-title">
					<h1><?php echo $title; ?></h1>
				</div>

				<div class="members">
					<?php $post_objects = get_sub_field('member'); ?>

					<?php if ($post_objects) : ?>

						<?php foreach ($post_objects as $post_object) : ?>
							<div class="member-panel">
								<h2><?php echo get_the_title($post_object->ID); ?></h2>
								<h6>
									<?php the_field('job_title', $post_object->ID); ?>
								</h6>
								<?php if (has_post_thumbnail($post_object->ID)) : ?>
									<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_object->ID), 'single-post-thumbnail'); ?>
									<img src="<?php echo $image[0]; ?>" alt="">
								<?php endif; ?>
								<p><?php echo get_post_field('post_content', $post_object->ID); ?></p>
							</div>
						<?php endforeach; ?>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>