<?php
/**
 * This template renders a the fields for a ticket
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/registration-js/attendees/fields.php
 *
 * @since 4.11.0
 *
 * @version 4.11.0
 *
 */
$meta        = Tribe__Tickets_Plus__Main::instance()->meta();
$required    = $meta->ticket_has_required_meta( $ticket->ID );
?>
<div
	class="tribe-ticket <?php echo $required ? 'tribe-ticket--has-required-meta' : ''; ?>"
	data-ticket-id="<?php echo esc_attr($ticket->ID); ?>">
	<h4 class="tribe-common-b1 tribe-common-b1--bold tribe-tickets__attendee__title"><?php esc_html_e( 'Participant', 'read-rec' ); ?> {{data.attendee_id}}</h4>
	<?php
		$user_id = get_current_user_id();
		if ($user_id) {
			$family_members = Projestic\FamilyMembers\FamilyMembers::getValue($user_id);
			if ($family_members) : ?>
				<div class="tribe-field tribe-tickets__item__attendee__field__select tribe-tickets-meta-required">
					<label class="tribe-common-b1 tribe-common-b2--min-medium tribe-tickets-meta-label" for="family_member_{{data.attendee_id}}">Select family member<?php tribe_required_label( true ); ?></label>
					<select
						id="family_member_{{data.attendee_id}}"
						class="tribe-common-form-control-select__input ticket-meta"
						name="family_member_{{data.attendee_id}}"
						<?php tribe_required( true ); ?>
						>
						<?php foreach ($family_members as $key => $value) : ?>
							<option value="<?= $key ?>"><?= $value['fname'] . ' ' . $value['lname'] ?></option>
						<?php endforeach; ?>
							<option value="-1" selected>Other</option>
					</select>
				</div>
			<?php endif;
		}

	?>
	<?php foreach ( $fields as $field ) : ?>
		<?php
		$value = null;

		$args = array(
			'event_id'   => $event_id,
			'ticket'     => $ticket,
			'field'      => $field,
			'value'      => $value,
			'saved_meta' => $saved_meta,
		);

		$this->template( 'registration-js/attendees/fields/' . $field->type, $args );
		?>
	<?php endforeach; ?>
</div>
