<?php

	ob_start();
	if(!empty($_REQUEST))
	{
		
		$data = explode("\r", $_REQUEST['log']);
		array_map('trim', $data);
		
		foreach($data as &$datum)
		{
			$datum = trim($datum);
			if($datum == 'none') $datum = null;
		}
		
		#print_r($_REQUEST);
		$blarg = array();
		$sell = array('avgprc' => 0, 'min' => 99999999999999999999, 'max' => 0, 'orders' => 0, 'prices' => array());
		$buy = array('avgprc' => 0, 'min' => 99999999999999999999, 'max' => 0, 'orders' => 0, 'prices' => array());
		echo "Type,Price,Start Qty,Current Qty,MinVol,Created,Duration,Range\r\n";
		foreach($data as $datum)
		{
			if(empty($datum) || is_array($datum)) continue;
			$datum = explode(',', $datum);
			if(empty($datum)) continue;
			$c = array();
			$c['price'] = $datum[4];
			$c['orderqty'] = $datum[5];
			$c['remainqty'] = $datum[6];
			if($datum[1] == 's')
			{
				$c['type'] = 'Sell';
				$sell['prices'][] = $c['price'];
				$sell['avgprc'] += $c['price'];
				$sell['orders'] += $c['remainqty'];
				if($c['price'] > $sell['max']) $sell['max'] = $c['price'];
				if($c['price'] < $sell['min']) $sell['min'] = $c['price'];
			} else {
				$c['type'] = 'Buy';
				$buy['prices'][] = $c['price'];
				$buy['avgprc'] += $c['price'];
				$buy['orders'] += $c['remainqty'];
				if($c['price'] > $buy['max']) $buy['max'] = $c['price'];
				if($c['price'] < $buy['min']) $buy['min'] = $c['price'];
			}
			#$c['price'] = number_format($datum[4], 2);
			$c['min_vol'] = $datum[7];
			$c['created'] = $datum[8];
			$c['duration'] = $datum[9];
			$c['range'] = $datum[10];
			$blarg[] = implode(',', $c);
			echo end($blarg)."\r\n";
		}
		
		sort($sell['prices'], SORT_NUMERIC);
		sort($buy['prices'], SORT_NUMERIC);
		$smed = floor(count($sell['prices'])/2);
		$bmed = floor(count($buy['prices'])/2);
		if($smed != 0) $smed = $sell['prices'][$smed];
		if($bmed != 0) $bmed = $buy['prices'][$bmed];
		
		echo "\r\n";
		echo "Sell Orders,{$sell['orders']}\r\n";
		echo "Sell Avg Price,{$sell['avgprc']}\r\n";
		echo "Sell Min Price,{$sell['min']}\r\n";
		echo "Sell Max Price,{$sell['max']}\r\n";
		echo "Sell Median Price,$smed\r\n";
		echo "\r\n";
		echo "Buy Orders,{$buy['orders']}\r\n";
		echo "Buy Avg Price,{$buy['avgprc']}\r\n";
		echo "Buy Min Price,{$buy['min']}\r\n";
		echo "Buy Max Price,{$buy['max']}\r\n";
		echo "Sell Median Price,$bmed\r\n";
		
		$data = $blarg;
		
		#print_r($data);
			
		$data = ob_get_contents();
		
		$h = fopen($_REQUEST['type_id'] . '.' . time() . '.csv', 'w+');
		fputs($h, $data);
		fclose($h);
	}
	ob_end_clean();
	
?>
