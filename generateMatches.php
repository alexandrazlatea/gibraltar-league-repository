<?php
header("Access-Control-Allow-Origin: *");
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('class/GenerateMatches.php');

$generateMatches = new GenerateMatches();
switch($requestMethod) {
    case 'GET':

        $generateMatches->setTeamA($_GET['teamA']);
        $generateMatches->setTeamB($_GET['teamB']);
        $generateMatches->generateMatches();

        if(!empty($schedule)) {
            $js_encode = json_encode($schedule);
        } else {
            $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
        echo $js_encode;
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>