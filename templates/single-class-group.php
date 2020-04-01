<?php include 'inc/header.php' ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h3><?php echo $title ?></h3>
        </div>
        <div class="row">
            <form method="post" action="class-group.php" class="col-md-6">
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Name</label>
                        </div>
                        <input type="text" class="form-control" name="class_group_name" value="<?php echo ($class_group)? $class_group->name : ''; ?>">
                    </div>
                </div>
                <input type="hidden" name="a" value="<?php echo ($action)? $action : 'c'; ?>">
                <input type="hidden" name="id" value="<?php echo ($action)? $class_group->id : ''; ?>">
                <input type="submit" class="btn btn-primary" value="Save" name="submit">
                <a href="class-group-list.php" class="btn btn-default">Cancel</a>
            </form>   
        </div> <!-- row -->        

    </div> <!-- /container -->



<?php include 'inc/footer.php' ?>