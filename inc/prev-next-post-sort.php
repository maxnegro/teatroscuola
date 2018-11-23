<?php
/**
 * Change default ordering for prev/ next post navigation in Team
 *
 * @package Catch_Fullscreen
 */

function catch_fullscreen_get_adjacent_post_join($join) {
  if (is_singular('team_member')) {
    global $wpdb;
    $new_join = $join . "INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id ";
    return $new_join;
  }
}
add_filter('get_previous_post_join', 'catch_fullscreen_get_adjacent_post_join');
add_filter('get_next_post_join', 'catch_fullscreen_get_adjacent_post_join');

function catch_fullscreen_get_previous_post_where($where) {
  if (is_singular('team_member')) {
    global $wpdb, $post;
    $id = $post->ID;
    $current_order = get_post_meta($id, 'sc_member_order', true);
    $new_where = "WHERE p.post_type = 'team_member' AND p.post_status = 'publish' AND (m.meta_key = 'sc_member_order' AND CAST(m.meta_value AS SIGNED) < $current_order ) ";
    return $new_where;
  }
  return $where;
}
add_filter('get_previous_post_where', 'catch_fullscreen_get_previous_post_where');

function catch_fullscreen_get_next_post_where($where) {
  if (is_singular('team_member')) {
    global $wpdb, $post;
    $id = $post->ID;
    $current_order = get_post_meta($id, 'sc_member_order', true);
    $new_where = "WHERE p.post_type = 'team_member' AND p.post_status = 'publish' AND (m.meta_key = 'sc_member_order' AND CAST(m.meta_value AS SIGNED) > $current_order ) ";
    return $new_where;
  }
  return $where;
}
add_filter('get_next_post_where', 'catch_fullscreen_get_next_post_where');


function catch_fullscreen_post_sort($sql) {
  if (is_singular('team_member')) {
    // echo " bubu! " . str_replace('p.post_date', 'm.sc_member_order', $sql);
    return str_replace('p.post_date', 'm.meta_value+0', $sql);
  }
  return $sql;
}
add_filter( 'get_previous_post_sort', 'catch_fullscreen_post_sort');
add_filter( 'get_next_post_sort', 'catch_fullscreen_post_sort');
