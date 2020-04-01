<?php 
class Activity{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Get all activity types
    public function getAllActivities(){
        $this->db->query('SELECT * FROM activity WHERE disabled = 0 ORDER BY name ASC');

        //assign result set
        $results = $this->db->resultSet();

        return $results;
    }

    //Get activity by id
    public function getActivity($id){
        $this->db->query('SELECT * FROM activity WHERE id = :activity_id');

        $this->db->bind(':activity_id', $id);

        //get row
        $results = $this->db->singleResult();

        return $results;
    }

    //Get activity name
    public function getActivityName($id){
        $this->db->query('SELECT name FROM activity WHERE id = :activity_id');

        $this->db->bind(':activity_id', $id);

        //get row
        $results = $this->db->singleResult();

        return $results;
    }

    //Create activity
    public function createActivity($data){
        $this->db->query("INSERT INTO activity (name) VALUES (:activity_name)");

        $this->db->bind(':activity_name', $data['name']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Edit activity
    public function editActivity($data){
        $this->db->query("UPDATE activity SET name = :activity_name WHERE id = :activity_id");

        $this->db->bind(':activity_id', $data['id']);
        $this->db->bind(':activity_name', $data['name']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Delete activity
    public function deleteActivity($id){
        $this->db->query("UPDATE activity SET disabled = 1 WHERE id = :activity_id");

        $this->db->bind(':activity_id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}