<?php

/**
 * Duplicate a page and save it as a draft.
 * A "merge" button appears in the duplicate page.
 * Do any changes in the copy and press the "merge" button to merge with its original and delete the duplication copy.
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

/*
 * Function for page duplication. Dups appear as drafts. User is redirected to the edit screen
 */
add_action( 'admin_action_nr_duplicate_page_as_draft', function() {
  global $wpdb;

  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'nr_duplicate_page_as_draft' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }

  /*
   * Nonce verification
   */
  if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
    return;

  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );

  /*
   * and all the original post data then
   */
  $post = get_post( $post_id );

  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {
    /*
     * new post data array
     */
    $args = [
      'post_author'           => $post->post_author,
      'post_content'          => str_replace('\\', '\\\\', $post->post_content),
      'post_content_filtered' => $post->post_content_filtered,
      'post_title'            => $post->post_title,
      'post_excerpt'          => $post->post_excerpt,
      'post_status'           => 'draft',
      'post_type'             => $post->post_type,
      'comment_status'        => $post->comment_status,
      'ping_status'           => $post->ping_status,
      'post_password'         => $post->post_password,
      'post_name'             => $post->post_name.'-'.$post->ID,
      'to_ping'               => $post->to_ping,
      'pinged'                => $post->pinged,
      'post_parent'           => $post->post_parent,
      'menu_order'            => $post->menu_order,
      'post_mime_type'        => $post->post_mime_type,
      'guid'                  => $post->guid,
      'post_category'         => $post->post_category,
      'tags_input'            => $post->tags_input,
      'tax_input'             => $post->tax_input,
      'meta_input'            => [
                                    '_duplicate_of_post' => $post->ID
                                  ]
    ];

    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post( $args );

    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");

    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));

      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }

    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );

    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
} );

/*
 * Function for page mergin. Delete duplicate page and redirect to the original page.
 */
add_action( 'admin_action_nr_merge_page', function(){
  global $wpdb;

  if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'nr_merge_page' == $_REQUEST['action'] ) ) ) {
    wp_die('No post to duplicate has been supplied!');
  }

  /*
   * Nonce verification
   */
  if ( !isset( $_GET['merge_nonce'] ) || !wp_verify_nonce( $_GET['merge_nonce'], basename( __FILE__ ) ) ) {
    wp_die('Nonce fails');
    return;
  }

  /*
   * get the duplicate post id
   */
  $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );

  if (!$post_id) {
    wp_die('post_id fails');
  }

  /*
   * and all the duplicate post data then
   */
  $post = get_post( $post_id );

  /*
   * and all the duplicate post data then
   */
  $original_post = get_post( $post->_duplicate_of_post );

  /*
   * if post data exists, create the post duplicate
   */
  if (isset( $post ) && $post != null) {
    /*
     * new post data array
     */
    $args = [
      'ID'                    => $original_post->ID, // id of the original post so we are updating it.
      'post_author'           => $post->post_author,
      'post_content'          => str_replace('\\', '\\\\', $post->post_content),
      'post_content_filtered' => $post->post_content_filtered,
      'post_title'            => $post->post_title,
      'post_excerpt'          => $post->post_excerpt,
      'post_status'           => 'publish',
      'post_type'             => $post->post_type,
      'comment_status'        => $post->comment_status,
      'ping_status'           => $post->ping_status,
      'post_password'         => $post->post_password,
      'post_name'             => $original_post->post_name,
      'to_ping'               => $post->to_ping,
      'pinged'                => $post->pinged,
      'post_parent'           => $post->post_parent,
      'menu_order'            => $post->menu_order,
      'post_mime_type'        => $post->post_mime_type,
      'guid'                  => $original_post->guid,
      'post_category'         => $post->post_category,
      'tags_input'            => $post->tags_input,
      'tax_input'             => $post->tax_input,
    ];

    /*
     * insert the post by wp_insert_post() function
     */
    wp_insert_post( $args );

    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");

    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));

      wp_set_object_terms($post->_duplicate_of_post, $post_terms, $taxonomy, false);
    }

    /**
     * Delete the duplicate post
     */
    wp_delete_post($post->ID, true);

    /*
     * finally, redirect to the edit post screen for the new draft
     */

    if (is_current_user_admin_or_nr_admin()) {
      wp_redirect( admin_url( 'admin.php?page=nestedpages') );
    } else {
      wp_redirect( admin_url( 'edit.php?post_type=page') );
    }

    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
} );


add_filter( 'page_row_actions', function( $actions, $post ) {
  /*
   * Add the duplicate link to action list for post_row_actions
   */
  if (current_user_can('edit_pages') && $post->post_status != 'draft') {
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=nr_duplicate_page_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '"
    rel="permalink" target="_blank">Create a draft copy</a>';
  }

  /*
   * Add "merge to original post and delete draf post" button
   * Only if _duplicate_of_post
   */
  if (current_user_can('edit_pages') && $post->post_status == 'draft' && !empty($post->_duplicate_of_post)) {
    $actions['delete_draft'] = '<a href="' . wp_nonce_url('admin.php?action=nr_merge_page&post=' . $post->ID, basename(__FILE__), 'merge_nonce' ) . '"
    rel="permalink">Merge to original page and delete this draft</a>';
  }

  return $actions;
}, 10, 2 );


/**
 * Add styles to the admin area
 * Style buttons
 */
add_action('admin_enqueue_scripts', function () {
  ?>
  <style>
    ul.np-assigned-pt-actions > li > a {
      border: 1px solid #e1e1e1 !important;
      padding: 6.5px 6.5px !important;
      background: #f7f7f7 !important;
    }
    ul.np-assigned-pt-actions > li > a:hover {
      background: #0074a2 !important;
      color: #fff !important;
    }
  </style>
  <?php
});


