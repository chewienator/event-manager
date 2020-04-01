<?php include 'inc/header.php' ?>

    <div class="container-fluid mt-4">        
        <div class="card mb-4">
            <div class="card-header"><h3>Activities</h3></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mt-2" id="sortable-table">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col"></th>
                            </tr>            
                        </thead>
                        <tbody>
                            <?php foreach($activities as $activity): ?>
                            <tr>
                                <th scope="row"><a href="activity.php?id=<?php echo $activity->id; ?>&a=e"> <?php echo $activity->name; ?></a></th>
                                <td class="d-flex flex-row-reverse bd-highlight">
                                    <form action="activity.php" method="post">
                                        <input type="hidden" value="<?php echo $activity->id; ?>" name="id">
                                        <input type="hidden" value="d" name="a">
                                        <input type="submit" name="submit" class="btn btn-danger" value="Delete">
                                    </form>
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