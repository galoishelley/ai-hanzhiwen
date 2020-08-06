<?php
$image_id = get_sub_field('background_image');
$title = get_sub_field('title');
?>
<section class="module module__team">
	<div class="container">
		<div class="module__team__image">
			<?php echo wp_get_attachment_image($image_id, 'large'); ?>
		</div>
		<div class="module__team__copy">
			<div class="container">
				<div class="row member-title">
					<h1><?php echo $title; ?></h1>
				</div>

				<div class="row member">

					<?php $post_objects = get_sub_field('member'); ?>

					<?php if ($post_objects) : ?>

						<?php foreach ($post_objects as $post_object) :

							$len = count($post_objects);
							$col = 12;
							switch ($len) {
								case 1:
									$col = 12;
									break;
								case 2:
									$col = 6;
									break;
								case 3:
									$col = 4;
									break;
								case 4:
									$col = 3;
									break;
								default:
									break;
							}
						?>
							<div class="member_col col-<?=$col?>">
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

							</div>
						<?php endforeach; ?>

					<?php endif; ?>




				</div>
			</div>
		</div>
	</div>
</section>