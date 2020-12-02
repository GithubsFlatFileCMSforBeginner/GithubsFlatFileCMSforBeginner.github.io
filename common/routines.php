<?php

$S = [];	// Define hierarki sun

$S['VAR'] = [];
$S['LOg'] = [];

// Posted javascript typedarray comes in binary string
$S['VAR']['binstr_to_chop'] = function (&$bin_str) {
	global $S;
	$num_len = ord($bin_str[0]);
	$str_length = intval(substr($bin_str, 1, $num_len));
	$str = $S['VAR']['real'](substr($bin_str, 1 + $num_len, $str_length));
	$bin_str = substr($bin_str, 1 + $num_len + $str_length);
return $str;
};

// returns a data with described length
$S['VAR']['data_to_binstr'] = function ($data) {
	global $S;
	$data = $S['VAR']['pack']($data);
	$data_len = (string) strlen($data);
return chr(strlen($data_len)).$data_len.$data;
};

// Convert variable to string
$S['VAR']['pack'] = function ($record) {
	global $S;
	if ($record === null) {
	return chr(0);			// 0 = null, 
	} else if (gettype($record) === 'integer' || gettype($record) === 'double') {
	return chr(1). (string)$record;			// 1 = number
	} else if (gettype($record) === 'string') {
	return chr(2). $record;	// 2 = string
	} else if (gettype($record) === 'boolean') {
	return chr(3). chr($record ? 1 : 0);	// 3 = boolean, 
	} else if (gettype($record) === 'object') 			// 4 = object
		goto VAR_pack_object;
	else if (gettype($record) === 'array') {			// 5 = array
		// Check for object
		$i = 0;
		foreach ($record as $index => $value) if ($index !== $i++) goto VAR_pack_object;
		$register = chr(5);	// 5 = array,
		foreach ($record as $value) $register .= $S['VAR']['data_to_binstr']($value);
	return $register;
	VAR_pack_object:
		$register = chr(4);	// 4 = object,
		foreach ($record as $index => $value) {
			$register .= $S['VAR']['data_to_binstr']($index);
			$register .= $S['VAR']['data_to_binstr']($value);
		}
	return $register;
	} 
return chr(0);		// Ignore other types ..: symbol, undefined, function
};

// Realize variable in string
$S['VAR']['real'] = function ($archive) {
	global $S;
	if (ord($archive) === 0x00) {			// 0 = null,
	return null;
	} else if (ord($archive) === 0x01) {	// 1 = number,
	return intval(substr($archive, 1));
	} else if (ord($archive) === 0x02) {	// 2 = string, 
	return substr($archive, 1);
	} else if (ord($archive) === 0x03) {	// 3 = boolean, 
	return ord($archive[1]) == 1;
	} else if (ord($archive) === 0x04) {	// 4 = object
		$object = [];
		$archive = substr($archive, 1);
		while ($archive != '') {
			$index = $S['VAR']['binstr_to_chop']($archive);
			$story = $S['VAR']['binstr_to_chop']($archive);	// Get content
			$object[$index] = $story;		// Store property
		}
	return $object;
	} else if (ord($archive) === 0x05) {	// 5 = array
		$array = [];
		$archive = substr($archive, 1);
		while ($archive != '') array_push($array, $S['VAR']['binstr_to_chop']($archive));	// Get content and stable it
	return $array;
	}
return ''; // empty
};

// File explorer
$S['LOg']['open_sesami'] = function ($filepath) {
	global $S;

	$S['LOg']['log_link'] = fopen($filepath, 'c+b');
	$S['LOg']['log_link_is_locked'] = flock($S['LOg']['log_link'], LOCK_EX);   // acquire an exclusive lock

	// Get client presence for ass study
	$income = @fread($S['LOg']['log_link'], filesize($filepath));
	$S['recent'] = $income ? $S['VAR']['real']($income) : [];
};


// Save visit
$S['LOg']['end_sesami'] = function () {
	global $S;

	fseek($S['LOg']['log_link'], 0, SEEK_SET);
	fwrite($S['LOg']['log_link'], $S['VAR']['pack']($S['recent']));
	fflush($S['LOg']['log_link']);
	ftruncate($S['LOg']['log_link'], ftell($S['LOg']['log_link']));
	if ($S['LOg']['log_link_is_locked']) flock($S['LOg']['log_link'], LOCK_UN);    // release the lock
	fclose($S['LOg']['log_link']);
};

?>