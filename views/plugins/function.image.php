<?php


function smarty_function_image($params ) {
    
    include_once 'helpers/image.php';

    $no_image = 'media/default/no_image.jpg';
    $cache_path = 'media/cache/';
    
    $defualt_width = 60;
    $defualt_height = $defualt_width;

    
    $src = array_key_exists('src', $params) ? $params['src'] : $no_image;
    $function = array_key_exists('function', $params) ? $params['function'] : 'crop';
    $alt = array_key_exists('alt', $params) ? $params['alt'] : '';
    $width = array_key_exists('width', $params) ? $params['width'] : $defualt_width;
    $height = array_key_exists('height', $params) ? $params['height'] : $defualt_height;
    $class = array_key_exists('class', $params) ? $params['class'] : '';
    $align = array_key_exists('align', $params) ? $params['align'] : '';
    $return_element = array_key_exists('return_element', $params) ? $params['return_element'] : true;
    $echo = array_key_exists('echo', $params) ? $params['echo'] : true;
  
    $image = image::getInstance();
    
    if(!$image->is_image($src)) {
        $src = $no_image;
    }
    
    if( !file_exists($src) ) {
        $src = $no_image;
        
    }
    
    $new_src = $cache_path . $function.'-'.$width.'-'.$height.'-'. basename($src);
    
    if( !file_exists($new_src) ) {
    
        switch ($function)  {
            case 'crop':
                $image->crop($src, $width, $height, $new_src );
            break;
            case 'resize':
                $image->resize($src, $width, $height, $new_src );
            break;
        }
    
    }
    
    if($return_element) {
        if($echo) {
            echo "<img alt='{$alt}' width='{$width}' height='{$height}' class='{$class}' title='{$alt}' src='/{$new_src}' align='{$align}' title='{$alt}' /> ";
        } else {
            return "<img alt='{$alt}' width='{$width}' height='{$height}' class='{$class}' title='{$alt}' src='/{$new_src}' align='{$align}' title='{$alt}' /> ";
        }
    } else {
        if($echo) {
            echo $new_src;
        } else {
            return $new_src;
        }
    }

}
?>
