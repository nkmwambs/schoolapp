<?php

//require_once('config.php');

class Database {

	private $db_name;
	private $config = array();

	function __construct(){
		$this->config['db_user'] = 'compatl8_root';
		$this->config['db_password'] = '@Compassion123';
		$this->config['db_prefix'] = "techsys_";
	}

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{

		$this->db_name  = $this->new_database_name();

		$response  = array();
		// Connect to the database
		$mysqli = new mysqli('localhost',$this->config['db_user'],$this->config['db_password'],'');

		// Check for errors
		if($mysqli->connect_errno)
		{
			$response['msg'] = 'Failed to connect to MySQL : '. $mysqli->connect_error;
			//$response['test'] = $this->db_name;
			$response['success'] = false;
		}
		else  if(!$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$this->db_name)){
			$response['msg'] = "Database Error : Database <b>".$this->db_name."</b> does not exist and could not be created. Please create the Database manually and retry installing.";
			//$response['test'] = $this->db_name;
			$response['success'] = false;
		}
		else
		{
			$response['success'] = true;
			//$response['test'] = $this->db_name;
		}

		// Close the connection
		$mysqli->close();

		return $response;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		//$mysqli = new mysqli($data['hostname'],$data['db_user'],$data['db_password'],$this->db_name);
		$mysqli = new mysqli('localhost','compatl8_root','@Compassion123',$this->db_name);
		//$mysqli = new mysqli('localhost',$this->config['db_user'],$this->config['db_password'],$this->db_name);

		// Check for errors
		if($mysqli->connect_errno){
			$message  = "Failed to connect to MySQL: " . $mysqli->connect_error;
			return false;
		}

		// Open the default SQL file
		$query = file_get_contents('assets/install.sql');

		// Execute a multi query
		if($mysqli->multi_query($query)){
			while ($mysqli->next_result()) {;}
		}

		// Close the connection
		$mysqli->close();

		return true;
	}

	function new_database_name(){
		//Connect to the database

		$mysqli = new mysqli('localhost',$this->config['db_user'],$this->config['db_password'],'');

		// Check for errors
		if($mysqli->connect_errno){
			$message  = "Failed to connect to MySQL: " . $mysqli->connect_error;
			return false;
		}

		$result = $mysqli->query("SELECT COUNT(*) as count FROM information_schema.SCHEMATA") or die(mysql_error());

		$row = mysqli_fetch_array($result) or die(mysql_error());

		$count_of_databases = $row['count'] + 1;

		return "schoolapp_".$count_of_databases;
	}

}
