<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('tr_karakter')){
function turkcetarih($zaman) {  
	$gunler = array(  
	"Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"  
	);  

	$aylar =array(  
	NULL, "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"  
	);  
	$tarih = date("d",$zaman)." ".$aylar[date("n",$zaman)]." ".date("Y",$zaman)." ".$gunler[date("w",$zaman)];  
	return $tarih;  
	}
}