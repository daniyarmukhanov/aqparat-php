<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();
$page=0;
if(isset($_POST["page"])){
    $page=$_POST["page"];
}
$start=$page*15;
$end=$start+15;

// get all products from products table
$result = mysql_query("SELECT * FROM  `news` ORDER BY  `news`.`time` DESC LIMIT ".$start.",".$end) or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["news"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $news = array();
        $news["id"] = $row["id"];
        $news["title"] = $row["title"];
        $news["description"] = $row["description"];
        $news["text"] = $row["text"];
        $news["time"] = $row["time"];
        $news["photo"] = $row["photo"];
        $news["resource_id"] = $row["resource_id"];

        // push single product into final response array
        array_push($response["news"], $news);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";

    // echo no users JSON
    echo json_encode($response);
}
?>