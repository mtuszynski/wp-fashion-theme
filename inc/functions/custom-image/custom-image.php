<?php
function custom_image($image, $title = false, $size = 'large') {
  $attachmentImage = wp_get_attachment_image_src($image['id'], $size);

  return '<img 
    src="' . $attachmentImage[0] . '" 
    width="' . $attachmentImage[1] . '" 
    height="' . $attachmentImage[2] . '" 
    srcset="' . esc_attr(wp_get_attachment_image_srcset($image['id'], $size)) . '" 
    loading="lazy"
    alt="' . ($image['alt'] ? $image['alt'] : get_bloginfo('name')) . '"
    ' . ($title ?? 'title="' . ($image['title'] ? $image['title'] : get_bloginfo('name')) . '"') . '>';
}
