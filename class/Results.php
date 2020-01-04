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
class Results
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


    public function getResults() {
        try {
            $sql = "select PlayerA.firstName as Player1FirstName, PlayerB.firstName Player2FirstName,
                           PlayerA.lastName as  Player1LastName,PlayerB.lastName as  Player2LastName ,
                           results.round from results  
                           inner join users as PlayerA on PlayerA.id= results.player1
                           inner join users as playerB on PlayerB.id=results.player2
                           where round = :round_id and PlayerA.team = :teamA and PlayerB.team=:teamB";
            $stmt = $this->db->prepare($sql);

            $data = [
                'round_id' => $this->_round,
                'teamA' => $this->_teamA,
                'teamB' => $this->_teamB
			];

            $stmt->execute($data);
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