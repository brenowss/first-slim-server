<?php

    class db{
        private $dbhost = 'localhost';
        private $dbuser = 'brn';
        private $dbpass = '123';
        private $dbname = 'slimapp';

        public function connect(){
            $mysql_connect_str =  "mysql:host=$this->dbhost;dbname=$this->dbname;";
            $db_connection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db_connection;
        }
    }