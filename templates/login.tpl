
		<form action="process-login.php" method="post">
			<table border="0" cellspacing="0" style="width: 250px; font-size: 10pt" cellpadding="0">
				<tr>
					<td>
						<p><label>User ID:</label></p>
					</td>
					<td>
						<input name="userid" id="userid" type="text" style="width: 120px;" />
					</td>
				</tr>
				<tr>
					<td>
						<p><label>Password:</label></p>
					</td>
					<td>
						<input name="userpassword" type="password" style="width: 120px;" />
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">
						<input type="submit" name="login" value="Log In" style="width: 120px" />
					</td>
					<td style="text-align: center;">
						<input type="button" id="regbtn" style="width: 120px" value="Register" />
					</td>
				</tr>
			</table>
		</form>
		<script>
			$('#regbtn').click(function(){$('#ctr1').load('templates/register.tpl', function(){$('#ctr1').dialog({closeOnEscape: false,title: 'Register', modal:true,open: function(event, ui) { $('.ui-dialog-titlebar-close', ui.dialog).hide(); }, draggable: false,resizable: false, width: $(window).width()*.5, height:$(window).height()*.5, position:'center'})});});
			
		</script>