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

class GenerateMatches
{
    protected $db;
    private $_teamA;
    private $_teamB;

    public function setTeamA($teamA)
    {
        $this->_teamA = $teamA;
    }

    public function setTeamB($teamB)
    {
        $this->_teamB = $teamB;
    }

    public function __construct()
    {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }
}


?>