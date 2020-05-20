<?php 
function custom_query_shortcode($atts) {

   // EXAMPLE USAGE:
   // [loop args="showposts=100&post_type=page&post_parent=453"]
   
  extract(shortcode_atts(array("args" => ''), $atts));

  $input = html_entity_decode($atts["args"]);
  $input = str_replace('&', ';', $input);
  $chunks = array_chunk(preg_split('/(;|=)/', $input), 2);
  $args = array_combine(array_column($chunks, 0), array_column($chunks, 1));

  $posts = get_posts($args);

   foreach ($posts as $post) {
    ++$post_count;
    $post_entry = '<div id="'.$post->post_type.'-'.$post->ID.'" class="post-entry entry-'.$post_count.'">';
      if (has_post_thumbnail($post)) { $post_entry .= get_the_post_thumbnail($post, 'card'); }
      if (get_the_title($post)) { $post_entry .= '<h3>'.get_the_title($post).'</h3>'; }
      if (get_the_excerpt($post)) { $post_entry .= '<p class="excerpt">'.get_the_excerpt($post).'</p>'; }
      if (get_the_permalink($post)) { $post_entry .= '<a href="'.get_the_permalink($post).'">'.__('Weiterlesen', 'brainbox').'</a>'; }
    $post_entry .= '</div>';
    $result[] = $post_entry;

  }

  $html = '<div class="query--container">'.implode('', $result).'</div>';
  return $html;
  }
  add_shortcode('loop', 'custom_query_shortcode');
?>
