<?php
/**
 * View: List View
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://m.tri.be/1aiy
 *
 * @version 5.0.2
 *
 * @var array $events The array containing the events.
 * @var string $rest_url The REST URL.
 * @var string $rest_nonce The REST nonce.
 * @var int $should_manage_url int containing if it should manage the URL.
 * @var bool $disable_event_search Boolean on whether to disable the event search.
 * @var string[] $container_classes Classes used for the container of the view.
 * @var array $container_data An additional set of container `data` attributes.
 * @var string $breakpoint_pointer String we use as pointer to the current view we are setting up with breakpoints.
 */

$header_classes = ['tribe-events-header'];
if (empty($disable_event_search)) {
    $header_classes[] = 'tribe-events-header--has-event-search';
}
?>

<?php
$term = get_queried_object();

$program_details = get_field('program_details', $term);
$table = get_field('event_table', $term);
$table_title = get_field('table_title', $term);

$description = term_description(get_queried_object_id(), 'tribe_events_cat');
?>

    <div class="grid-container tribe-category-callout" style="margin-top: 50px; margin-bottom: -50px;">
        <div class="callout success">
            <?= $program_details; ?>
        </div>
    </div>

<?php if (!empty ($table) && !empty($table_title)) {
    echo $table_title;
    echo '<table border="1">';
    if (!empty($table['caption'])) {
        echo '<caption>' . $table['caption'] . '</caption>';
    }
    if (!empty($table['header'])) {
        echo '<thead>';
        echo '<tr>';
        foreach ($table['header'] as $th) {
            echo '<th>';
            echo $th['c'];
            echo '</th>';
        }
        echo '</tr>';
        echo '</thead>';
    }
    echo '<tbody>';
    foreach ($table['body'] as $tr) {
        echo '<tr>';
        foreach ($tr as $td) {
            echo '<td>';
            echo $td['c'];
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} ?>

    <div
        <?php tribe_classes($container_classes); ?>
        data-js="tribe-events-view"
        data-view-rest-nonce="<?= esc_attr($rest_nonce); ?>"
        data-view-rest-url="<?= esc_url($rest_url); ?>"
        data-view-manage-url="<?= esc_attr($should_manage_url); ?>"
        <?php foreach ($container_data as $key => $value) : ?>
            data-view-<?= esc_attr($key) ?>="<?= esc_attr($value) ?>"
        <?php endforeach; ?>
        <?php if (!empty($breakpoint_pointer)) : ?>
            data-view-breakpoint-pointer="<?= esc_attr($breakpoint_pointer); ?>"
        <?php endif; ?>
    >
        <div class="tribe-common-l-container tribe-events-l-container">
            <?php $this->template('components/loader', ['text' => __('Loading...', 'the-events-calendar')]); ?>

            <?php $this->template('components/json-ld-data'); ?>

            <?php $this->template('components/data'); ?>

            <?php $this->template('components/before'); ?>

            <header <?php tribe_classes($header_classes); ?>>
                <?php $this->template('components/messages'); ?>

                <?php $this->template('components/breadcrumbs'); ?>

                <?php $this->template('components/events-bar'); ?>

                <?php $this->template('list/top-bar'); ?>
            </header>

            <?php $this->template('components/filter-bar'); ?>

            <div class="tribe-events-calendar-list">

                <?php foreach ($events as $event) : ?>
                    <?php $this->setup_postdata($event); ?>

                    <?php $this->template('list/month-separator', ['event' => $event]); ?>

                    <?php $this->template('list/event', ['event' => $event]); ?>

                <?php endforeach; ?>

            </div>

            <?php $this->template('list/nav'); ?>

            <?php $this->template('components/ical-link'); ?>

            <?php $this->template('components/after'); ?>

        </div>
    </div>

<?php $this->template('components/breakpoints'); ?>