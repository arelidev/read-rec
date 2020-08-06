<?php
/**
 * Template part for displaying a single facility
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( '' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

    <header class="article-header grid-y grid-padding-y" style="height: 100%; background-image: url(<?= get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>">
        <div class="cell">
            <div class="header-spacer"></div>
        </div>
        <div class="cell">
            <h1 class="entry-title single-title text-color-white" itemprop="headline">
                <?php the_title(); ?>
            </h1>
        </div>
        <div class="auto cell separator"></div>
        <div class="cell">
            <p class="text-color-white">
                <i class="fas fa-dot-circle"></i> <?= get_field( 'facility_address' )['address'] ?>
            </p>
        </div>
		<?php // get_template_part( 'parts/content', 'byline' ); ?>
		<?php // the_post_thumbnail('full'); ?>
    </header> <!-- end article header -->

    <section class="entry-content grid-container grid-x grid-padding-x grid-padding-y" itemprop="text">
        <div class="small-12 medium-6 large-5 cell">
			<?php
			$images = get_field( 'facility_gallery' );
			if ( $images ): ?>
                <div class="facility-gallery-slider">
					<?php foreach ( $images as $image_id ): ?>
                        <div class="facility-gallery-slide">
                            <a href="<?= wp_get_attachment_image_url( $image_id, 'full' ); ?>" data-fancybox="gallery">
								<?= wp_get_attachment_image( $image_id, 'full' ); ?>
                            </a>
                        </div>
					<?php endforeach; ?>
                </div>

                <div class="grid-x grid-padding-x">
                    <div class="shrink cell">
                        <button class="slick-prev-custom slick-custom facility-gallery-slider-nav-prev">
                            <i class="far fa-chevron-left fa-lg"></i>
                        </button>
                    </div>
                    <div class="shrink cell">
                        <button class="slick-next-custom slick-custom facility-gallery-slider-nav-next">
                            <i class="far fa-chevron-right fa-lg"></i>
                        </button>
                    </div>
                </div>
			<?php endif; ?>
        </div>
        <div class="small-12 medium-6 large-6 large-offset-1 cell">
            <div class="facility-excerpt">
                <h5 class="font-family-body"><b><?= __( 'Details', 'read-rec' ); ?></b></h5>
                <p class="text-color-dark-gray">
					<?= get_field( 'facility_excerpt' ); ?>
                </p>
            </div>

            <div class="facility-amenities">
                <h5 class="font-family-body"><b><?= __( 'Amenities', 'read-rec' ); ?></b></h5>
				<?php if ( have_rows( 'facility_amenities' ) ): ?>
                    <ul class="facility-amenities-list menu vertical">
						<?php while ( have_rows( 'facility_amenities' ) ) : the_row(); ?>
                            <li>
                                <p><?php the_sub_field( 'icon' ); ?> <b><span class="text-color-dark-gray"><?php the_sub_field( 'Title' ); ?></span></b></p>
                            </li>
						<?php endwhile; ?>
                    </ul>
				<?php endif; ?>
            </div>

            <div class="facility-content">
                <h5 class="font-family-body"><b><?= __( 'Additional Information', 'read-rec' ); ?></b></h5>
                <div class="text-color-dark-gray">
					<?php the_content(); ?>
                </div>
            </div>
        </div>
    </section> <!-- end article section -->

    <footer class="article-footer">
	    <?php wp_link_pages( array(
		    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jointswp' ),
		    'after'  => '</div>'
	    ) ); ?>
        <p class="tags"><?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'jointswp' ) . '</span> ', ', ', '' ); ?></p>

		<?php
		$location = get_field( 'facility_address' );
		if ( $location ): ?>
            <div class="acf-map" data-zoom="16">
                <div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>"
                     data-lng="<?php echo esc_attr( $location['lng'] ); ?>"></div>
            </div>
		<?php endif; ?>

    </footer> <!-- end article footer -->

</article> <!-- end article -->
