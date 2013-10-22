<?php
	$PAGE->assign('css', $_CSS);
	$PAGE->assign('js', $_JS);
	
	$PAGE->assign('page_title', "$page_title");
	
	if(isset($_template))
		$PAGE->display($_template);
	else {
		$PAGE->display('header.tpl');
		$PAGE->display('footer.tpl');
	}
	
?>
