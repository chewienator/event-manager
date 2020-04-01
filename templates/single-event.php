<?php include 'inc/header.php' ?>


    <div class="container mt-4">
        <div class="row">
            <form method="post" action="event.php" class="col-md-8">
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Activity type</label>
                        </div>
                        <select name="activity" class="custom-select form-control">
                            <option value="all">All</option>
                            <?php foreach($activities as $activity): 
                                $selected = ($activity->id == $event->activity_id) ? 'selected' : ''; ?>
                            <option value="<?php echo $activity->id; ?>" <?php echo $selected; ?>><?php echo $activity->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Name</label>
                        </div>
                        <input type="text" class="form-control" name="name" value="<?php echo ($event)? $event->name : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Date & time</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="datetime" value="<?php echo ($event)? date("Y-m-d\TH:i:s", strtotime($event->date_time)) : ''; ?>" required>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Registration close</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="registration_close" value="<?php echo ($event)? date("Y-m-d\TH:i:s", strtotime($event->registration_close)) : ''; ?>">
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Meeting location</label>
                        </div>
                        <select name="location" class="custom-select form-control" required>
                            <option>Choose location</option>
                            <?php foreach($locations as $location): 
                                $selected = ($location->id == $event->location_id) ? 'selected' : ''; ?>
                            <option value="<?php echo $location->id; ?>" <?php echo $selected; ?>><?php echo $location->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Event Location</label>
                        </div>
                        <select name="location2" class="custom-select form-control" required>
                            <option>Choose location</option>
                            <?php foreach($locations as $location): 
                                $selected = ($location->id == $event->location_id2) ? 'selected' : ''; ?>
                            <option value="<?php echo $location->id; ?>" <?php echo $selected; ?>><?php echo $location->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Description</label>
                        </div>
                        <textarea rows="5" class="form-control" name="description"><?php echo ($event)? $event->description : ''; ?></textarea>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="form-group mr-2">
                    <h6>Organiser(s)</h6>
                    <select name="organisers[]" class="selectpicker form-control" multiple data-live-search="true" required>
                    <?php foreach($teachers as $teacher):
                        $selected = (in_array($teacher->id, $organisers)) ? 'selected' : ''; ?>
                        <option value="<?php echo $teacher->id; ?>" <?php echo $selected; ?>><?php echo $teacher->last_name .' '.$teacher->first_name; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <?php if($action != 'e'): ?>
                <br>
                <hr>
                <br>
                <div class="form-group mr-2">
                    <h6>Invite group(s)</h6>
                    <select name="class_groups[]" class="selectpicker form-control" multiple data-live-search="true" required>
                    <?php foreach($class_groups as $class_group):
                        $selected = (in_array($class_group->id, $invited_groups)) ? 'selected' : ''; ?>
                        <option value="<?php echo $class_group->id; ?>" <?php echo $selected; ?>><?php echo $class_group->name; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                <input type="hidden" name="a" value="<?php echo ($action)? $action : 'c'; ?>">
                <input type="hidden" name="id" value="<?php echo ($action)? $event->id : ''; ?>">
                <input type="submit" class="btn btn-primary" value="Save" name="submit"><a href="index.php" class="btn btn-default">Cancel</a>
            </form>   
        </div> <!-- row -->        
    
    </div> <!-- /container -->


<?php include 'inc/footer.php' ?>