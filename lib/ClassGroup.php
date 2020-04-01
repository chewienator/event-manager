<?php 
class ClassGroup{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Get all Class Group types
    public function getAllClassGroups(){
        $this->db->query('SELECT * FROM class_group WHERE disabled = 0 ORDER BY name ASC');

        //assign result set
        $results = $this->db->resultSet();

        return $results;
    }

    //Get Class Group by id
    public function getClassGroup($id){
        $this->db->query('SELECT * FROM class_group WHERE id = :class_group_id');

        $this->db->bind(':class_group_id', $id);

        //get row
        $results = $this->db->singleResult();

        return $results;
    }

    //Get Class Group name
    public function getClassGroupName($id){
        $this->db->query('SELECT name FROM class_group WHERE id = :class_group_id');

        $this->db->bind(':class_group_id', $id);

        //get row
        $results = $this->db->singleResult();

        return $results;
    }

    //Create Class Group
    public function createClassGroup($data){
        $this->db->query("INSERT INTO class_group (name) VALUES (:class_group_name)");

        $this->db->bind(':class_group_name', $data['name']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Edit Class Group
    public function editClassGroup($data){
        $this->db->query("UPDATE class_group SET name = :class_group_name WHERE id = :class_group_id");

        $this->db->bind(':class_group_id', $data['id']);
        $this->db->bind(':class_group_name', $data['name']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Delete Class Group
    public function deleteClassGroup($id){
        $this->db->query("UPDATE class_group SET disabled = 1 WHERE id = :class_group_id");

        $this->db->bind(':class_group_id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}