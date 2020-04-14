<?php 
namespace image;

// source JKirchartz https://stackoverflow.com/a/3468588
// @param cg : color granularity, hex increments in which to round colors.
// returns at most $numColors values like '00,30,FA'
function colorPalette(&$img, $numColors, $granularity = 4, $cg = 0x33) 
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

function mainColor(&$imageFile, $granularity = 4, $color_granularity = 0x33)
{
   return colorPalette($imageFile, 1, $granularity, $color_granularity)[0];
}
