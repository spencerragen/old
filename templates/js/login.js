$(document).ready(function()
{
	$('#primary_container').load('templates/login.tpl', function(){$('#primary_container').dialog({closeOnEscape: false,title: 'Log In', modal:true,open: function(event, ui) { $('.ui-dialog-titlebar-close', ui.dialog).hide(); }, draggable: false,resizable: false, width: 270})});
});