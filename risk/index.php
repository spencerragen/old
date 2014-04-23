<?php
	require_once('db.php');
	
	$t = sidb::getRows("select b.`name` empire, a.`name`, a.`color` from `territories` a left join `empires` b on a.`empire` = b.`id` order by a.`empire`, a.`name`, b.`independent` asc");
	$max = sidb::getSingleResult("select count(*), empire from territories group by empire order by count(*) desc limit 1");
	$e = array();
	foreach($t as $row) {
		if(!isset($e[$row['empire']])) {
			$e[$row['empire']] = array();
		}
		$e[$row['empire']][] = array('name'=>$row['name'], 'color'=>$row['color']);
	}
	
	#$rows = array();
	$keys = array_keys($e);
	$rows = array_fill(0, $max, array_fill(0, 9, array('name'=>'&nbsp;','color'=>'ffffff')));
	foreach($e as $empire => $turf) {
		$col = array_search($empire, $keys);
		foreach($turf as $index => $name) {
			$rows[$index][$col] = $name;
			#$rows[$index][$col]['color'] = $name['color'];
		}
	}
	
	#var_dump($rows);
	#var_dump($e);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>CR Distrubutizerator</title>
		<meta http-equiv="Content-Language" content="en-us" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="ui-darkness/jquery-ui-1.10.3.custom.css" type="text/css" />
		<script src="jquery-2.0.3.min.js" type="text/javascript"></script>
		<script src="jquery-ui-1.10.3.min.js" type="text/javascript"></script>
	</head>
	<body>
		<h2>Native</h2>
		<table border="1" cellspacing="0" cellpadding="4">
			<tr>
<?php foreach($keys as $key):  ?>
				<th><? echo $key; ?></th>
<?php endforeach; ?>
			</tr>
<?php foreach($rows as $row): ?>
			<tr>
<?php foreach($row as $col): ?>
				<td style="background-color: #<?php echo $col['color']; ?>"><?php echo $col['name']; ?></td>
<?php endforeach; ?>
			</tr>
<?php endforeach; ?>
		</table>

		<!--fieldset id="p" style="margin: 10px;">
			<legend>Number of Neutrals</legend>
			<input type="radio" name="neutrals" value="0" checked /> 0 - 
			<input type="radio" name="neutrals" value="1" /> 1 - 
			<input type="radio" name="neutrals" value="2" /> 2 - 
			<input type="radio" name="neutrals" value="3" /> 3
		</fieldset-->

		<h2>Distributed</h2>
		<form method="get" action="index.php" id="capitols">
			<!--# Neutrals: <input type="text" id="neutrals" name="neutrals" style="width: 20px;" placeholder="0" /><br />-->
			Capitol: <input type="text" class="capitol" name="cap[]" placeholder="Capitol" /><br />
			Capitol: <input type="text" class="capitol" name="cap[]" placeholder="Capitol" /><br />
			Capitol: <input type="text" class="capitol" name="cap[]" placeholder="Capitol" /><br />
			Capitol: <input type="text" class="capitol" name="cap[]" placeholder="Capitol" /><br />
			Capitol: <input type="text" class="capitol" name="cap[]" placeholder="Capitol" /><br />
			Capitol: <input type="text" class="capitol" name="cap[]" placeholder="Capitol" /><br />
			<input type="button" id="randomize" value="randomize" />
			<table border="1" cellspacing="0" cellpadding="4" id="turf">
				<tbody>
				</tbody>
			</table>
		</form>
		<div id="assigned">
		</div>
		<script type="text/javascript">
			function setac() {
				$('.capitol').autocomplete({
					source: "search.php",
					minLength: 2,
					select: function( event, ui ) {
						console.log( ui.item ?
						"Selected: " + ui.item.value + " aka " + ui.item.id :
						"Nothing selected, input was " + this.value );
					}
				});
			}
			$('#randomize').on('click', function(){
				/*var p = $('#neutrals').val();
				if(p == '') {
					p = 0;
				}*/
				var p = 0;
				$('#turf tbody').load('distribute.php?n=' + p + '&' + $('form').serialize());
			});
			/*$('#players').on('click', function(){
				var p = $('#p input[name=players]:checked').val();
				var header = '<th><input type="text" class="capitol" name="cap[]" placeholder="Capitol" /></th>';
				var entered = [];
				$('input[name="cap[]"]').each(function(){
					entered.push($(this).val());
				});
				$('#empires').html('');
				for(var i = 0; i < p; i++) {
					$('#empires').append(header);
					$('input[name="cap[]"]').eq(i).val(entered.shift());
				}
				setac();
			});*/
			setac();
		</script>
	</body>
</html>
