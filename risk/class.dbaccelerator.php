<?php
	class sidb {
		public static $link;
		/**
		* @static connect to the database
		* @param $host
		* @param $user
		* @param $pass
		* @param $db
		*/
		static function connect($host, $user, $pass, $db) {
			self::$link = mysqli_connect($host, $user, $pass, $db);
			
			if(self::$link->connect_error) {
				$err = 'Connection error (' . self::$link->connect_errno. ') ' . self::$link->connect_error;
				if(defined('DB_DIE_ON_ERROR'))
					die($err);
				else
					return $err;
			}
			
			return false;
		}
		
		/**
		* close DB connection safely
		*/
		static function end() {
			if(!(self::$link instanceof mysqli)) {
				if(defined('DB_DIE_ON_ERROR')) {
					die('Error: link not established');
				} else {
					return 'Error: link not established';
				}
			}
			
			return mysqli_close(self::$link);
		}
		
		/**
		* look for errors from last interaction
		*/
		static function errcheck() {
			$err = mysqli_error(self::$link);
			if(!$err) return false;
			
			if(defined('DB_PRINT_ERROR')) {
				debug_print_backtrace();
				echo mysqli_error(self::$link);
			}
			
			if(defined('DB_DIE_ON_ERROR'))
				die($err);
			else
				return $err;
		}
		
		/**
		* Get first result from query
		*
		* @param string $query
		* @return string
		*/
		static function getSingleResult($query) {
			$res = mysqli_query(self::$link, $query);
			if($ec = self::errcheck()) return $ec;
			
			if(self::numrows($res)) {
				$res->data_seek(0);
				$r = $res->fetch_array();
				#var_dump($r);
				return $r[0];
			}
			return 0;
		}
		
		/**
		* retrieve last insert id
		*/
		static function lastid() {
			return mysqli_insert_id(self::$link);
		}
		
		/**
		* retrieve number of rows
		*/
		static function numrows($res) {
			return mysqli_num_rows($res);
		}
		
		/**
		* execute a stored procedure
		*/
		static function procedure($proc, $params) {
			$vars = implode(', ', $params);
			$q = "CALL $proc($vars);";
			$c = mysqli_query(self::$link, $q);
			return $c === false ? self::errcheck() : $c;
		}
		
		static function query($query) {
			$res = mysqli_query(self::$link, $query);
			if($ec = self::errcheck()) {
				return $ec;
			}
			return $res;
		}
		
		static function getFirstRow($query, $res = null, $assoc = true) {
			if($res === null) {
				$res = mysqli_query(self::$link, $query);
				if($ec = self::errcheck()) {
					return $ec;
				}
			}
			
			if(self::numrows($res)) {
				if($assoc) {
					$row = mysqli_fetch_assoc($res);
				} else {
					$row = mysqli_fetch_array($res);
				}
				return $row;
			}
		}
		
		static function getRows($query, $rows = 0, $start = 0, $res = null) {
			if($res === null) {
				$res = mysqli_query(self::$link, $query);
				if($ec = self::errcheck()) {
					return $ec;
				}
			}
			
			if(self::numrows($res)) {
				$return = array();
				while($row = mysqli_fetch_assoc($res)) {
					$return[] = $row;
					if($rows > 0 && count($return) >= $rows + $start) {
						break;
					}
				}
				
				if($start > 0) {
					$return = array_slice($return, $start, $rows);
				}
				
				return $return;
			}
		}
		
		/**
		* Escape string for query
		*
		* @param string $string
		* @return string
		*/
		static function escape($string) {
			return mysql_real_escape_string(stripslashes($string));
		}
		
		static function escapeAndQuote($string) {
			return "'" . mysql_real_escape_string(stripslashes($string)) . "'";
		}
		
		/**
		* Construct an insert statement
		* 
		* @param string $table
		* @param array $params
		* @param bool $duplicate
		* @return string
		*/
		static function get_insert($table, $params, $duplicate = false) {
			$q = 'insert into ' . $table . ' set ';
			$pp = array();
			foreach ($params as $k=>$v) {
				if(!is_null($v)) {
					$pp[] = "$k = $v";
				}
			}
			
			$q .= implode(", ", $pp);
			if($duplicate) {
				$q .= ' on duplicate key update ' . implode(', ', $pp);
			}
			return $q;
		}
		
		/**
		* Construct insert query and execute
		* 
		* @param string $table
		* @param array $params
		* @param bool $duplicate
		* @return variable
		*/
		static function insert($table, $params, $duplicate = false) {
			mysqli_query(self::$link, sidb::get_insert($table, $params, $duplicate));
			return self::lastid();
		}
		
		/**
		* Construct an update statement
		* 
		* @param string $table
		* @param array $params
		* @param string $where
		* @return string
		*/
		static function get_update($table, $params, $where = "") {
			$q = 'update ' . $table . ' set ';
			$pp = array();
			foreach ($params as $k => $v) {
				$pp[] = "$k = $v";
			}
			$q .= implode(", ", $pp);
			if($where != "") {
				$q .= " where $where";
			}
			return $q;
		}
		
		/**
		* Construct update query and execute
		* 
		* @param string $table
		* @param array $params
		* @param string $where
		* @return variable
		*/
		static function update($table, $params, $where = "") {
			return mysqli_query(self::$link, self::get_update($table, $params, $where));
		}
		
		static function getAsArray($query, $singular = false) {
			global $sivig;
			$q = mysqli_query(self::$link, $query);
			
			$results = array();
			
			while($row = mysqli_fetch_assoc($q)) {
				$results[] = $row;
			}
			
			if($singular) {
				return $results[0];
			} else {
				return $results;
			}
		}
		
		static function getMultipleResults($query) {
			$q = mysqli_query(self::$link, $query);
			$results = array();
			while($row = mysqli_fetch_row(self::$link, $q)) {
				$results[] = $row[0];
			}
			return $results;
		}
		
		static function getAsIndexedArray($query, $index='id') {
			$q = mysql_query($query);
			$results = array();
			while($row = mysql_fetch_assoc($q)) {
				$results[] = $row;
			}
			return sidb::arrayIndex($results, $index);
		}
		
		static function arrayIndex($array, $index='id') {
			$return = array();
			foreach ($array as $value) {
				$indexid = $value[$index];
				unset($value[$index]);
				$return[$indexid] = implode('', $value);
			}
			return $return;
		}
		
		static function getGenerator($name) {
			return self::lastid();
			/* this is a terrible way of doing things 
			$iid=sidb::insert('dp_generator_' . $name, array('id'=>'NULL'));
			mysql_query('delete from dp_generator_' . $name);
			return $iid;
			*/
		}
		
		static function table_check($table) {
			$struct = mysqli_query(self::$link, "DESCRIBE $table");
			if(mysqli_error(self::$link)) {
				return false;
			} else {
				if($struct === false) {
					return false;
				}
				$results = array();
				$tmp = array();
				
				while($row = mysqli_fetch_assoc($struct)) {
					$tmp[] = $row;
				}
				
				$results['struct'] = $tmp;
				$tmp = array();
				$index = mysqli_query(self::$link, "SHOW INDEX FROM $table");
				
				while($row = mysqli_fetch_assoc($index)) {
					$tmp[] = $row;
				}
				$results['index'] = $tmp;
				
				return $results;
			}
		}
	}
?>
