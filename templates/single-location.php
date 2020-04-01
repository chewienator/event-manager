<?php include 'inc/header.php' ?>   
        
        <div class="d-flex justify-content-between">
            <h3><?php echo $title ?></h3>
        </div>
        
        <div class="row">
            <div class="col-6">
                <div id="map"></div>
            </div>
            <div class="col-6">
                <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Location Search</label>
                            </div>
                            <input type="text" id="pac-input" class="form-control">
                        </div>
                </div>
                <form method="post" action="location.php">
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Name</label>
                            </div>
                            <input type="text" id="place_name" class="form-control" name="location_name" value="<?php echo ($location)? $location->name : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Latitude</label>
                            </div>
                            <input type="text" id="place_lat" class="form-control" name="latitude" value="<?php echo ($location)? $location->latitude : ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group mr-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Longitude</label>
                            </div>
                            <input type="text" id="place_long" class="form-control" name="longitude" value="<?php echo ($location)? $location->longitude : ''; ?>" readonly>
                        </div>
                    </div>
                    <input type="hidden" name="a" value="<?php echo ($action)? $action : 'c'; ?>">
                    <input type="hidden" name="id" value="<?php echo ($action)? $location->id : ''; ?>">
                    <input type="submit" class="btn btn-primary" value="Save" name="submit"><a href="location-list.php" class="btn btn-default">Cancel</a>
                </form>    

            </div>
        </div> <!-- row -->
                
        <!-- Google maps info card -->
        <div id="infowindow-content">
            <img src="" width="16" height="16" id="place-icon">
            <span id="place-name"  class="title"></span><br>
            <span id="place-address"></span>
        </div>
        <!-- /Google maps info card -->

    <script src="js/googlemaps.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHqmFIeMEYvAqiV1KdQx7gD98HS7ne97w&libraries=places&callback=initMap" async defer></script>
    
        <?php 
        //If we are editing include this call (would have preferred to do more JS)
        if($action == 'e'): ?>
        <script>
            (function() {
                setTimeout(function(){
                    loadLocation(<?php echo $location->latitude.','.$location->longitude; ?>)
                }, 3000);                
            })();
        </script>
        <?php endif; ?>

<?php include 'inc/footer.php' ?>