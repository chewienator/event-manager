<?php 
class Location{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Get all locations
    public function getLocations(){
        $this->db->query("SELECT * FROM location WHERE disabled = 0 ORDER BY name ASC");

        //get row
        $results = $this->db->resultSet();

        return $results;
    }

    //Get location by id
    public function getLocation($id){
        $this->db->query("SELECT * FROM location WHERE id = :location_id");

        $this->db->bind(':location_id', $id);

        //get row
        $results = $this->db->singleResult();

        return $results;
    }

    //Create location
    public function createLocation($data){
        $this->db->query("INSERT INTO location (name, latitude, longitude) VALUES (:location_name, :location_latitude, :location_longitude)");

        $this->db->bind(':location_name', $data['name']);
        $this->db->bind(':location_latitude', $data['latitude']);
        $this->db->bind(':location_longitude', $data['longitude']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Edit location
    public function editLocation($data){
        $this->db->query("UPDATE location 
                    SET 
                        name = :location_name,
                        latitude = :location_latitude,
                        longitude = :location_longitude
                    WHERE id = :location_id");

        $this->db->bind(':location_id', $data['id']);
        $this->db->bind(':location_name', $data['name']);
        $this->db->bind(':location_latitude', $data['latitude']);
        $this->db->bind(':location_longitude', $data['longitude']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Delete location
    public function deleteLocation($id){
        $this->db->query("UPDATE location SET disabled = 1 WHERE id = :location_id");

        $this->db->bind(':location_id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}