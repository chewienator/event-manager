<?php 
class User{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Get all users
    public function getAllUsers(){
        $this->db->query("SELECT * FROM user WHERE disabled = 0 ORDER BY last_name ASC");

        //get row
        $results = $this->db->resultSet();

        return $results;
    }

    //Get all Kids and parents
    public function getKidsAndParents(){
        $this->db->query("SELECT * FROM user WHERE disabled = 0 AND user_type = 3 ORDER BY last_name ASC");

        //get row
        $results = $this->db->resultSet();

        return $results;
    }

    //Get all staff users
    public function getStaffUsers(){
        $this->db->query("SELECT * FROM user WHERE disabled = 0 AND user_type = 2 ORDER BY last_name ASC");

        //get row
        $results = $this->db->resultSet();

        return $results;
    }

    //Get user by id
    public function getUser($id){
        $this->db->query("SELECT * FROM user WHERE id = :user_id");

        $this->db->bind(':user_id', $id);

        //get row
        $results = $this->db->singleResult();

        return $results;
    }

    //Create user
    public function createUser($data){
        $this->db->query("INSERT INTO user (first_name, last_name, email, mobile, user_type, group_id) VALUES (:first_name, :last_name, :email, :mobile, :user_type, :group_id)");

        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':user_type', $data['user_type']);
        $this->db->bind(':group_id', $data['group_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Edit user
    public function editUser($data){
        $this->db->query("UPDATE user 
                    SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        mobile = :mobile,
                        user_type = :user_type,
                        group_id = :group_id
                    WHERE id = :user_id");

        $this->db->bind(':user_id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':user_type', $data['user_type']);
        $this->db->bind(':group_id', $data['group_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Delete user
    public function deleteUser($id){
        $this->db->query("UPDATE user SET disabled = 1 WHERE id = :user_id");

        $this->db->bind(':user_id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Get all user types
    public function getUserTypes(){
        $this->db->query("SELECT * FROM user_type WHERE disabled = 0 ORDER BY name ASC");

        //get row
        $results = $this->db->resultSet();

        return $results;
    }
}