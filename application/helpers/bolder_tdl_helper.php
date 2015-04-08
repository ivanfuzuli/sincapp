<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('bolder_tdl')){
 	function bolder_tdl($str) {
 		$str = str_replace(".com","<b>.com</b>",$str);
 		$str = str_replace(".net","<b>.net</b>",$str);
 		$str = str_replace(".org","<b>.org</b>",$str);
 		$str = str_replace(".biz","<b>.biz</b>",$str);

 		return $str;
	}
}