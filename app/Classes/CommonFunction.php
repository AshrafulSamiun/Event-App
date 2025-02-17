<?php

namespace App\Classes;


class CommonFunction{

	public function check_internet_connection()
	{
		return 0;
	}


	public function convert_time_arr($time_arr)
	{

		//return $time_arr["A"];
		$period = $time_arr["A"]; // AM or PM
		$hour = (int) $time_arr["hh"];
		$minute = (int) $time_arr["mm"];
		$second = (int) $time_arr["ss"];
	
		// Convert to 24-hour format
		if ($period === 'PM' && $hour !== 12) {
			$hour += 12;
		} elseif ($period === 'AM' && $hour === 12) {
			$hour = 0;
		}
	
		// Format as MySQL TIME (H:i:s)
		$formattedTime = sprintf('%02d:%02d:%02d', $hour, $minute, $second);

		return $formattedTime;

	}

	public function get_converted_time($time_string)
	{
		if(date('H', strtotime($time_string))>=12) $a="PM";
		else $a="AM";

		$converted_time=[
            'hh' => date('H', strtotime($time_string)),
            'mm' => date('i', strtotime($time_string)),
            'ss' => date('s', strtotime($time_string)),
			'A' => $a,
			
        ];
		//dd($converted_time);
		return $converted_time;
	}



	
}





?>