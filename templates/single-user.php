<?php include 'inc/header.php' ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h3><?php echo $title ?></h3>
        </div>
        <div class="row">
            <form method="post" action="user.php" class="col-md-6">
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">First Name</label>
                        </div>
                        <input type="text" class="form-control" name="first_name" value="<?php echo ($user)? $user->first_name : ''; ?>">
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Last Name</label>
                        </div>
                        <input type="text" class="form-control" name="last_name" value="<?php echo ($user)? $user->last_name : ''; ?>">
                    </div>
                </div>                
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Email</label>
                        </div>
                        <input type="email" class="form-control" name="email" value="<?php echo ($user)? $user->email : ''; ?>">
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Mobile</label>
                        </div>
                        <input type="text" class="form-control" name="mobile" value="<?php echo ($user)? $user->mobile : ''; ?>">
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">User Type</label>
                        </div>
                        <select name="user_type" class="custom-select form-control">
                            <option value="0">Choose user type</option>
                            <?php foreach($user_types as $user_type): 
                                $selected = ($user_type->id == $user->user_type) ? 'selected' : ''; ?>
                            <option value="<?php echo $user_type->id; ?>" <?php echo $selected; ?>><?php echo $user_type->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mr-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text">Class Group</label>
                        </div>
                        <select name="group_id" class="custom-select form-control">
                            <option value="0">Choose class group</option>
                            <?php foreach($groups as $group): 
                                $selected = ($group->id == $user->group_id) ? 'selected' : ''; ?>
                            <option value="<?php echo $group->id; ?>" <?php echo $selected; ?>><?php echo $group->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="a" value="<?php echo ($action)? $action : 'c'; ?>">
                <input type="hidden" name="id" value="<?php echo ($action)? $user->id : ''; ?>">
                <input type="submit" class="btn btn-primary" value="Save" name="submit"><a href="user-list.php" class="btn btn-default">Cancel</a>
            </form>   
        </div> <!-- row -->        

    </div> <!-- /container -->



<?php include 'inc/footer.php' ?>