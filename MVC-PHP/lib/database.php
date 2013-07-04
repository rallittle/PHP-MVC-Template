
<?php
define('DB_NUM', MYSQL_NUM);
define('DB_BOTH', MYSQL_BOTH);
define('DB_ASSOC', MYSQL_ASSOC);

class database {
	var $host = "";
	var $database = "";
	var $user = "";
	var $password = "";
	var $port = "3306";
	var $socket = "";
	var $debug = false;
	var $halt_on_error = "yes";
	var $record = array();
	var $row;
	var $errno = 0;
	var $error = "";
	var $link = false;
	var $result = false;
 	var $suppress_errors=array();
	var $pconnect = false;
	
	public function __construct($config=null)
	{
		$this->set_config($config);
		$this->connect();
	
	}

	public function set_config($config=null)
	{
		global $Config;
		
		if(!isset($config) && isset($Config))
		{
			$config = $Config;
		}
		
				
		if(isset($config))
		{
			if (isset($config->db_host)) {
				$this->host = $config->db_host;
			}
			if (isset($config->db_name)) {
				$this->database = $config->db_name;
			}
			if (isset($config->db_user)) {
				$this->user = $config->db_user;
			}
			if (isset($config->db_pass)) {
				$this->password = $config->db_pass;
			}
			if (isset($config->db_port)) {
				$this->port = $config->db_port;
			}
			if (isset($config->db_socket)) {
				$this->socket = $config->db_socket;
			}
		}
	}

	public function set_parameters($host, $database, $user, $pass, $port=3306, $socket='')
	{
		$this->host = $host;
		$this->database = $database;
		$this->user = $user;
		$this->password = $pass;
		$this->port = $port;
		$this->socket = $socket;
	}

	public function field($name) {
		if (isset($this->record[$name])) {
			return $this->record[$name];
		}
	}

	public function connect() {

		if(!empty($this->socket))
		{
			$host = $this->host.':'.$this->socket;
		}else
		{
			$host = $this->host.':'.$this->port;
		}
				
		if ( 0 == $this->link ) {
			if(!$this->pconnect) {
				$this->link = mysql_connect($host, $this->user, $this->password);
			} else {
				$this->link = mysql_pconnect($host, $this->user, $this->password);
			}
			if (!$this->link) {
				$this->halt('Could not connect to MySQL database');
				return false;
			}
				
			$this->query("SET NAMES UTF8");
				
			if (!empty($this->database) && !@mysql_select_db($this->database,$this->link)) {
				$this->halt("cannot use database ".$this->database);
				return false;
			}
		}

		return $this->link;
	}

	public function free() {
		if(is_object($this->result))
		{
			@mysql_free_result($this->result);
		}
		$this->result = false;
	}
		
	public function queryScalar($sql, $default=''){
	
		$result = $default;
		$this->query($sql);
		if ($this->num_rows() > 0) {
			$record = $this->next_record(MYSQL_NUM);
			$result = $record[0];
		}
		
		return $result;

	}

	public function query($sql, $types='', $params=array())
	{
		if ($sql == ""){return false;}
		
		if (!$this->connect()) {return false; };

		$this->free();
		$this->clear_error();
		
		if(!is_array($params))
		{
			$params=array($params);
		}
				
		$param_count = count($params);
				
		$this->result = @mysql_query($sql,$this->link);

		$this->row   = 0;

		if (!$this->result) {
			$this->halt("Invalid SQL, ".$sql);
		}
		
		return $this->result;
	}

	public function next_record($result_type=DB_ASSOC) {
		if (!$this->result) {
			$this->halt("next_record called with no query pending.");
			return false;
		}

		$this->record = @mysql_fetch_array($this->result, $result_type);
		$this->row   += 1;

		return $this->record;
	}

	public function affected_rows() {
		return @mysql_affected_rows($this->link);
	}
	
	
	public function num_rows() {
		return @mysql_num_rows($this->result);
	}

	public function num_fields() {
		return @mysql_num_fields($this->result);
	}

	protected function set_error()
	{
		$this->error = @mysql_error($this->link);
		$this->errno = @mysql_errno($this->link);
	}

	protected function clear_error()
	{
		$this->error = '';
		$this->errno = '';
	}

	public function insert_id()
	{
		return mysql_insert_id($this->link);
	}

	public function escape($value, $trim=true)
	{
		$this->connect();
		
		if($trim)
			$value = trim($value);
			
		return mysql_real_escape_string($value, $this->link);
	}
	
	public function unescape($value, $trim=true){
		if($trim)
			$value = trim($value);

		$value=str_replace("\\","",str_replace("\$","",$value));
	    return $value;
	}

	protected function halt($msg) {

		$this->set_error();
		echo $this->error;
		die();
	}

	public function close(){
		return mysql_close($this->link);
	}
	
}

?>





