<?php if (get_field('partners_section')): ?>


	<section id="partners" class="section-container partners">
	<header class="section-header">
		<h2 class="section-title">
			<?php if ($desc = get_field('partners_title')): ?>
				<?php echo esc_html($desc); ?>
			<?php endif; ?>

		</h2>
		<?php if ($desc = get_field('partners_description')): ?>
			<div class="section-description">
				<?php echo esc_html($desc); ?>
			</div>
		<?php endif; ?>
	</header>
	<?php
	$link_category = 'parceiros';

	$bookmarks = get_bookmarks(array(
		'category_name' => $link_category,
		'orderby' => 'RAND',
		'order' => 'ASC',
		'limit' => '6'
	));

	if ($bookmarks): ?>
		<ul class="list-inline partners-list m-0 d-flex flex-wrap justify-content-md-between justify-content-center">
			<?php foreach ($bookmarks as $bookmark): ?>
				<li class="partners-item list-inline-item border rounded-circle mb-3 mb-md-0">
					<a class="d-block  rounded-circle" href="<?php echo esc_url($bookmark->link_url); ?>" target="_blank"
						rel="noopener" title="<?php echo esc_html($bookmark->link_name); ?>"
						style="background-image: url(<?php echo esc_url($bookmark->link_image); ?>);">
						<span class="visually-hidden"><?php echo esc_html($bookmark->link_name); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>


</section>

<?php endif; ?>
