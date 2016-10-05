<?php

add_action('wp_enqueue_scripts', 'porto_child_css', 1001);
 
// Load CSS
function porto_child_css() {
    // porto child theme styles
    wp_deregister_style( 'styles-child' );
    wp_register_style( 'styles-child', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'styles-child' );

    if (is_rtl()) {
        wp_deregister_style( 'styles-child-rtl' );
        wp_register_style( 'styles-child-rtl', get_stylesheet_directory_uri() . '/style_rtl.css' );
        wp_enqueue_style( 'styles-child-rtl' );
    }
}



function lang_category_id($id){
  if(function_exists('icl_object_id')) {
    return icl_object_id($id,'category',true);
  } else {
    return $id;
  }
}



function lang_object_ids($ids_array, $type) {
 if(function_exists('icl_object_id')) {
  $res = array();
  foreach ($ids_array as $id) {
   $xlat = icl_object_id($id,$type,false);
   if(!is_null($xlat)) $res[] = $xlat;
  }
  return $res;
 } else {
  return $ids_array;
 }
}


