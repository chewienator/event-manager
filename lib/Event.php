<?php 
class Event{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    //Get all active events filtered or unfiltered
    public function getAllActiveEvents($sort = null){
        
        if($sort == 'new'){ //sort by new events published
            $sort = 'id DESC';
        }else{ //sort 
            $sort = 'date_time ASC';
        }
        
        $this->db->query("SELECT e.*, a.name AS activity_name FROM event AS e 
                    LEFT JOIN activity AS a ON activity_id = a.id
                    WHERE e.active = 1 AND e.disabled = 0 
                    ORDER BY $sort");
        
        //assign result set
        $results = $this->db->resultSet();

        return $results;
    }

    //Get all active events filtered by activity
    public function getAllActiveEventsByActivity($activity, $sort = null){

        if($sort == 'new'){ //sort by new events published
            $sort = 'id DESC';
        }else{ //sort 
            $sort = 'date_time DESC';
        }

        $this->db->query("SELECT e.*, a.name AS activity_name FROM event AS e 
                    LEFT JOIN activity AS a ON activity_id = a.id
                    WHERE 
                        active = 1 AND e.disabled = 0 AND activity_id = :activity_id 
                    ORDER BY $sort");       

        $this->db->bind(':activity_id', $activity);

        //assign result set
        $results = $this->db->resultSet();

        return $results;
    }

    //Get event by id
    public function getEvent($event_id){
        $this->db->query("SELECT * FROM event WHERE id = :id_event");

        $this->db->bind(':id_event', $event_id);

        //assign result set
        $results = $this->db->singleResult();

        return $results;
    }

    //Create event
    public function createEvent($data){

        //get the distance from location 1 to location 2
        $trip_info = $this->getTripInfo($data['location_id'], $data['location_id2'], strtotime($data['date_time']) * 1000);        
                
        if($trip_info){

            $this->db->query("INSERT INTO event 
                    (name, activity_id, date_time, registration_close, location_id, location_id2, description, distance, traveling_time) 
                VALUES 
                    (:name, :activity_id, :date_time, :registration_close, :location_id, :location_id2, :description, :distance, :traveling_time)");

            $this->db->bind(':name', $data['name']);
            $this->db->bind(':activity_id', $data['activity_id']);
            $this->db->bind(':date_time', $data['date_time']);
            $this->db->bind(':registration_close', $data['registration_close']);
            $this->db->bind(':location_id', $data['location_id']);
            $this->db->bind(':location_id2', $data['location_id2']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':distance', $trip_info['distance']);
            $this->db->bind(':traveling_time', $trip_info['time']);

            if($this->db->execute()){
                //get event id
                $event_id = $this->db->lastInsertId();
                //create atendees
                if($this->inviteUsers($event_id, $data['class_groups'], $data['organisers'])){
                    //update event organisers
                    if($this->updateEventOrganisers($data['id'], $data['organisers'])){ 
                        return true;
                    }else{
                        throw new Exception("Organisers could not be updated");
                        return false; 
                    }
                }else{
                    throw new Exception("Attendees could not be created");
                    return false;
                }
            }else{
                throw new Exception("Event could not be created");
                return false;
            }
        }else{
            throw new Exception("Google info not present");
            return false;
        }
    }

    //Use google maps directions api to get the distance and travel time
    private function getTripInfo($location_id, $location_id2, $time){
        //get coordinates for location 1
        $loc1 = $this->getLocationCoordinates($location_id);
        $loc2 = $this->getLocationCoordinates($location_id2);

        
        //let's query google maps directions API
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$loc1&destination=$loc2&departure_time=$time&mode=driving&key=AIzaSyDHqmFIeMEYvAqiV1KdQx7gD98HS7ne97w";

        // get the json response
        $resp_json = file_get_contents($url);
        
        // decode the json
        $resp = json_decode($resp_json, true);
        // response status will be 'OK', if able to geocode given address 
        if($resp['status']=='OK'){
            $result = array(
                'time' => $resp['routes'][0]['legs'][0]['duration']['value'],
                'distance' => $resp['routes'][0]['legs'][0]['distance']['value']
            );

            return $result;
        }else{
            return false;
        }
    }

    private function getLocationCoordinates($location_id){
        //get users from class group
        $this->db->query("SELECT latitude, longitude FROM location WHERE id = :location_id");

        $this->db->bind(':location_id', $location_id);

        $result = $this->db->singleResult();

        return $result->latitude.','.$result->longitude;
    }

    //Edit event
    public function editEvent($data){

        $trip_info = $this->getTripInfo($data['location_id'], $data['location_id2'], strtotime($data['date_time']) * 1000);

        if(count($trip_info)>0){
            $this->db->query("UPDATE event 
                        SET                     
                        name = :event_name, 
                        activity_id = :activity_id,
                        date_time = :date_time,
                        registration_close = :registration_close,
                        location_id = :location_id,
                        location_id2 = :location_id2,
                        distance = :distance,
                        traveling_time = :traveling_time,
                        description = :description
                        WHERE id = :event_id");

            $this->db->bind(':event_id', $data['id']);
            $this->db->bind(':event_name', $data['name']);
            $this->db->bind(':activity_id', $data['activity_id']);
            $this->db->bind(':date_time', $data['date_time']);
            $this->db->bind(':registration_close', $data['registration_close']);
            $this->db->bind(':location_id', $data['location_id']);
            $this->db->bind(':location_id2', $data['location_id2']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':distance', $trip_info['distance']);
            $this->db->bind(':traveling_time', $trip_info['time']);

            if($this->db->execute()){
                if($this->updateEventOrganisers($data['id'], $data['organisers'])){
                    return true;
                }else{                    
                    return false;
                }                
            }else{
                return false;
            }
        }
    }

    //create attendees records
    private function inviteUsers($event_id, $groups, $organisers){
        
        $groups = implode(",",$groups);
        
        //get users from class group
        $this->db->query("SELECT id FROM user WHERE group_id IN ($groups)");

        $this->db->bind(':id_event', $event_id);

        //assign result set
        $resultSet = $this->db->resultSet();
       
        //prepare insert stmt for the insert
        $query = "INSERT INTO event_attendees (event_id, user_id) VALUES ";

        //add user params to the params array       
        foreach($resultSet as $result){
            if(!in_array($result->id, $organisers)){
                $query_params[] = "($event_id, $result->id)";
            }
        }        

        //add the organisers to the params array
        foreach($organisers as $organiser_id){
            $query_params[] = "($event_id, $organiser_id)";
        }        

        //create the big query string
        $query_params = implode(",",$query_params);

        //append the remaining string to query
        $query .= $query_params;

        $this->db->query($query);
        
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }        
    }

    //Delete event
    public function deleteEvent($event_id){
        $this->db->query("UPDATE event SET disabled = 1 WHERE id = :event_id");

        $this->db->bind(':event_id', $event_id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Get event organisers
    public function getEventOrganisers($event_id){

        $this->db->query("SELECT id
                    FROM event_attendees AS ea 
                    LEFT JOIN user AS u ON u.id = ea.user_id
                    WHERE 
                        event_id = :id_event AND ea.is_organiser = 1 
                    ORDER BY u.last_name ASC");

        $this->db->bind(':id_event', $event_id);

        //assign result set
        $resultSet = $this->db->resultSet();

        //convert to sinple array
        $results = array();
        foreach($resultSet as $result){
            $results[] = $result->id;
        }
        return $results;
    }

    //update the status of organisers in the attendees list
    private function updateEventOrganisers($event_id, $organisers){
        $organisers = implode(",",$organisers);
        
        $this->db->query("UPDATE event_attendees SET is_organiser = 1 WHERE event_id = :event_id AND user_id IN ($organisers)");

        $this->db->bind(':event_id', $event_id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Get event attendees user list
    public function getAttendees($event_id){
        //get users from event
        $this->db->query("SELECT u.*,ea.* 
                        FROM user AS u JOIN event_attendees AS ea
                        ON u.id = ea.user_id
                        WHERE ea.event_id = :event_id 
                        ORDER BY u.last_name ASC");

        $this->db->bind(':event_id', $event_id);
        
        //assign result set
        $resultSet = $this->db->resultSet();

        return $resultSet;
    }

    //Get event NON attendees user list
    public function getNonAttendees($event_id){
        //get users from event
        $this->db->query("SELECT * FROM user 
                    WHERE id 
                        NOT IN (SELECT DISTINCT(user_id) FROM event_attendees WHERE event_id = 2)
                    ORDER BY last_name ASC");

        $this->db->bind(':event_id', $event_id);
        
        //assign result set
        $resultSet = $this->db->resultSet();

        return $resultSet;
    }

    //add attendee to event attending users list
    public function addAttendee($data){
        $this->db->query("INSERT INTO event_attendees (event_id, user_id, is_organiser) VALUES (:event_id, :user_id, :is_organiser)");

        $this->db->bind(':event_id', $data['event_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':is_organiser', $data['is_organiser']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //change attendee state
    public function attendeeStatus($data, $status = null){

        //flip state bit
        $state = ($data['state'] == 1)? 0 : 1;

        switch($status){
            case 'attending':
                $param = 'attending';
                break;
            case 'confirm':
                $param = 'confirmed';
                break;
            case 'attended':
                $param = 'attended';
                break;
        }

        if($status != null){
            $this->db->query("UPDATE event_attendees 
                    SET  
                        $param = :$param 
                    WHERE 
                        event_id = :event_id AND 
                        user_id = :user_id");

            $this->db->bind(':event_id', $data['event_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':'.$param, $state);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //delete attendee from event list
    public function deleteAttendee($data){
        $this->db->query("DELETE FROM event_attendees WHERE event_id=:event_id AND user_id=:user_id");

        $this->db->bind(':event_id', $data['event_id']);
        $this->db->bind(':user_id', $data['user_id']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}