<?php

class Database{

    private $statement;
    private $dbHandler;
    private $error;

    public function __construct()
    {
        $connect = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME; //Changeable depending on database engine
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        
        try{
            $this->dbHandler = new PDO($connect, DB_USER, DB_PASS, $options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query($sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    public function bind($parameter, $value, $type = null)
    {
        switch(is_null($type)){
            case is_int($value):
                $type = PDO::PARAM_INT;
            break;

            case is_bool($value):
                $type = PDO::PARAM_BOOL;
            break;

            case is_null($value):
                $type = PDO::PARAM_NULL;
            break;

            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    public function execute()
    {
        return $this->statement->execute();
    }

    public function fetchAll()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        $this->execute();
        return $this->statement->rowCount();
    }
}