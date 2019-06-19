<?php

function degreeOfArray($arr) {
    /*

			Degree is # of elements occuring most frequently in arr
			$arr = [1,2,1,3,2]; => degree 2 of main array (prop 1)

			[1,2,1] => shortest sub array (prop 2 is len 3 with degree 2;

			need to find where subarray shares same degree as main array and shortest possible sub array length for highest degree elements
			if two elements share highest degree, then the one with shortes sub array of same degree is the winner

		*/

		//first find most frequent values;
		//returns value and number of occurences
		$counts = array_count_values($arr);

		//sort in order of occurence and maintain indices
		//provides array of occurences
		arsort($counts);

		//get the values to work with - again appear in order of occurence
		//use these values to enter into $counts array as keys
		$values = array_keys($counts);

		//store the keys and the steps
		//[0] magnitude,[1] = sub array steps, [2] = value,
		$main_steps_store = array();

		//loop through main values first in order of magnitude
		for($i=0; $i < sizeof($values);$i++){

			//tracking variables
			//
			$val_exists = false;
			$val_counter = 0;
			$start_key = null;
			$end_key = null;


			//now loop through our main array
			for($x = 0; $x < sizeof($arr); $x++){
				//if the value exists in this element, record it
				if($arr[$x] === $values[$i]){
					//track the number of occurences.
					$val_counter++;

					//if the value hasn't been seen, then set its existence to true
					if(!$val_exists){
						$val_exists = true;
						//key where the starting element resides in main array
						$start_key = $x;

					}
					//if the value has been seen already, then check if the degree of the sub array is the same
					else{
						if($val_counter === $counts[$values[$i]]){
							//key at end of the sub array
							$end_key = $x;
							//calculate sub array length
							$array_length = $end_key - $start_key + 1;

							//push to the storage array
							// 0: magnitutde  1: subarraysteps  2: values
							array_push($main_steps_store,[$counts[$values[$i]],  $array_length , $values[$i]]);
						}
					}

				}
			}

		}//end for

		//now go through the steps array and check for highest order and smallest size array of same order
		//if the array is empty, that means there are only scalars. return only the highest number in the array
		if(sizeof($main_steps_store) === 0){
			return 1;
		}
		else{

			//set tracking vars
			$prev_degree = false;
			$prev_steps = 0;

			// $main_steps_store array:  0 => magnitutde  1 => subarraysteps  2 => value
			for($p=0; $p < sizeof($main_steps_store); $p++){
				//set the tracking degree. If the current degree is false then start work
				if($prev_degree){
					//don't go further than the highest degree
					if($prev_degree > $main_steps_store[$p][0]){
						break;
					}
				}
				else{
					//initial setting of the main degree tracker
					$prev_degree = $main_steps_store[$p][0];
				}

				if($prev_steps != 0){
					//if the previous level of sub degree is greater then replace with the lowest one
					if($prev_steps > $main_steps_store[$p][1]){
						$prev_steps = $main_steps_store[$p][1];
					}
				}
				//set the initial steps
				else{
					$prev_steps = $main_steps_store[$p][1];
				}

			}
		}

		return $prev_steps;
} //end the function





$arr = [3,9,4,9,9];

echo degreeOfArray($arr);

?>
