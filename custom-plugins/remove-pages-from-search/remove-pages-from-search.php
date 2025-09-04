<?php

/**
 * Remove pages from search results
 */
add_action( 'pre_get_posts', function ( $query ) {
  if ( ! $query->is_admin && $query->is_search && $query->is_main_query() ) {
    $query->set( 'post__not_in', [5495, 54406,  55049, 55050, 55051, 55052, 55053, 55054, 77583, 80198 ] );
  }
} );
