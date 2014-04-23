<?php
	require_once('db.php');
	
	$t = array();
	$t = sidb::getRows("SELECT * FROM `territories` WHERE `name` LIKE '{$_REQUEST['term']}%'");
	$e = sidb::getFirstRow("SELECT * FROM `empires` WHERE `name` LIKE '{$_REQUEST['term']}%' OR `alternate` LIKE '%{$_REQUEST['term']}%' LIMIT 1");
	if(!empty($t)) {
		if(count($t) == 1) {
			$f = reset($t);
			$x = sidb::getRows("SELECT * FROM `territories` WHERE `empire` = {$f['empire']} AND `name` != '{$f['name']}'");
			$t = array_merge($t, $x);
		}
	}
	if(!empty($e)) {
		$x = sidb::getRows("SELECT * FROM `territories` WHERE `empire` = {$e['id']}");
		if($t === null) {
			$t = array();
		}
		if($x === null) {
			$x = array();
		}
		$t = array_merge($t, $x);
	}
	if(empty($t) && empty($x)) {
		exit();
	}
	

	$j = array();
	foreach($t as $p) {
		$j[] = $p['name'];
	}
	
	echo json_encode($j);
?>