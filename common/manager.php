<?php

ignore_user_abort(true);
@set_time_limit(0);

header('Location: http://0.0.0.0:0');
header('Connection: close');
header('Content-Length: '.ob_get_length());
@ob_end_flush();
@ob_flush();
@flush();

// Do duty work here ..
chdir('..');

include 'common/routines.php';

$S['LOg']['timestamp'] = intval($_SERVER['REQUEST_TIME_FLOAT'] * 30000);

define('HTTP_tmp',		'tmp'.DIRECTORY_SEPARATOR);
define('HTTP_tourist_library',		HTTP_tmp.'visit'.DIRECTORY_SEPARATOR);
define('HTTP_page_hits',		HTTP_tmp.'hits'.DIRECTORY_SEPARATOR);

define('HTTP_log',		HTTP_tmp.'log');

// Check earlier resolution
$S['LOg']['evacuate'] = function () {
	global $S;

	if (file_exists(HTTP_log.'_do_confession')) {
		if (file_exists(HTTP_log.'_ticks')) {
			foreach ($S['VAR']['real'](file_get_contents(HTTP_log.'_ticks')) as $page => $hits) {
				$S['LOg']['open_sesami'](HTTP_page_hits.$page);
				foreach ($hits as $where => $A) 
					if (!isset($S['recent'][$where])) $S['recent'][$where] = $A;
					else $S['recent'][$where] += $A;
					
				$S['LOg']['end_sesami']();	// Save visit
			}
			
			unlink(HTTP_log.'_ticks');
		}
		if ($What = file_exists(HTTP_log.'_kills') ? true : null) {
			foreach ($S['VAR']['real'](file_get_contents(HTTP_log.'_kills')) as $kill_it) unlink($kill_it);
		}
		unlink(HTTP_log.'_do_confession');
	} else if (file_exists(HTTP_log.'_bak')) unlink(HTTP_log.'_bak', HTTP_log);
	if (isset($What) || file_exists(HTTP_log.'_kills')) unlink(HTTP_log.'_kills');
};

$S['LOg']['evacuate']();

// Get previos log for reference and guidance
$S['LOg']['logs'] = file_exists(HTTP_log) ? $S['VAR']['real'](file_get_contents(HTTP_log)) : ['where' => []];

$S['kill_me_yet_no_for_allegations_'] = [];
$list_ticks_added = [];

$dir_link = opendir(HTTP_tourist_library);
while($entry = readdir($dir_link)) {
	if ($entry == '.' || $entry == '..') continue;

	// Get previos log for reference and guidance
	$S['lunatree'] = $S['VAR']['real'](file_get_contents(HTTP_tourist_library. $entry));
	if (array_key_last($S['lunatree']['visits']) + 216000000 < $S['LOg']['timestamp']) {
		array_push($S['kill_me_yet_no_for_allegations_'], HTTP_tourist_library. $entry);
		// Remove uniq visits ..
		if (!isset($S['lunatree']['where']) || $_SERVER['HTTP_HOST'] == $S['lunatree']['where']) continue;
		$list_ticks = [];
		foreach ($S['lunatree']['visits'] as $timestamp => $direction)
			if ($direction['tick']) $list_ticks[$direction['concern']] = true;

		foreach ($list_ticks as $concern => $_) {
			if (!isset($list_ticks_added[$concern])) $list_ticks_added[$concern] = [];
			if (!isset($list_ticks_added[$concern][$S['lunatree']['where']])) $list_ticks_added[$concern][$S['lunatree']['where']] = 1;
			else $list_ticks_added[$concern][$S['lunatree']['where']]++;
		}
	}
}

// Save visit
if (0 < count($S['kill_me_yet_no_for_allegations_'])) {
	file_put_contents(HTTP_log.'_ticks', $S['VAR']['pack']($list_ticks_added));
	file_put_contents(HTTP_log.'_kills', $S['VAR']['pack']($S['kill_me_yet_no_for_allegations_']));
	file_put_contents(HTTP_log.'_do_confession', '');

	// Do it
	$S['LOg']['evacuate']();
}

exit;

?>