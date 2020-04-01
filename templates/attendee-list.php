<?php include 'inc/header.php' ?>

    <div class="container-fluid mt-4">
        
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3>Attendees</h3>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAttendeeModal">
                        Add Attendee
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mt-2" id="sortable-table">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Email</th>
                            <th scope="col">Attending</th>
                            <th scope="col">Confirmed</th>
                            <th scope="col">Attended</th>
                            <th scope="col"></th>
                            </tr>            
                        </thead>
                        <tbody>
                            <?php foreach($attendees as $attendee): ?>
                            <tr>
                                <th scope="row"><?php echo $attendee->last_name.' '.$attendee->first_name; ?></th>
                                <td><?php echo $attendee->mobile; ?></td>
                                <td><?php echo $attendee->email; ?></td>
                                <td><?php echo ($attendee->attending == 1)? 'Yes': 'No'; ?></td>
                                <td><?php echo ($attendee->confirmed == 1)? 'Yes': 'No'; ?></td>
                                <td><?php echo ($attendee->attended == 1)? 'Yes': 'No'; ?></td>
                                <td class="d-flex flex-row-reverse bd-highlight">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="attendees.php?a=attending&id=<?php echo $event->id; ?>&uid=<?php echo $attendee->user_id; ?>&s=<?php echo $attendee->attending; ?>" class="btn btn-secondary">Attending</a>
                                        <a href="attendees.php?a=confirm&id=<?php echo $event->id; ?>&uid=<?php echo $attendee->user_id; ?>&s=<?php echo $attendee->confirmed; ?>" class="btn btn-secondary">Confirmed</a>
                                        <a href="attendees.php?a=attended&id=<?php echo $event->id; ?>&uid=<?php echo $attendee->user_id; ?>&s=<?php echo $attendee->attended; ?>" class="btn btn-secondary">Attended</a>
                                        <a href="attendees.php?a=d&id=<?php echo $event->id; ?>&uid=<?php echo $attendee->user_id; ?>" class="btn btn-danger">Delete</a>                            
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
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="addAttendeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Attendee</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="get" action="attendees.php" id="new_attendee_form">
                <div class="form-group mr-2">
                    <h6>Organiser(s)</h6>
                    <select name="uid" class="selectpicker form-control" data-live-search="true" required>
                        <option>Choose user</option>
                        <?php foreach($users as $user): ?>                        
                        <option value="<?php echo $user->id; ?>"><?php echo $user->last_name .' '.$user->first_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Is organiser</label>
                        </div>
                        <select name="is_organiser" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="a" value="c">
                <input type="hidden" name="id" value="<?php echo $event->id; ?>">
                <button type="submit" class="btn btn-primary">Add Attendee</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>            
        </div>
    </div>
  </div>
</div>

<?php include 'inc/footer.php' ?>