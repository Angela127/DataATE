<?php

/* PDO Database Class
*Connect to database
*Create preprared statements
*Binds values
*Return rows and results
*/

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $pdo;
    private $stmt;
    private $error;

    private static $instance= null;

    private function __construct()
    {

        //set DSN (data source name)
        $dsn='mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $option = [
            PDO::ATTR_PERSISTENT =>true, //Persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_OBJ,
        ];

        //Create PDO instance
        try{
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $option);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //Get singleton instance
    public static function getInstance()
    {
        if(self::$instance == null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    //get the PDO connection
    public function getConnection()
    {
        return $this->pdo;
    }

}