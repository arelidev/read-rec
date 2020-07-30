<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single grid-x grid-padding-x grid-margin-y">

    <div class="small-12 medium-12 large-12 cell">
        <!-- Notices -->
		<?php tribe_the_notices() ?>

        <!-- Event header -->
        <div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
            <!-- Navigation -->
            <nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
                <ul class="tribe-events-sub-nav">
                    <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                    <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
                </ul>
                <!-- .tribe-events-sub-nav -->
            </nav>
        </div>
        <!-- #tribe-events-header -->
    </div>

    <div class="small-12 medium-6 large-5 cell">
        <!-- Event featured image, but exclude link -->
		<?= tribe_event_featured_image( $event_id, 'full', false ); ?>

        <!-- Event content -->
	    <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
        <div class="tribe-events-single-event-description tribe-events-content">
            <h4 class="font-family-body"><b><?= __( 'Details', 'read-rec' ); ?></b></h4>
            <div class="text-color-dark-gray"><?php the_content(); ?></div>
        </div>
    </div>

    <div class="small-12 medium-6 large-6 large-offset-1 cell">
        <div class="grid-x grid-padding-x align-middle">
            <div class="small-12 medium-6 large-6 cell">
                <p class="tribe-events-back">
                    <a href="<?= esc_url( tribe_get_events_link() ); ?>">
			            <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?>
                    </a>
                </p>
            </div>
            <div class="small-12 medium-6 large-6 cell">
                <div class="tribe-events-schedule tribe-clearfix">
		            <?php // echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
		            <?php if ( tribe_get_cost() ) : ?>
                        <!-- .tribe-events-cost -->
                        <p class="h2 text-color-secondary text-right font-family-body"><b><?= tribe_get_cost( null, true ) ?></b></p>
		            <?php endif; ?>
                </div>
            </div>
        </div>

		<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

		<?php while ( have_posts() ) :  the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Event meta -->
	            <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
	            <?php tribe_get_template_part( 'modules/meta' ); ?>
	            <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

                <!-- .tribe-events-single-event-description -->
	            <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
            </div> <!-- #post-x -->

			<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>

		<?php endwhile; ?>

    </div>

    <!-- Event footer -->
    <div id="tribe-events-footer" class="small-12 medium-12 large-12 cell hide">
        <!-- Navigation -->
        <nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
            <ul class="tribe-events-sub-nav">
                <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
            </ul>
            <!-- .tribe-events-sub-nav -->
        </nav>
    </div>
    <!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
