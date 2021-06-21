<?php
/**
 * Add custom fields to the posts management page
 *
 * @param $columns
 *
 * @return array
 */
function wpar_add_new_columns( $columns ) {
	$new_columns = array(
		'_EventHideFromUpcoming' => esc_html__( 'Hide for Program Listing', 'read-rec' ),
	);

	// return the columns array back
	return array_merge( $columns, $new_columns );
}

// https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
// manage_{$post_type}_posts_columns action hook
// $post_type is a post type key in the register_post_type().
// I have tribe_events as my projectd post type.
// add_filter( 'manage_tribe_events_posts_columns', 'wpar_add_new_columns' );

/**
 * Populate custom field value
 *
 * @param $column
 * @param $post_id
 */
function wpar_custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case '_EventHideFromUpcoming':
			$proj_published = get_post_meta( $post_id, '_EventHideFromUpcoming', true );
			echo esc_html__( $proj_published );
			break;
		default:
			break;
	}
}

// https://codex.wordpress.org/Plugin_API/Action_Reference/manage_$post_type_posts_custom_column
// add_action( 'manage_tribe_events_posts_custom_column', 'wpar_custom_columns', 10, 2 );

/**
 * Add custom fields to the quick edit box
 *
 * quick_edit_custom_box allows to add HTML in Quick Edit
 *
 * @param $column_name
 * @param $post_type
 */
function wpar_add_quick_edit( $column_name, $post_type ) {
	// $column_name stores only the custom fields
	if ( ! ( $column_name === '60cf980ebae148' ) ) {
		return;
	}

	// # Note
	// The class names that use with fieldset tag,
	// it can be inline-edit-col-left, inline-edit-col-center and inline-edit-col-right.
	//
	// # Trick: You can use the inspection tool from your browser to see what classes the admin page uses in the quick edit box.
	?>

	<?php
	switch ( $column_name ) {
		case '60cf980ebae148':

			// We keeps all our custom fields inside the <fieldset>
			// # a first column then print out the fieldset tag here.
			echo '<fieldset class="inline-edit-col-right" style="border: 1px solid #dddddd; margin-top: 1rem;">
                      <legend style="font-weight: bold; margin-left: 10px;">Event Options:</legend>
                      <div class="inline-edit-col">';

			// # note that, wp_nonce_field() must add it here at the first custom column. DO NOT add outside the switch().
			// Otherwise wp_nonce_field() will render every time that quick_edit_custom_box action hook is called for each column.
			wp_nonce_field( 'wpar_q_edit_nonce', 'wpar_nonce' );
			echo '<label class="alignleft">
                      <input value="yes" type="checkbox" name="60cf980ebae148">
                      <span class="checkbox-title">Hide From Program Listings</span>
                  </label>';
			echo '<br><br>';
			// # a last column then print out the end tags of fieldset here.
			echo '</div></fieldset>';
			break;
		default:
			break;
	}
}

// https://codex.wordpress.org/Plugin_API/Action_Reference/quick_edit_custom_box
add_action( 'quick_edit_custom_box', 'wpar_add_quick_edit', 10, 2 );

/**
 * Save the custom field value from the quick edit box
 *
 * @param $post_id
 *
 * @return mixed|void
 */
function wpar_quick_edit_save( $post_id ) {
	// # For quick edits use $_POST for storing the data.

	// If it is autosave, we don't do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// check user capabilities
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// check nonce
	if ( ! wp_verify_nonce( $_POST['wpar_nonce'], 'wpar_q_edit_nonce' ) ) {
		return;
	}

	// update the website
	if ( isset( $_POST['60cf980ebae148'] ) ) {
		update_post_meta( $post_id, '_EventHideFromUpcoming', $_POST['60cf980ebae148'] );
	} else {
		update_post_meta( $post_id, '_EventHideFromUpcoming', null );
	}
}

// https://developer.wordpress.org/reference/hooks/save_post_post-post_type/
add_action( 'save_post_tribe_events', 'wpar_quick_edit_save' );

/**
 * Populate the custom field values at the quick edit box using Javascript
 */
function wpar_quick_edit_js() {
	// # check the current screen
	// https://developer.wordpress.org/reference/functions/get_current_screen/
	$current_screen = get_current_screen();

	/*
	 * ****************************************
	 * # List of default screen ID in WordPress
	 * ****************************************
	PAGE               $SCREEN_ID           FILE
	-----------------  -------------------  -----------------------
	Media Library      upload               upload.php
	Comments           edit-comments        edit-comments.php
	Tags               edit-post_tag        edit-tags.php
	Plugins            plugins              plugins.php
	Links              link-manager         link-manager.php
	Users              users                users.php
	Posts              edit-post            edit.php
	Pages              edit-page            edit.php
	Edit Site: Themes  site-themes-network  network/site-themes.php
	Themes             themes-network       network/themes
	Users              users-network        network/users
	Edit Site: Users   site-users-network   network/site-users
	Sites              sites-network        network/sites

	If you use the custom post type just like me, you can print out the get_current_screen() object
	for checking what screen ID do you need for the next checking.
	My current screen ID of project post type is "edit-tribe_events".

	var_dump($current_screen);
	exit;
	*/

	if ( $current_screen->id != 'edit-tribe_events' || $current_screen->post_type !== 'tribe_events' ) {
		return;
	}

	// # Make sure jQuery library is loaded because we will use jQuery for populate our custom field value.
	wp_enqueue_script( 'jquery' );
	?>

    <!-- add JS script -->
    <script type="text/javascript">
        jQuery(function ($) {

            // we create a copy of the WP inline edit post function
            const $wpar_inline_editor = inlineEditPost.edit;

            // Note: Hooking inlineEditPost.edit must be done in a JS script, loaded after wp-admin/js/inline-edit-post.js
            // then we overwrite the inlineEditPost.edit function with our own code
            inlineEditPost.edit = function (id) {

                // call the original WP edit function
                $wpar_inline_editor.apply(this, arguments);


                // ### start: add our custom functionality below  ###

                // get the post ID
                let $post_id = 0;
                if (typeof (id) == 'object') {
                    $post_id = parseInt(this.getId(id));
                }

                // if we have our post
                if ($post_id !== 0) {
                    // tips: use the inspecttion tool to help you see the HTML structure on the edit page.

                    // explanation:
                    // On the posts management page, all posts will render inside the <tbody> along with "the-list" id.
                    // Then each post will render on each <tr> along with "post-176" which 176 is my post ID. Your will be difference.
                    // When the quick edit menu is clicked on the "post-176", the <tr> will be set as hide(display:none)
                    // and the new <tr> along with "edit-176" id will be appended after <tr> which is hidden.
                    // What we will do, we will use the jQuery to find the website value from the hidden <tr>.
                    // Get that value and assign to the website input field on the quick edit box.
                    //
                    // The concept is the same when you create the inline editor by jQuery manually.

                    // define the edit row
                    const $edit_row = $('#edit-' + $post_id);
                    const $post_row = $('#post-' + $post_id);

                    // get the data
                    const $checked = $('.column-60cf980ebae148', $post_row).text();

                    if ($checked === "yes") {
                        // populate the data
                        $(':input[name="60cf980ebae148"]', $edit_row).prop("checked", true);
                    }
                }

                // ### end: add our custom functionality below  ###
            }

        });
    </script>
	<?php
}

// https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts-hook_suffix/
add_action( 'admin_print_footer_scripts-edit.php', 'wpar_quick_edit_js' );
