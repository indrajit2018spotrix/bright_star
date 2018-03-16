<?php

	namespace helper;
	use DateTime;
	use DateTimeZone;
	use DateInterval;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_datetime_library{

		public static function get_DateTimeZone(){
			$timezone_list = DateTimeZone::listIdentifiers();
			$selected_timezone = $GLOBALS['_-_-_manifest_-_-_']['_-_-_timezone_-_-_'];
			$zone_found = false;
			$zone_index = 0;

			foreach($timezone_list as $timezone){
				$zone_position = stripos($timezone, $selected_timezone);
				if($zone_position !== false){
					$zone_found = true;
					break;
				}
				$zone_index++;
			}

			if($zone_found)
				return $timezone_list[$zone_index];
			else
				return 'Asia/Kolkata';
		}

		public static function datetime_format($date, $format){
			if($format == "datetime_micro"){
				$date_time = $date->format('Y-m-d H:i:s');
				$microtime = explode(".", microtime(TRUE));
				$date_time = $date_time . ":" . end($microtime);

			}
			elseif($format == "time_micro"){
				$date_time = $date->format('H:i:s');
				$microtime = explode(".", microtime(TRUE));
				$date_time = $date_time . ":" . end($microtime);
			}
			elseif($format == "datetime")
				$date_time = $date->format('Y-m-d H:i:s');
			elseif($format == "date")
				$date_time = $date->format('Y-m-d');
			elseif($format == "time")
				$date_time = $date->format('H:i:s');

			return $date_time;
		}

		public static function current_time($format){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function yesterday_time($format){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString('yesterday'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function tomorrow_time($format){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString('tomorrow'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function next_week_time($format){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString('+7 day'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function previous_week_time($format){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString('-7 day'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function get_datetime_with_day_interval($format, $interval){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString($interval.' day'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function get_datetime_with_hour_interval($format, $interval){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString($interval.' hour'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function get_datetime_with_minute_interval($format, $interval){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString($interval.' minute'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}

		public static function get_datetime_with_second_interval($format, $interval){
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone(vortex_datetime_library::get_DateTimeZone()));
			$date->add(DateInterval::createFromDateString($interval.' second'));

			$date_time = vortex_datetime_library::datetime_format($date, $format);
			return $date_time;
		}
		
	}

?>