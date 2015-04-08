<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('tr_karakter')){
 function tr_karakter($str, $low = true, $sep = '-', $count = 36) {
       static $chrs;
       $chrs = array('ı'=>'i', 'İ'=>'I', 'ö'=>'o', 'Ö'=>'O', 'ü'=>'u', 'Ü'=>'U', 'ç'=>'c', 'Ç'=>'C', 'ğ'=>'g', 'Ğ'=>'G', 'ş'=>'s', 'Ş'=>'S', 'â'=>'a', 'Â'=>'A', 'ê'=>'e', 'Ê'=>'E', 'î'=>'i', 'Î'=>'I', 'ô'=>'o', 'Ô'=>'O', 'û'=>'u', 'Û'=>'U');
       $str = strtr($str, $chrs);
       $str = preg_replace(array('#[^a-zA-Z0-9'. $sep .']#', '#'. $sep .'+#'), $sep, trim($str));
       if($low) $str = strtolower($str);
       $str =  trim($str, $sep);
       //ilk kac kararkterini alalim
       $str = substr($str, 0, $count);
       return $str;
}
}