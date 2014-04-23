<?php
	require_once('db.php');

	function getmax($empire) {
		$max = 0;
		foreach($empire as $emp) {
			if(count($emp) > $max) {
				$max = count($emp);
			}
		}
		return $max;
	}
	
	function normalize(&$empire, &$unocc, $max) {
		if(count($empire) < $max) {
			$tmp = array_pop($unocc);
			$empire[] = $tmp;
			return normalize($empire, $unocc, $max);
		}
	}
	
	function fill(&$empire, $max) {
		if(count($empire) < $max) {
			$empire[] = array('name' => '&nbsp;', 'color' => 'ffffff');
			return fill($empire, $max);
		}
	}

	$rand = sidb::getRows("SELECT name FROM territories ORDER BY RAND()");
	
	$cap = $_REQUEST['cap'];
	$cap = array_filter($cap, function($var){return !empty($var);});
	$n = count($cap);
	if($n < 5) {
		$n = 5;
	}
	
	$e = array_fill(1, $n, array());
	$occ = array();
	
	foreach($cap as $c) {
		$tmp = sidb::getFirstRow("SELECT `empire`, `color` FROM `territories` WHERE `name` = '{$c}'");
		$capitol = array('name' => $c, 'color' => $tmp['color']);
		$occ[] = $capitol;
		
		$empire = $tmp['empire'];
		$count = sidb::getSingleResult("SELECT COUNT(*) FROM `territories` WHERE `empire` = $empire");
		$mod = $count - 3;
		$def = sidb::getRows("SELECT * FROM (SELECT `name`, `color` FROM `territories` WHERE `empire` = $empire AND `name` != '{$c}' ORDER BY RAND() LIMIT $mod) c ORDER BY `name` ASC");
		$e[$empire][] = $capitol;
		foreach($def as $d) {
			$e[$empire][] = $d;
			$occ[] = $d;
		}
	}
	
	$e = array_filter($e);
	$cm = 5 - count($e);
	for($i = 0; $i < $cm; $i++) {
		$e[] = array();
	}
	
	$max = getmax($e);
	$occupied = array();
	foreach($occ as $o) {
		$occupied[] = $o['name'];
	}
	$occupied = "'" . implode("', '", $occupied) . "'";
	$unocc = sidb::getRows("SELECT `name`, `color` FROM `territories` WHERE `name` NOT IN ($occupied) ORDER BY RAND()");
	foreach($e as &$emp) {
		normalize($emp, $unocc, $max);
	}
		unset($emp);
	
	while(!empty($unocc)) {
		foreach($e as &$emp) {
			$tmp = array_pop($unocc);
			if($tmp === null) {
				break;
			}
			$emp[] = $tmp;
		}
		unset($emp);
	}
	
	$max = getmax($e);
	foreach($e as &$emp) {
		fill($emp, $max);
	}
		unset($emp);
	
	/**/
	for($i = 0; $i < $max; $i++) {
		echo '<tr>';
		foreach($e as $emp) {
			echo "<td style=\"background-color: #{$emp[$i]['color']}\">{$emp[$i]['name']}</td>";
		}
		echo "</tr>\n";
	}
	/**/
?>
