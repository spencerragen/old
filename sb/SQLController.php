<?php
	class SQLController
	{
		var $link;
		var $last = array('query' => '', 'file' => '', 'line' => 0, 'error' => '', 'errno' => 0);
		var $error = false;
		
		function SQLController($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME)
		{
			$this->link = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
			if($this->link === FALSE)
			{
				$this->last = array(
										'query' => 'mysql_connect()',
										'file' => __FILE__,
										'line' => __LINE__,
										'error' => mysql_error(),
										'errno' => mysql_errno()
									);
				$this->error = true;
				return $this->last;
			}
			
			$sel = mysql_select_db($DB_NAME, $this->link);
			if($sel === FALSE)
			{
				self::SetError(__FILE__, __LINE__, 'mysql_select_db()');
				return $this->last;
			}
			$this->error = false;
		}
		
		function __destruct()
		{
			self::Complete();
		}
		
		function __wakeup()
		{
			self::SQLController();
		}
		
		function Complete()
		{
			@mysql_close($this->link);
			$this->link = null;
			$this->last = null;
		}
		
		function GetLink()
		{
			return $this->link;
		}
		
		function SetError($file, $line, $routine = '')
		{
			$this->last = array('query' => $routine, 'file' => $file, 'line' => $line,
										'error' => mysql_error($this->link),
										'errno' => mysql_errno($this->link)
									);
			$this->error = true;
		}
		
		function Error()
		{
			return $this->error;
		}
		
		function Clear()
		{
			$this->error = false;
			$this->last = array('query' => '', 'file' => '', 'line' => 0, 'error' => '', 'errno' => 0);
		}
		
		function GetLast()
		{
			return $this->last;
		}
		
		function Clean($text)
		{
			$text = mysql_real_escape_string($text);
			return $text;
		}
		
		function Query($query, $file, $line)
		{
			# right now its just a wrapper function, will add checks later
			
			$result = mysql_query($query, $this->link) or die(mysql_error());
			if($result === FALSE)
				self::SetError($file, $line, $query);
				
			return $result;
		}
		
		function Fetch($resource, $type = MYSQL_ASSOC)
		{
			if($resource === FALSE || $resource === TRUE)
				return $resource;
			else
				return mysql_fetch_array($resource, $type);
		}
		
		function Free($resource)
		{
			mysql_free_result($resource);
		}
	}
?>
