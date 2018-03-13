<?php

	namespace helper;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_user_info_library{

		public static function getRealIpAddr(){

		    if(!empty($_SERVER['HTTP_CLIENT_IP']))
		    	$ip = $_SERVER['HTTP_CLIENT_IP'];
		    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		    	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    else
		    	$ip = $_SERVER['REMOTE_ADDR'];

		    return $ip;

		}

		public static function user_area_info(){

			// echo $this->getRealIpAddr() . "<br>";
			// $user_ip = $this->getRealIpAddr();
			$user_ip = vortex_user_info_library::getRealIpAddr();
			$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
			// $city = $geo["geoplugin_city"];
			// $region = $geo["geoplugin_regionName"];
			// $country = $geo["geoplugin_countryName"];
			// echo "User agent: " . $GLOBALS['_-_-_SERVER_VARS_-_-_']['USER_AGENT_INFO'];
			// echo "area code: ".$geo['geoplugin_areaCode'] . "<br>";
			// echo "dma code: ".$geo['geoplugin_dmaCode'] . "<br>";
			// echo "continent code: ".$geo['geoplugin_continentCode'] . "<br>";
			// echo "lat: ".$geo['geoplugin_latitude'] . "<br>";
			// echo "lng: ".$geo['geoplugin_longitude'] . "<br>";
			// echo "currency code: ".$geo['geoplugin_currencyCode'] . "<br>";
			// echo "status: ".$geo['geoplugin_status'] . "<br>";
			// echo "City: ".$city."<br>";
			// echo "Region: ".$geo['geoplugin_regionCode'].": ".$region."<br>";
			// echo "Country: ".$geo['geoplugin_countryCode'].": ".$country."<br>";
			// user agent
			// echo $_SERVER['HTTP_USER_AGENT'];
			// $browser = get_browser();
			// print_r($browser);

			return [
		        'User_Agent' 		=> $GLOBALS['_-_-_SERVER_VARS_-_-_']['USER_AGENT_INFO'],
		        'Area_Code'      	=> $geo['geoplugin_areaCode'],
		        'DMA_Code'   		=> $geo['geoplugin_dmaCode'],
		        'Continent_Code'  	=> $geo['geoplugin_continentCode'],
		        'Currency_Code'    	=> $geo['geoplugin_currencyCode'],
		        'Status'    		=> $geo['geoplugin_status']
		    ];

		    // Status != 404

		}

		public static function user_location_info(){

			$user_ip = vortex_user_info_library::getRealIpAddr();
			$geo = unserialize(file_get_contents("http://ip-api.com/php/$user_ip"));
			// $city = $geo["city"];
			// $region = $geo["regionName"];
			// $country = $geo["country"];
			// echo "area code: ".$geo['geoplugin_areaCode'] . "<br>";
			// echo "dma code: ".$geo['geoplugin_dmaCode'] . "<br>";
			// echo "continent code: ".$geo['geoplugin_continentCode'] . "<br>";
			// echo "lat: ".$geo['lat'] . "<br>";
			// echo "lng: ".$geo['lon'] . "<br>";
			// echo "currency code: ".$geo['geoplugin_currencyCode'] . "<br>";
			// echo "status: ".$geo['status'] . "<br>";
			// echo "City: ".$city."<br>";
			// echo "Zip: ".$geo['zip']."<br>";
			// echo "TimeZone: ".$geo['timezone']."<br>";
			// echo "ISP: ".$geo['isp']."<br>";
			// echo "Organization: ".$geo['org']."<br>";
			// echo "AS Number: ".$geo['as']."<br>";
			// echo "Query: ".$geo['query']."<br>";
			// echo "Region: ".$geo['region'].": ".$region."<br>";
			// echo "Country: ".$geo['countryCode'].": ".$country."<br>";

			return [
		        'Lat' 			=> $geo['lat'],
		        'Lng'      		=> $geo['lon'],
		        'City'  		=> $geo['city'],
		        'Zip'  			=> $geo['zip'],
		        'TimeZone'    	=> $geo['timezone'],
		        'ISP' 			=> $geo['isp'],
		        'Organization'  => $geo['org'],
		        'AS_Number'   	=> $geo['as'],
		        'Query'  		=> $geo['query'],
		        'Region_Code'   => $geo['region'],
		        'Region'    	=> $geo['regionName'],
		        'Country_Code'  => $geo['countryCode'],
		        'Country'    	=> $geo['country'],
		        'Status'    	=> $geo['status']
		    ];

		    // Status == success

		}

		public static function getBrowser(){

		    $u_agent = $GLOBALS['_-_-_SERVER_VARS_-_-_']['USER_AGENT_INFO']; 
		    $bname = 'Unknown';
		    $platform = 'Unknown';
		    $version= "";

		    //First get the platform?
		    if (preg_match('/linux/i', $u_agent)) {
		        $platform = 'linux';
		    }
		    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		        $platform = 'mac';
		    }
		    elseif (preg_match('/windows|win32/i', $u_agent)) {
		        $platform = 'windows';
		    }

		    // Next get the name of the useragent yes seperately and for good reason
		    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
		    { 
		        $bname = 'Internet Explorer'; 
		        $ub = "MSIE"; 
		    } 
		    elseif(preg_match('/Firefox/i',$u_agent)) 
		    { 
		        $bname = 'Mozilla Firefox'; 
		        $ub = "Firefox"; 
		    }
		    elseif(preg_match('/OPR/i',$u_agent)) 
		    { 
		        $bname = 'Opera'; 
		        $ub = "Opera"; 
		    } 
		    elseif(preg_match('/Chrome/i',$u_agent)) 
		    { 
		        $bname = 'Google Chrome'; 
		        $ub = "Chrome"; 
		    } 
		    elseif(preg_match('/Safari/i',$u_agent)) 
		    { 
		        $bname = 'Apple Safari'; 
		        $ub = "Safari"; 
		    } 
		    elseif(preg_match('/Netscape/i',$u_agent)) 
		    { 
		        $bname = 'Netscape'; 
		        $ub = "Netscape"; 
		    } 

		    // finally get the correct version number
		    $known = array('Version', $ub, 'other');
		    $pattern = '#(?<browser>' . join('|', $known) .
		    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		    if (!preg_match_all($pattern, $u_agent, $matches)) {
		        // we have no matching number just continue
		    }

		    // see how many we have
		    $i = count($matches['browser']);
		    if ($i != 1) {
		        //we will have two since we are not using 'other' argument yet
		        //see if version is before or after the name
		        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
		            $version= $matches['version'][0];
		        }
		        else {
		            $version= $matches['version'][1];
		        }
		    }
		    else {
		        $version= $matches['version'][0];
		    }

		    // check if we have a number
		    if ($version==null || $version=="") {$version="?";}

		    return [
		        'User_Agent' 	=> $u_agent,
		        'Browser_Name'  => $bname,
		        'Version'   	=> $version,
		        'Platform'  	=> $platform,
		        'Pattern'    	=> $pattern
		    ];

		}

		public static function systemInfo(){

		    $user_agent = $GLOBALS['_-_-_SERVER_VARS_-_-_']['USER_AGENT_INFO'];
		    $os_platform    = "Unknown OS Platform";

		    $os_array       = array('/windows phone 8/i'    =>  'Windows Phone 8',
		                            '/windows phone os 7/i' =>  'Windows Phone 7',
		                            '/windows nt 6.3/i'     =>  'Windows 8.1',
		                            '/windows nt 6.2/i'     =>  'Windows 8',
		                            '/windows nt 6.1/i'     =>  'Windows 7',
		                            '/windows nt 6.0/i'     =>  'Windows Vista',
		                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		                            '/windows nt 5.1/i'     =>  'Windows XP',
		                            '/windows xp/i'         =>  'Windows XP',
		                            '/windows nt 5.0/i'     =>  'Windows 2000',
		                            '/windows me/i'         =>  'Windows ME',
		                            '/win98/i'              =>  'Windows 98',
		                            '/win95/i'              =>  'Windows 95',
		                            '/win16/i'              =>  'Windows 3.11',
		                            '/macintosh|mac os x/i' =>  'Mac OS X',
		                            '/mac_powerpc/i'        =>  'Mac OS 9',
		                            '/linux/i'              =>  'Linux',
		                            '/ubuntu/i'             =>  'Ubuntu',
		                            '/iphone/i'             =>  'iPhone',
		                            '/ipod/i'               =>  'iPod',
		                            '/ipad/i'               =>  'iPad',
		                            '/android/i'            =>  'Android',
		                            '/blackberry/i'         =>  'BlackBerry',
		                            '/webos/i'              =>  'Mobile');

		    $found = false;
		    // $addr = new RemoteAddress;
		    $device = '';

		    foreach ($os_array as $regex => $value) 
		    { 
		        if($found)
		        	break;
		        else if (preg_match($regex, $user_agent)) 
		        {
		            $os_platform    =   $value;
		            $device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
		                      ?'MOBILE':(preg_match('/phone/i', $os_platform)?'MOBILE':'SYSTEM');
		        }
		    }

		    $device = !$device? 'SYSTEM':$device;

		    return [
		    	'OS'		=>	$os_platform,
		    	'Device'	=>	$device
		    ];

		}

		public static function getOS(){ 

		    $user_agent = $GLOBALS['_-_-_SERVER_VARS_-_-_']['USER_AGENT_INFO'];

		    $os_platform    =   "Unknown OS Platform";

		    $os_array       =   array(
		                            '/windows nt 10/i'     =>  'Windows 10',
		                            '/windows nt 6.3/i'     =>  'Windows 8.1',
		                            '/windows nt 6.2/i'     =>  'Windows 8',
		                            '/windows nt 6.1/i'     =>  'Windows 7',
		                            '/windows nt 6.0/i'     =>  'Windows Vista',
		                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		                            '/windows nt 5.1/i'     =>  'Windows XP',
		                            '/windows xp/i'         =>  'Windows XP',
		                            '/windows nt 5.0/i'     =>  'Windows 2000',
		                            '/windows me/i'         =>  'Windows ME',
		                            '/win98/i'              =>  'Windows 98',
		                            '/win95/i'              =>  'Windows 95',
		                            '/win16/i'              =>  'Windows 3.11',
		                            '/macintosh|mac os x/i' =>  'Mac OS X',
		                            '/mac_powerpc/i'        =>  'Mac OS 9',
		                            '/linux/i'              =>  'Linux',
		                            '/ubuntu/i'             =>  'Ubuntu',
		                            '/iphone/i'             =>  'iPhone',
		                            '/ipod/i'               =>  'iPod',
		                            '/ipad/i'               =>  'iPad',
		                            '/android/i'            =>  'Android',
		                            '/blackberry/i'         =>  'BlackBerry',
		                            '/webos/i'              =>  'Mobile'
		                        );

		    foreach ($os_array as $regex => $value) { 

		        if (preg_match($regex, $user_agent)) {
		            $os_platform    =   $value;
		        }

		    }   

		    return $os_platform;

		}

		public static function fetch_user_info(){

			$userinfo_cluster = array(
				"User_Area_Info" => vortex_user_info_library::user_area_info(),
				// "User_Location_Info" => vortex_user_info_library::user_location_info(),
				"User_Browser_Info" => vortex_user_info_library::getBrowser(),
				"User_System_Info" => vortex_user_info_library::systemInfo(),
				"User_OS" => vortex_user_info_library::getOS()
			);

			$user_data["user_agent"] = $userinfo_cluster['User_Area_Info']['User_Agent'];

			if($userinfo_cluster['User_Area_Info']['Status'] != 404){
				$user_data["area_code"] = $userinfo_cluster['User_Area_Info']['Area_Code'];
				$user_data["dma_code"] = $userinfo_cluster['User_Area_Info']['DMA_Code'];
				$user_data["continent_code"] = $userinfo_cluster['User_Area_Info']['Continent_Code'];
				$user_data["currency_code"] = $userinfo_cluster['User_Area_Info']['Currency_Code'];
			}


			// if($userinfo_cluster['User_Location_Info']['Status'] == 'success'){

			// 	$user_data["lat"] = $userinfo_cluster['User_Location_Info']['Lat'];
			// 	$user_data["lng"] = $userinfo_cluster['User_Location_Info']['Lng'];
			// 	$user_data["city"] = $userinfo_cluster['User_Location_Info']['City'];
			// 	$user_data["zip"] = $userinfo_cluster['User_Location_Info']['Zip'];
			// 	$user_data["timezone"] = $userinfo_cluster['User_Location_Info']['TimeZone'];
			// 	$user_data["isp"] = $userinfo_cluster['User_Location_Info']['ISP'];
			// 	$user_data["organization"] = $userinfo_cluster['User_Location_Info']['Organization'];
			// 	$user_data["as_number"] = $userinfo_cluster['User_Location_Info']['AS_Number'];
			// 	$user_data["query"] = $userinfo_cluster['User_Location_Info']['Query'];
			// 	$user_data["region_code"] = $userinfo_cluster['User_Location_Info']['Region_Code'];
			// 	$user_data["region"] = $userinfo_cluster['User_Location_Info']['Region'];
			// 	$user_data["country_code"] = $userinfo_cluster['User_Location_Info']['Country_Code'];
			// 	$user_data["country"] = $userinfo_cluster['User_Location_Info']['Country'];

			// }

			$user_data["browser_name"] = $userinfo_cluster['User_Browser_Info']['Browser_Name'];
			$user_data["version"] = $userinfo_cluster['User_Browser_Info']['Version'];
			$user_data["platform"] = $userinfo_cluster['User_Browser_Info']['Platform'];

			$user_data["device"] = $userinfo_cluster['User_System_Info']['Device'];

			$user_data["user_os"] = $userinfo_cluster['User_OS'];

			return $user_data;

		}

		public static function get_user_info(){
			return vortex_user_info_library::fetch_user_info();
		}
		
	}

?>
