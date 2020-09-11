<?php

define("FILENAME", "results.txt");

/*
#
#	Differents Datasets for testing
#
#	$array = [ 'oportunidad', 'oregon', 'analfabeto', 'dato',  'analia',  'olla', 'sarro', 'nidos' ];
#	$array = [ 'oportunidad', 'oregon', 'analfabeto',  'analia',  'dato',  'olla', 'sarro', 'nidos' ];
#	$array = [ 'oso', 'perro', 'zapallo', 'oregon', 'nariz', 'ostia', 'ofrenda', 'sandia', 'alamo', 'orrap', 'arbol', 'levas', 'almuerzo' ];
#	$array = [ 'oso', 'almummerzo', 'perro', 'zapallo', 'oregon', 'nariz', 'ostia', 'ofrenda', 'sandia', 'alamo', 'orrap', 'arbol', 'levas', 'almuerzo', 'oso', 'perro', 'zapallo', 'oregon', 'nariz', 'ostia', 'ofrenda', 'sandia', 'alamo', 'orrap', 'arbol', 'levas', 'almuerzo', 'oso', 'perro', 'zapaallo', 'oreegon', 'narriz', 'ostia', 'ofrenda', 'sandia', 'alamo', 'orrap', 'arbol', 'levas', 'almuerzo', 'oso', 'perro', 'zapallo', 'oreegon', 'naariz', 'osssstia', 'offfrenda', 'sannndia', 'allllamo', 'orraaap', 'arrrrbol', 'leeeevas' ];
#	$array = [ 'chair', 'height', 'racket', 'touch', 'tunic' ];
#
*/

$array = [ 'chair', 'height', 'racket', 'touch', 'tunic' ];

/**
 * Verifies and try to make circle with input words
 *
 * @param 	array  List of words to try to make circle 
 * @return 	array  Array with words ordered
 */

function makeCircle(array $list) : array {

	$startsWith = [];
	$endsWith = [];

	if(count($list) < 2)
		throw new Exception('At least two elements are required.');
	
	// Count start and end words to verify if circle is possible
	foreach ($list as $word) 
	{

		$firstWord = $word[0];
		$lastWord = $word[-1];

		$startsWith[$firstWord][] = $word;
		$endsWith[$lastWord][] = $word;
	}

	// Check if circle is possible
	foreach ($startsWith as $key => $value)
	{	
		if(empty($endsWith[$key]) || count($endsWith[$key]) != count($value))
			throw new Exception('Circle not possible.');
	}

	// Make the circle
	$circle = getNext($list, $list[0][0], [], count($list));

	return $circle;
}


/**
 * Create the circle with array of words verified
 *
 * @param 	array    $list     List of words to make circle 
 * @param 	string   $letter   Starting letter of the next word
 * @param 	array    $circle   Array used to put candidate list
 * @param 	integer  $length   Number of words on list
 * @return 	array  Array with words ordered
 */

function getNext(array $list, string $letter, array $circle = [], int $length ) : array {

	if(count($list) == 0)
		return $circle;
	
	foreach($list as $key => $value){

		if(!empty($value) && $letter == $value[0]){
			$circle[] = $value;
			unset($list[$key]);
			$letter =  $value[-1];
			continue;
		}

		if(array_key_last($list) == $key ){
			echo 1;
			$circle = getNext($list, $letter, $circle, $length);
			return $circle;
		}
	}


	if(count($circle) != $length){
		$new = array_merge($circle, $list);
		$element = $new[0];
		unset($new[0]);
		$new[] = $element;
		$new = array_values($new);
		$circle = getNext($new, $new[0][0], [], $length);
	}

	return $circle;
}

/**
 * Save array elements to file
 *
 * @param 	array    $list     List of words
 * @return 	array  Array with words ordered
 */
function arrayToFile(array $array){

	$out = null;

	foreach($array as $value){

		$out .= $value . "\n";
	}

	return file_put_contents(FILENAME, $out);	
}


try{

	$circle = makeCircle($array);

	arrayToFile($circle);

} catch (Exception $e) {

	echo 'Error: ',  $e->getMessage(), "\n";

}
