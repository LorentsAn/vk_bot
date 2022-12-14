<?php

namespace db;

class database {
    public object $connection;
    private string $host = '127.0.0.1';
    private string $port = '5432';
    private string $dbname = 'postgres';
    private string $username = 'postgres';
    private string $password = 'postgres';

    public function getConnection() {
        $this->connection = pg_connect( "host = $this->host port = $this->port dbname = $this->dbname user = $this->username password=$this->password" );
        if(!$this->connection) {
            echo "Error : Unable to open database\n";
        } else {
            echo "Opened database successfully\n";
        }
    }
}