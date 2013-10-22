<?php
	function checkErr($resource)
	{
		global $DB;
		if($resource === FALSE || $DB->Error())
		{
			die("<pre>" . print_r($DB->GetLast(), true) . "</pre>");
		}
	}
	
	function debugvar($var)
	{
		$out = '';
		if(is_array($var))
			$out = print_r($var, true);
		else
			$out = $var;
			
		echo "<pre>$out</pre>";
	}
	
	function debugarr($arr, $ret = false)
	{
		$out = '';
		if(is_array($arr))
			$out = print_r($arr, true);
		else
			$out = $arr;
			
		if($ret) return "<pre>$out</pre>";
		
		echo "<pre>$out</pre>";
	}

	
	function createpasswordhash($user, $raw_pass)
	{
		// this should ONLY be used to create NEW passwords
		$salt = sha1($user . array_sum(explode(' ', microtime())));
		$raw = $salt . sha1(sha1($user) . sha1($salt . $raw_pass));
		
		return $raw;
	}
	
	function checkpassword($user, $pass, $hash)
	{
		$salt = substr($hash, 0, 40);
		$check = $salt . sha1(sha1($user) . sha1($salt . $pass));
		
		if($check == $hash)	return true;
		
		return false;
	}
	
	function validpassword($user, $pass)
	{
		# i dont really use this...basically, it checks for some normal characters
		# and also that the username isnt in the password, or too similar
		$pa = 0;
		
		$matches = array();
		preg_match('/[^a-zA-Z0-9_\.]/', $user, $matches);
		if(isset($matches[0])) return USER_NAME_INVALID;
		
		if(strlen($pass) < 6) return PWD_TOO_SHORT;
		if(strpos($pass, $user)) return PWD_USER_IN_PWD;
		
		similar_text($user, $pass, $pa);
		if($pa >= 40) return PWD_USER_TOO_SIMILAR;
		
		return F_GOOD;
	}
?>