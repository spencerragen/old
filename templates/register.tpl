<form method="none" action="#">
	<div style="width: 90%; text-align: center;">
		<div class="reg_line"><div class="reg_text">Username</div><div class="reg_input"><input id="new_id" type="text" style="width: 240px;" /></div></div>
		<div class="reg_line"><div class="reg_text">Password</div><div class="reg_input"><input id="new_pwd" type="password" style="width: 240px;" /></div></div>
		<div class="reg_line"><div class="reg_text">Confirm</div><div class="reg_input"><input id="new_pwd_chk" type="password" style="width: 240px;" /></div></div>
	</div>
</form>
<div style="position: absolute;left:30px;bottom:30px;">
<input type="button" width="20px;" id="refresh" />
</div>
<script>
	$('#refresh').click(function(){$('#ctr1').load('templates/register.tpl', function(){$('#ctr1').dialog({closeOnEscape: false,title: 'Register', modal:true,open: function(event, ui) { $('.ui-dialog-titlebar-close', ui.dialog).hide(); }, draggable: false,resizable: false, width: $(window).width()*.5, height:$(window).height()*.5, position:'center'})});});
</script>