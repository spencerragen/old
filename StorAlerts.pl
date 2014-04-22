use strict;
use warnings;
use Xchat qw(:all);
register("StorAlerts", "0.1");

Xchat::hook_print('Channel Action Hilight', \&check_hmessage);
Xchat::hook_print('Channel Msg Hilight', \&check_hmessage);
Xchat::hook_print('Channel Message', \&check_message);
Xchat::command("QUERY -nofocus -Walerts");

sub check_hmessage
{
	return print_alert($_[0][0], $_[0][1]);
}

sub check_message
{
	# leave first element alone, add your own names...or others if you want to see who's talking to whom
	my @nick = (Xchat::get_info('nick'), 'tofu');
	foreach my $check (@nick)
	{
		if($_[0][0] =~ /$check/i) { return print_alert($_[0][0], $_[0][1]) } ;
	}
	return Xchat::EAT_NONE;
}

sub print_alert
{
	my $con = Xchat::context_info();
	Xchat::command("QUERY -nofocus -Walerts");
	Xchat::set_context('-Walerts');
	Xchat::printf("%s\t%s: <%s> %s",$con->{network},$con->{channel},$_[0],$_[1]);
	Xchat::set_context(substr $con->{channel}, 1);
	
	return Xchat::EAT_NONE;
}
