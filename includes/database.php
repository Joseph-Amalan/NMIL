<?php
class DB
{
    protected $connection;
    protected $host;
    protected $database;
    protected $user;
    protected $password;
	protected $result;
	protected $index;
	protected $row;
	protected $numrows;
	protected $numfields;
	protected $rowsaffected;
	protected $stmt;
	
	/*protected $autocomit;*/	

    function __construct($host="",$database="",$user="",$password="")
    {
    	$this->Connect($host, $database, $user, $password);
    }

    function Connect($host="",$database="",$user="",$password="")
    {
        global $DBHOST,$DBNAME,$DBUSER,$DBPASSWORD;
		
		if($host=="" || $database=="" || $user=="" || $password=="")
		{
			$host=$DBHOST;
			$database=$DBNAME;
			$user=$DBUSER;
			$password=$DBPASSWORD;
		}
		$this->connection = new PDO('mysql:host='.$host.';dbname='.$database, $user, $password);

		if (!$this->connection) {
			$this->ShowError();die;
		}
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
		$this->SetNull();
    }

    function Close()
    {
        if (isset($this->connection))
        {
            //$this->connection->close();
			$this->SetNull();
            unset($this->connection);
        }
    }

    function IsOpen()
    {
        return isset($this->connection);
    }

    function Execute($sql, $values=null)
    {
		$this->SetNull();
		if(isset($values)){		// CHECK WHETHER $values IS NULL OR NOT. IF ITS NOT NULL THEN USE PARAMETERIZED SQL QUERY EXECUTION ELSE USE STRAIGHT SIMPLE SQL QUERY EXECUTION
			if(!is_array($values)){ // check whether $value is array or not.
				$values = array($values);
			}
		}
		
		try{
			$this->stmt = $this->connection->prepare($sql); // prepare stmt
			$i=0;
			$count = count($values);
			if($count>0){
				foreach($values as $k=>$v){
					$i++;
					if( is_numeric($v)){
						$this->stmt->bindParam($i, $values[$k], PDO::PARAM_INT);
					}
					elseif($v==""){
						$v = null;
						$this->stmt->bindParam($i, $values[$k], PDO::PARAM_NULL);
					}
					else{
						$this->stmt->bindParam($i, $values[$k], PDO::PARAM_STR);
					}
				}
			}
			if($this->stmt->execute())
			{
				$this->stmt->setFetchMode(PDO::FETCH_ASSOC);
				$this->result = $this->stmt->fetchAll();
				$this->numrows= count($this->result);
				$this->numfields= $this->stmt->columnCount();	
				$this->index=0;
				return true;
			}
			$this->stmt->closeCursor();
		}catch(Exception $e){
			$this->ShowError($e);
			$this->stmt->closeCursor();
		}
		
		return false;
    }

    function ExecuteRaw($sql,$values=null)
    {
		$this->SetNull();
		if(isset($values)){		// CHECK WHETHER $values IS NULL OR NOT. IF ITS NOT NULL THEN USE PARAMETERIZED SQL QUERY EXECUTION ELSE USE STRAIGHT SIMPLE SQL QUERY EXECUTION
			if(!is_array($values)){ // check whether $value is array or not.
				$values = array($values);
			}
		}
		try{
			$this->stmt = $this->connection->prepare($sql); // prepare stmt
			$i=0;
			$count = count($values);
			if($count>0){
				foreach($values as $k=>$v){
					$i++;
					if( is_numeric($v)){
						$this->stmt->bindParam($i, $values[$k], PDO::PARAM_INT);
					}
					elseif($v==""){
						$v = null;
						$this->stmt->bindParam($i, $values[$k], PDO::PARAM_NULL);
					}
					else{
						$this->stmt->bindParam($i, $values[$k], PDO::PARAM_STR);
					}
					
				}
			}
			if($this->stmt->execute())
			{
				$this->rowsaffected = $this->stmt->rowCount();
				return true;
			}
		}catch(Exception $e){
			$this->ShowError($e);
			$this->stmt->closeCursor();
		}
		return false;
    }
	
	function GetAffectedRows()
	{
		return $this->rowsaffected;
	}
	
	function GetRow($index=-2)
	{
		$this->row = null;
		if($index!=-2)
		{
			$this->index = $index;
		}
		$this->row = $this->result[$this->index];
		$this->index = $this->index + 1;
		return $this->row;
	}
	function GetResult()
	{
		return $this->result;
	}
	function GetIndex()
	{
		return $this->index;
	}
	
	function GetNumRows()
	{
		return $this->numrows;
	}
	
	protected function SetNull()
	{
		$this->result = null;
		$this->index = null;
		$this->numfields = null;
		$this->row = null;
		$this->numrows = null;
		$this->numfields = null;
		$this->rowsaffected = null;
	}

    function GetLastInsertID() {        		
		return $this->connection->lastInsertId();
    }
	
	 function ShowError()
	{
		print_r( $this->stmt->errorInfo());
		print_r( $this->connection->errorInfo());
	}
	
	function beginTransaction() {        		
		return $this->connection->beginTransaction();
    }	
	function commit() {        		
		return $this->connection->commit();
    }	
	function rollBack() {        		
		return $this->connection->rollBack();
    }
	
}
?>
