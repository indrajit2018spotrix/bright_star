<?php

    namespace helper;

    if(!defined('_-_-_APP_CONSTANT_-_-_')){
        die();
    }

    class vortex_image_resize_library{

        public static function img_resize($target, $newcopy, $w, $h, $ext){
            chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
            list($w_orig, $h_orig) = getimagesize($target);

            $scale_ratio = $w_orig / $h_orig;
            if(($w/$h) > $scale_ratio)
            $w = $h*$scale_ratio;
            else
            $h = $w/$scale_ratio;

            $img = "";
            $ext = strtolower($ext);
            if($ext=="gif" || $ext=="GIF")
            $img = imagecreatefromgif($target);
            elseif($ext=="png" || $ext=="PNG")
            $img = imagecreatefrompng($target);
            else
            $img = imagecreatefromjpeg($target);
            
            $tci = imagecreatetruecolor($w, $h);

            imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
            imagejpeg($tci, $newcopy, 84);
        }

    }

?>