<?php

require_once "./config.php";

class db {
    private static $conn;
    //conn - connect to MYSQL
    //to make life easier for first time developers this function automatically creates the database & table if they are missing
    public static function conn() {
        self::$conn = new mysqli(global_val("servername"), global_val("username"), global_val("password"));
        // Check connection
        if (self::$conn->connect_error) {
            die("Connection failed: " . self::$conn->connect_error);
        }
        //check if we need to create the database
        self::create_database();
        self::$conn->select_db(global_val("databasename"));
        //check if we need to create tables
        self::create_tables();
        return self::$conn;
    }
    //end conn
    //create_database
    private static function create_database() {
        self::$conn->query("CREATE DATABASE IF NOT EXISTS " . global_val("databasename")) or die("create_database failed");
    }
    //end create_database
    //create_tables
    private static function create_tables() {
        $result = self::$conn->query("select * from telep limit 1");
        if(empty($result)) {
            $query = "CREATE TABLE telep (
                          ID INT AUTO_INCREMENT,
                          action_val VARCHAR(20),
                          PRIMARY KEY  (ID)
                          )";
            self::$conn->query($query) or die("create table failed");
        }
    }
    //end create_tables
}