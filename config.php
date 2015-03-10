<?php

function global_val($key) {
    $a = array();
    $a["servername"] = "localhost"; //mysql servername
    $a["username"] = "root"; //mysql username
    $a["password"] = "turtlebot"; //mysql password
    $a["databasename"] = "telepresence"; //mysql database
    if(!array_key_exists($key,$a)) {
        die("global value does not exist [$key]");
    }
    return $a[$key];
}