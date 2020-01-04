<?php
/**
 * @package user class
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 */

include("../config/database.php");
class Schedule
{
    protected $db;
    private $_teamA;
    private $_teamB;
    private $_round;

    public function setTeamA($teamA) {
        $this->_teamA = $teamA;
    }
    public function setRound($round) {
        $this->_round = $round;
    }
    public function setTeamB($teamB) {
        $this->_teamB = $teamB;
    }

    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }



    public function getSchedule() {
        try {
            $sql = "SELECT teams1.name as teamA, teams1.id as teamA_id, teams2.id as teamB_id, teams2.name as teamB ,round, rounds.date as round_date FROM schedule 
                      inner join teams as teams1 on teams1.id = schedule.teamA
                      inner join teams as teams2 on teams2.id = schedule.teamB
                      inner join rounds on rounds.id = schedule.round ORDER BY round_date";
            $stmt = $this->db->prepare($sql);

            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }

    public function generateMatches() {
        $sql_playersA= "select id from users where team = ".$this->_teamA;
        $stmt = $this->db->prepare($sql_playersA);
        $stmt->execute();
        $playersA = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $sql_playersB= "select id from users where team = ".$this->_teamB;
        $stmt = $this->db->prepare($sql_playersB);
        $stmt->execute();
        $playersB = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        for ($i= 0; $i < count($playersA); ++$i) {
            for ($j= 0; $j < count($playersB); ++$j) {
                $playerA = $playersA[$i]['id'];
                $playerB = $playersB[$j]['id'];
                $sql1 = "INSERT INTO `results`(`player1`, `player2`, `round`) VALUES ($playerA, $playerB, $this->_round)";
                $stmt = $this->db->prepare($sql1);
                $stmt->execute();

            }
        }

//        try {
//            $sql = "SELECT teams1.name as teamA,  teams2.name as teamB ,schedule.date FROM schedule
//                      inner join teams as teams1 on teams1.id = schedule.teamA
//                      inner join teams as teams2 on teams2.id = schedule.teamB";
//            $stmt = $this->db->prepare($sql);
//
//            $stmt->execute();
//            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
//            return $result;
//        } catch (Exception $e) {
//            die("Oh noes! There's an error in the query!");
//        }
    }
}
?>