<?php
/**
 * @package user class
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 */

include("config/database.php");
class User
{
    protected $db;
    private $_userID;
    private $_firstName;
    private $_lastName;
    private $_firebaseID;

    public function setUserID($userID) {
        $this->_userID = $userID;
    }
    public function setFirstName($firstName) {
        $this->_firstName = $firstName;
    }
    public function setLastName($firstName) {
        $this->_lastName = $firstName;
    }


    public function setFirebaseID($firebaseID) {
        $this->_firebaseID = $firebaseID;
    }


    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }

    // create user
    public function createuser() {
        try {
            $sql = 'INSERT INTO user (first_name, last_name, firebaseID)  VALUES (:first_name, :last_name, :firebaseID)';
            $data = [
                'first_name' => $this->_firstName,
                'last_name' => $this->_lastName,
                'firebaseID' => $this->_firebaseID,
            ];
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            $status = $stmt->rowCount();
            return $status;

        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }

    }

    // update user
    public function updateuser() {
        try {
            $sql = "UPDATE user SET first_name=:first_name, last_name=:last_name,firebaseID=:firebaseID WHERE id=:user_id";
            $data = [
                'first_name' => $this->_firstName,
                'last_name' => $this->_lastName,
                'firebaseID' => $this->_firebaseID,
                'user_id' => $this->_userID
            ];
            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            $status = $stmt->rowCount();
            return $status;
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }

    // getAll user
    public function getAlluser() {
        try {
            $sql = "SELECT * FROM user";
            $stmt = $this->db->prepare($sql);

            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }

    // get user
    public function getuser() {
        try {
            $sql = "SELECT * FROM user WHERE id=:user_id";
            $stmt = $this->db->prepare($sql);
            $data = [
                'user_id' => $this->_userID
            ];
            $stmt->execute($data);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }

    // delete user
    public function deleteuser() {
        try {
            $sql = "DELETE FROM user WHERE id=:user_id";
            $stmt = $this->db->prepare($sql);
            $data = [
                'user_id' => $this->_userID
            ];
            $stmt->execute($data);
            $status = $stmt->rowCount();
            return $status;
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }


}
?>