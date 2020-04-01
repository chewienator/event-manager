<?php include 'inc/header.php' ?>


    <div class="container-fluid mt-4">        
        <div class="card mb-4">
            <div class="card-header"><h3>Class Groups</h3></div>
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
                            <?php foreach($class_groups as $group): ?>
                            <tr>
                                <th scope="row"><a href="class-group.php?id=<?php echo $group->id; ?>&a=e"> <?php echo $group->name; ?></a></th>
                                <td class="d-flex flex-row-reverse bd-highlight">
                                    <form action="class-group.php" method="post">
                                        <input type="hidden" value="<?php echo $group->id; ?>" name="id">
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