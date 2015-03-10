<?php

require_once "./db.php";

if(isset($_GET['read'])) {
    telepresence_api::read();
}
if(isset($_GET['save'])) {
    telepresence_api::save($_GET['save']);
}

class telepresence_api {
    //state_is_valid
    //mild quality control; just make sure the state passed to the API is actually a known state
    public static function state_is_valid($state) {
        return in_array($state,self::ret_array_of_valid_states());
    }
    //end state_is_valid

    //ret_array_of_valid_states
    //list of valid states
    private static function ret_array_of_valid_states() {
        return array("forward","left","right","reverse","stop");
    }
    //end ret_array_of_valid_states

    //save state
    //index.html calls this via ajax calls
    public static function save($state) {
        //is the state valid? (and avoid sql injection)
        if(!self::state_is_valid($state)) {
            return false;
        }

        //save the state
        $conn = db::conn();
        $conn->query("insert into telep values(NULL,'" . $state . "')") or die("telep insert failed");

        $a = array();
        $a["success"] = 1;
        self::json_headers();
        echo json_encode($a);
        exit;
    }
    //end save state

    //read
    //TurtleBot calls this to see what it should do next every half second
    public static function read() {
        $conn = db::conn();
        //return the most recent action_val
        $a = array();
        $result = $conn->query("select action_val from telep order by ID desc limit 1") or die("telep read failed");
        if($row =  $result->fetch_assoc()) {
            $a["action"] = $row['action_val'];
        }
        else {
            $a["action"] = "stop"; //default
        }

        self::json_headers();
        echo json_encode($a);
        exit;
    }
    //end read

    //json_headers
    private static function json_headers() {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Access-Control-Allow-Origin: *');
    }
    //end json_headers
}