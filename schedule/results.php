<?php
header("Access-Control-Allow-Origin: *");
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('../class/Results.php');
$results = new Results();
switch($requestMethod) {
    case 'GET':
        if ($_GET['teamA']) {
            $results->setTeamA($_GET['teamA']);
            $results->setTeamB($_GET['teamB']);
            $results->setRound($_GET['round']);
            $res =$results->getResults();
            if (!empty($res)) {
                $js_encode = json_encode($res);
            } else {
                $js_encode = json_encode(array('status' => FALSE, 'message' => 'There is no record yet.'), true);
            }
            header('Content-Type: application/json');
            echo $js_encode;
            break;
        } else {

            $schedule = $student->getSchedule();

            if (!empty($schedule)) {
                $js_encode = json_encode($schedule);
            } else {
                $js_encode = json_encode(array('status' => FALSE, 'message' => 'There is no record yet.'), true);
            }
            header('Content-Type: application/json');
            echo $js_encode;
            break;
        }
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>