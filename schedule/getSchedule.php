<?php
header("Access-Control-Allow-Origin: *");
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('../class/Schedule.php');
$student = new Schedule();
switch($requestMethod) {
    case 'GET':
        if ($_GET && $_GET['teamA']) {
            $student->setTeamA($_GET['teamA']);
            $student->setTeamB($_GET['teamB']);
            $student->setRound($_GET['round']);
            $student->generateMatches();
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