<?php include 'inc/header.php' ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
        <h1 class="display-4">Welcome!</h1>
        <p>Event Manager is a simple application that will allow a school to create and manage all their school events in a very easy way. You can create events such as trip days, field trips, painting bootcamps to share on social media, and more. An event can be as simple or complex as you want. You can have a multi school event from your school or even create your own school event with classes at different schools and share all of it online. This application helps you easily organize your school events and share them to get the word out on your school.</p>      
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form method="GET" action="index.php" class="form-inline col-md-10">
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Activity type</label>
                        </div>
                        <select name="activity" class="custom-select" id="inputGroupSelect01">
                            <option value="all">All</option>
                            <?php foreach($activities as $activity): 
                                $selected = ($activity->id == $selectedActivity) ? 'selected' : ''; ?>
                            <option value="<?php echo $activity->id; ?>" <?php echo $selected; ?>><?php echo $activity->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="sortFilter">Sort</label>
                        </div>
                        <select name="sort" class="custom-select" id="sortFilter">                            
                            <option value="coming" <?php echo ($sort=='coming' ? 'selected' : '') ?>>Coming events</option>
                            <option value="new" <?php echo ($sort=='new' ? 'selected' : '') ?>>New events</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <div class="col-md-2">
                <a href="event.php" class="btn btn-secondary">Create event</a>
            </div>
        </div> <!-- row -->
        <br>
        
        <div class="card mb-4">
            <div class="card-header"><h3><?php echo $title; ?></h3></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mt-2" id="sortable-table">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Activity type</th>
                            <th scope="col">Date time</th>
                            <th scope="col">Distance</th>
                            <th scope="col">Trip duration</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>            
                        </thead>
                        <tbody>
                            <?php foreach($events as $event): ?>
                            <tr>
                                <th scope="row"><a href="event.php?id=<?php echo $event->id; ?>&a=e"> <?php echo $event->name; ?></a></th>
                                <td><?php echo $event->activity_name; ?></td>
                                <td><?php echo date('D, F n, g:ia', strtotime($event->date_time)) ?></td>
                                <td><?php echo number_format($event->distance/1000, 1, '.', '').'km'; ?></td>
                                <td><?php echo ($event->traveling_time < 3600)? number_format($event->traveling_time/60, 0, '', '').'min' : number_format($event->traveling_time/3600, 0, '', '').'Hrs'; ?></td>
                                <td><a href="attendees.php?id=<?php echo $event->id; ?>" class="btn btn-secondary">Attendees</a></td>
                                <td class="d-flex flex-row-reverse bd-highlight">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="event.php" method="post">
                                            <input type="hidden" value="<?php echo $event->id; ?>" name="id">
                                            <input type="hidden" value="d" name="a">
                                            <input type="submit" name="submit" class="btn btn-danger" value="Delete">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- /container -->



<?php include 'inc/footer.php' ?>