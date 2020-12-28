<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		/**
		* Initiatize main file
		*/
		$this->load->view('load_file');
	}
	public function get_data()
	{
		$startdate = $_POST['startDate'];
		$enddate = $_POST['endDate'];
		/**
		* Call Nasa API using CURL
		* Get API response in $output
		*/
		$url = "https://api.nasa.gov/neo/rest/v1/feed?start_date=".$startdate."&end_date=".$enddate."&api_key=sJreIwZQlLaBpTKbmUi76lDa3F5MPO0xTewQjSq1";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $json_decode = json_decode($output, true);
		/**
		* Get near_earth_objects from above decode JSON
		* And store them into $near_earth_objects
		*/
		$near_earth_objects = $json_decode['near_earth_objects'];
		$astroidCount = [];
		$diameter_in_kilometer_array = [];
		$average_array = [];
		$fastestAstroidArray = [];
		$closestAstroidArray = [];
		$resAstroidID = [];

		/**
		* Find all dates from start date to end date using AddDates() Private function
		*/
		$getAllDates = $this->AllDates($startdate, $enddate);
		foreach ($getAllDates as $value) {
			array_push($astroidCount,count($near_earth_objects[$value]));
			$close_approach_data = array_column($near_earth_objects[$value],'close_approach_data');
			$estimated_diameter = array_column($near_earth_objects[$value],'estimated_diameter');
			$diameter_in_kilometer = array_column($estimated_diameter,'kilometers');
			$astroidID = array_column($near_earth_objects[$value],'id');

			foreach ($diameter_in_kilometer as $value) {
				$averageAstroidSize = $value['estimated_diameter_min'] + $value['estimated_diameter_max'] / 2 ;
				array_push($average_array,$averageAstroidSize);
			}

			array_push($diameter_in_kilometer_array,$diameter_in_kilometer);
			//Fastest Astroid
			$close = array_column($close_approach_data,'0');
			$relative_velocity = array_column($close,'relative_velocity');
			$kilometers_per_hour = array_column($relative_velocity,'kilometers_per_hour');

			/**
			* Initialize for loop to calculate fastest astroid, closest astroid and its ID
			*/
			$miss_distance = array_column($close,'miss_distance');
			$kilometers = array_column($miss_distance,'kilometers');
			for ($i=0;$i<count($astroidID);$i++ ) {
				array_push($resAstroidID,$astroidID[$i]);
				array_push($fastestAstroidArray,$kilometers_per_hour[$i]);
				array_push($closestAstroidArray,$kilometers[$i]);
			}
		}

		/**
		* Store Average astroid size into $average_size variable
		* Store fastest astroid into $fastest_astroid variable
		* Store closest astroid into $closest_astroid variable
		*/
		$average_size = min($average_array);
	  $fastest_astroid = max($fastestAstroidArray);
	  $closest_astroid = min($closestAstroidArray);

		/**
		* Respected fasted astroid id into $fast_ast_id  variable
		* Respected closest astroid id into $close_ast_id  variable
		*/
  	$key = array_search($average_size, $average_array);
  	$key1 = array_search($fastest_astroid, $fastestAstroidArray);
  	$key2 = array_search($closest_astroid, $closestAstroidArray);
    $avg_size_id = $resAstroidID[$key];
		$fast_ast_id = $resAstroidID[$key1];
		$close_ast_id = $resAstroidID[$key2];

		/**
		* Return all data to front end
		*/
		echo json_encode(array("code"=>200,"alldates"=>$getAllDates,"astroidcount"=>$astroidCount,"fastest_astroid"=>$fastest_astroid,"fastest_astroid_id"=>$fast_ast_id,"closest_astroid"=>$closest_astroid,"closest_astroid_id"=>$close_ast_id,"average_size"=>$average_size));
	}
	private function AllDates($start, $end)
	{
		$dates = array($start);
		while(end($dates) < $end){
				$dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
		}
		return $dates;
	}
}
