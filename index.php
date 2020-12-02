<?php

session_start();

include 'common/routines.php';

// **************************************  LOG page visit

define('HTTP_tmp',		'tmp'.DIRECTORY_SEPARATOR);
if (!file_exists(HTTP_tmp)) { mkdir(HTTP_tmp, 0777, true); }
define('HTTP_tourist_library',		HTTP_tmp.'visit'.DIRECTORY_SEPARATOR);
if (!file_exists(HTTP_tourist_library)) { mkdir(HTTP_tourist_library, 0777, true); }
define('HTTP_page_hits',		HTTP_tmp.'hits'.DIRECTORY_SEPARATOR);
if (!file_exists(HTTP_page_hits)) { mkdir(HTTP_page_hits, 0777, true); }

// Register visit
$TICK = isset($_GET['t']) && isset($_GET['z']) ? ['visit_nb' => $_GET['t'], 'timestamp' => $_GET['z']] : null;

if ($TICK === null) {
	// Log info: time, tick ..
	$S['LOg']['timestamp'] = intval($_SERVER['REQUEST_TIME_FLOAT'] * 30000);
	// Page
	$S['LOg']['concern'] = isset($_GET['p']) ? $_GET['p'] : 'main';
}

/*	Anonymity is security in need of comfort from killing people with teeth screwed on to do it - lions' prey - and spasm to orgasm muscle power in our brains force it with megalomaniac questions like "who won the war of killing?" - cat & mouse or cat & dog, negro bullshit against white male and for what, persecution and execution of punishment causing harm ..? Do no evil as they say, but can not be heard as they make it across the city at night .. bla bla, playsickness is f* retarded. */
$max = strlen($_SERVER['REMOTE_ADDR']); // <-- no no don't touch, though I allow it if you must .. necessarily venture in offence to those who do you harm.
$S['LOg']['tourist_nr'] = 0;
for ($i = 0; $i < $max; $i++) $S['LOg']['tourist_nr'] += $i ^ ord($_SERVER['REMOTE_ADDR'][$i]);

// Specify log location
if ($TICK !== null) {	// Ticker ..
	$S['LOg']['open_sesami'](HTTP_tourist_library.$S['LOg']['tourist_nr'].'.'.$TICK['visit_nb']);
	$S['recent']['visits'][$TICK['timestamp']]['tick'] = true;
} else {
	if (isset($_SESSION['tick']) && file_exists(HTTP_tourist_library.$S['LOg']['tourist_nr'].'.'.$_SESSION['tick'])) {
		$S['LOg']['open_sesami'](HTTP_tourist_library.$S['LOg']['tourist_nr'].'.'.$_SESSION['tick']);

		if (array_key_last($S['recent']['visits']) + 216000000 <= $S['LOg']['timestamp']) {
			if ($S['LOg']['log_link_is_locked']) flock($log_link, LOCK_UN);    // release the lock
			fclose($S['LOg']['log_link']);
		} else $S['LOg']['visit_nb'] = $_SESSION['tick'];
	}

	if (!isset($S['LOg']['visit_nb'])) {
		// Iterated number - new client
		define('HTTP_visit_i',					HTTP_tmp.'visit_number.db');
		if (!file_exists(HTTP_visit_i)) $S['LOg']['visit_nb'] = 0;
		else $S['LOg']['visit_nb'] = file_get_contents(HTTP_visit_i);
		
		$S['LOg']['visit_nb'] += rand(1, 64);
		if ($S['LOg']['visit_nb'] >= 16777216) $S['LOg']['visit_nb'] -= 16777216;
		file_put_contents(HTTP_visit_i, $S['LOg']['visit_nb']);

		$S['LOg']['open_sesami'](HTTP_tourist_library.$S['LOg']['tourist_nr'].'.'.$S['LOg']['visit_nb']);
		$S['recent'] = ['visits' => []];
		
		if (!isset($S['recent']['where']) && isset($_SERVER['HTTP_REFERER']) && $HTTP_REFERER = parse_url($_SERVER['HTTP_REFERER'])) $S['recent']['where'] = $HTTP_REFERER['host'];
	}
	
	// Insert time, page etc to log
	$S['recent']['visits'][$S['LOg']['timestamp']] = ['concern' => $S['LOg']['concern'], 'tick' => false];
	
	$_SESSION['tick'] = $S['LOg']['visit_nb'];
}

$S['LOg']['end_sesami']();	// Save visit

if ($TICK === null) {
	// Not before until the second is out on turn
	define('HTTP_task_schedule_db',		HTTP_tmp.'task_schedule.db');
	define('TIME_to_rise', !file_exists(HTTP_task_schedule_db) || $S['LOg']['timestamp'] >= ($HUSK = $S['VAR']['real'](file_get_contents(HTTP_task_schedule_db))) + 27000000);
	
	// New management
	if (TIME_to_rise) {
		$S['LOg']['open_sesami'](HTTP_task_schedule_db);
		if ($S['recent'] != $HUSK) fclose($S['LOg']['log_link']);
		else {
			$S['recent'] = $S['LOg']['timestamp'];
			$S['LOg']['end_sesami']();	// Save visit

			// Awake manager
			@file_get_contents('http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']). '/common/manager.php');
		}
	}
}
// **************************************  END of LOG page visit

// That was only a tick ..
if ($TICK !== null) exit;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="icon" href="favicon.ico?" type="image/x-icon">
<title>Github's FlatFile CMS for Beginner - change title to make it yours for ever ..</title>
<style>
  a:link { color: #666537; }	/* unvisited link */
  a:visited { color: #666537; }	/* visited link */
  a:hover { color: #8ebf42; }	 /* mouse over link */
  a:active { color: #A7A7A7; }	 /* selected link */
</style>
<script>
<?php
// Insert ticker
	echo
		'$ = {};'.
		'$.TC_common = {};'.
		'$.TC_common.countdown = 60;'.
		'$.TC_common.counter = () => {'.
			'if (document.hasFocus()) $.TC_common.countdown--;'.
			'if ($.TC_common.countdown > 0) setTimeout(() => { $.TC_common.counter(); }, 1000);'.
			'else { fetch("index.php?t='.$S['LOg']['visit_nb'].'&z='.$S['LOg']['timestamp'].'").then(response => response.text()).then(gossib => {}).catch(Melchiors => alert(Melchiors)); }'.
		'};'.
		'$.TC_common.counter();'.
	'';
?>
</script>
</head>

<body style="background: black; color: beige;">
	<h1>Put your site logo, slogan whatever with image or text here .. in "index.php" file.</h1>
	
	<table style="display: block; margin: 0 auto; max-width: 800px;" >
	<tr style=" vertical-align: top;">
		<td style="width: 100%; padding: 5px;">
			<table style="border-radius: 12px; background: #AEBC91; color: black; font-family: Comic Sans MS; font-size: 20px;">
			<tr>
				<td style="padding-left: 5px; padding-right: 5px;">
				Hallo ¤%#¤ > Change <b>site</b> <i>theme</i> surrounding thy article (below .. for Beginner) in "index.php" file
<?php include 'page'.DIRECTORY_SEPARATOR.$S['LOg']['concern']. '.txt'; ?>
				</td>
			</tr>
			</table>
		</td>
		<td style="min-width: 150px; max-width: 150px; padding: 5px;">
			<table style="border-radius: 12px; background: #2B0000; color: #666537; font-family: Georgia; font-size: 20px; width: 100%;">
			<tr>
				<td>
				  <ul style="display: block; margin-left: -15px;">
					  <li><a title="main" href="index.php" target="_self">Index</a></li>
<?php
		$dir_link = opendir('page');
		while($entry = readdir($dir_link)) {
			if ($entry == '.' || $entry == '..' || $entry == 'main.txt') continue;
			$entry_trimmed = basename($entry, '.txt');
			echo '<li><a title="'.$entry_trimmed.'" href="?p='.$entry_trimmed.'">'.(strlen($entry_trimmed) > 8 ? substr($entry_trimmed, 0, 6). ' ..' : $entry_trimmed).'</a></li>';
		}
?>
				  </ul>
				</td>
			</tr>
<?php
			if ($S['LOg']['PAGE_hits'] = @file_get_contents(HTTP_page_hits.$S['LOg']['concern'])) {
				$S['LOg']['PAGE_hits'] = $S['VAR']['real']($S['LOg']['PAGE_hits']);
				$S['LOg']['PAGE_hits_Echo'] = '<tr><td><hr>';
				foreach ($S['LOg']['PAGE_hits'] as $where => $hits)
					$S['LOg']['PAGE_hits_Echo'] .= '<div><span title="'.$hits.' visitors refered from '.$where.'">'.htmlentities(strlen($where) > 12 ? substr($where, 0, 10). ' ..' : $where).'</span> : '.$hits.'</div>';
				echo $S['LOg']['PAGE_hits_Echo'] . '</td></tr>';
			}
?>
			</table>
		</td>
	</tr>
	</table>
</body>
</html>
