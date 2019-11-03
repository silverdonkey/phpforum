<?php

require 'db/config.php';

class Database {
    /**
     * @var Database
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO
     */
    protected $_dbHandle;

    /**
     *       $username ='sgb971';
     *      $password = 'avangard78';
     *      $host = 'poseidon.salford.ac.uk';
     *      $dbName = 'sgb971';
     * @return Database
     */
    public static function getInstance() {
       
       if(self::$_dbInstance === null) { //checks if the PDO exists
            // creates new instance if not, sending in connection info
            self::$_dbInstance = new self();
        }
        return self::$_dbInstance;
    }

    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     */
    private function __construct() {
        try {
            // $pdo = new \Pdo('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $this->_dbHandle = new \Pdo('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // creates the database handle with connection info
        }
        catch (PDOException $e) { // catch any failure to connect to the database
	        echo $e->getMessage();
	    }
    }

    /**
     * @return PDO
     */
    public function getDBConnection() {
        return $this->_dbHandle; // returns the PDO handle to be used                                        elsewhere
    }

    public function __destruct() {
        $this->_dbHandle = null; // destroys the PDO handle when nolonger needed                                        longer needed
    }
}
