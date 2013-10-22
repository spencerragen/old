{| class="wikitable sortable collapsible collapsed"
!|'''Rank'''
!|'''Player'''
!|'''Points'''
!|'''Wins'''
!|'''Losses'''
!|'''Old Rank'''
<?php
	header('content-type: text/plain; charset=utf-8');
	$raw = file_get_contents("./{$_GET['file']}.txt");
	$sections = explode('</tr>', $raw);

	if($_GET['file'] == 'ru') $file = 'eu'; else $file = $_GET['file'];
	if($file == 'ch') $file = 'www';
	$i = 1;
	foreach($sections as $section)
	{
		$lines = explode("\n", $section);
		
		$profile = "http://$file.battle.net";
		$player = '';
		$race = '';
		$prank = '';
		$stats = array();
		
		foreach($lines as $line)
		{
			if(substr($line, 0, 8) == '<a href=')
			{
				$x = explode('"', $line);
				$profile .= $x[1];
			}
			
			if(substr($line, 0, 12) == 'class="race-') $race = substr($line, 12, 1);
			if(substr($line, 0, 21) == '<strong>Previous Rank' || substr($line, 0, strlen('<strong>이전 순위:</strong> ')) == '<strong>이전 순위:</strong> ' || substr($line, 0, strlen('<strong>上一次排名：</strong> ')) == '<strong>上一次排名：</strong> ' || substr($line, 0, strlen('<strong>前次排名：</strong> ')) == '<strong>前次排名：</strong> ')
				$prank = str_replace(array('<strong>Previous Rank:</strong> ', '<strong>이전 순위:</strong> ', '<strong>前次排名：</strong> ', '<strong>上一次排名：</strong> ', '<br />'), array(null, null, null, null, null), $line);
				
			if(substr($line, 0, 25) == '<td class="align-center">') $stats[] = str_replace(array('<td class="align-center">', '</td>', "\n", "\r", ' '), array(null, null, null, null, null), $line);
			if(substr($line, 0, 27) == '<div class="tooltip-title">') $player = str_replace(array('<div class="tooltip-title">', '</div>', "\n", "\r"), array(null, null, null, null), $line);
		}
		#print "$profile $race {$prank[0]} {$stats[0]} {$stats[1]} {$stats[2]}\n";
		print "|-\n|$i\n|{{playersp|$player|race=$race}} [$profile Profile]\n|{$stats[0]}\n|{$stats[1]}\n|{$stats[2]}\n|$prank\n";
		$i++;
	}
?>

|-
|}