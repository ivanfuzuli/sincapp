<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(! function_exists('time_converter')){
function time_converter($time){
        $time_difference = time() - $time;

        $seconds = $time_difference ;
        $minutes = round($time_difference / 60 );
        $hours = round($time_difference / 3600 );
        $days = round($time_difference / 86400 );
        $weeks = round($time_difference / 604800 );
        $months = round($time_difference / 2419200 );
        $years = round($time_difference / 29030400 );
        // Seconds
        if($seconds <= 60){
        $value = "$seconds saniye önce";
        }
        //Minutes
        else if($minutes <=60){

        if($minutes==1)
        {
        $value = "1 dakika önce";
        }
        else
        {
        $value = "$minutes dakika önce";
        }

        }
        //Hours
        else if($hours <=24)
        {

        if($hours==1)
        {
        $value = "1 saat önce";
        }
        else
        {
        $value = "$hours saat önce";
        }
        }
        //Days
        else if($days <= 7){

        if($days==1)
        {
        $value = "1 gün önce";
        }
        else
        {
        $value = "$days gün önce";
        }

        }
        //Weeks
        else{

        if($weeks==1){
        $value = "1 hafta önce";
        }else{
        $value = date('d.m.Y',$time);
        }

        }

        return $value;
        }
}