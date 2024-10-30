<?php

namespace Sirvelia\CBT;


/**
 * EDIT TITLE PLACEHOLDER
 *
 * @since    1.0.0
 */
add_filter('enter_title_here', function ($title , $post){

  if( $post->post_type == 'block-template' ) return __("Template name", 'custom-blocks-templates');
  return $title;

 } , 20 , 2 );


 /**
  * EDIT ADD NEW BLOCK PLACEHOLDER
  *
  * @since    1.0.0
  */
 add_filter('write_your_story', function ($text , $post){

   if( $post->post_type == 'block-template' ) return __("Add a new block to the template", 'custom-blocks-templates');
   return $text;

 } , 10 , 2 );
