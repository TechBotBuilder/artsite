<?php 
namespace image;

// source JKirchartz https://stackoverflow.com/a/3468588
// @param cg : color granularity, hex increments in which to round colors.
// returns at most $numColors values like '00,30,FA'
function colorPalette($img, $numColors, $granularity = 4, $cg = 0x33) 
{
   $granularity = max(1, abs((int)$granularity));
   $colors = array();
   $size = array(imagesx($img), imagesy($img));
   
   for($x = 0; $x < $size[0]; $x += $granularity)
   {
      for($y = 0; $y < $size[1]; $y += $granularity)
      {
         $thisColor = imagecolorat($img, $x, $y);
         $rgb = imagecolorsforindex($img, $thisColor);
         $red = round(round(($rgb['red'] / $cg)) * $cg);
         $green = round(round(($rgb['green'] / $cg)) * $cg);
         $blue = round(round(($rgb['blue'] / $cg)) * $cg);
         $thisRGB = sprintf('%02X,%02X,%02X', $red, $green, $blue);
         if(array_key_exists($thisRGB, $colors))
         {
            $colors[$thisRGB]++;
         }
         else
         {
            $colors[$thisRGB] = 1;
         }
      }
   }
   arsort($colors);
   return array_slice(array_keys($colors), 0, $numColors);
}

function mainColor($imageFile, $granularity = 4, $color_granularity = 0x33)
{
   return colorPalette($imageFile, 1, $granularity, $color_granularity)[0];
}


//https://www.php.net/manual/en/function.imagecopymerge.php#92787 by Sina Salek
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
   // creating a cut resource
   $cut = imagecreatetruecolor($src_w, $src_h);

   // copying relevant section from background to the cut resource
   imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

   // copying relevant section from watermark to the cut resource
   imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

   // insert cut resource to destination image
   imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}
