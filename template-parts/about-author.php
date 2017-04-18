<?php
$id = get_the_author_meta('ID');
$practice_type = get_the_author_meta('practice_type');
$dental_school = get_the_author_meta('dental_school');
$degree = get_the_author_meta('degree');
$dental_school_graduation_year = get_the_author_meta('dental_school_graduation_year');
$email = get_the_author_meta('email');
$website_url = get_the_author_meta('url');
$address = get_the_author_meta('bs_address');
$city = get_the_author_meta('bs_city');
$state = get_the_author_meta('bs_state');
$zip = get_the_author_meta('bs_zip');
$phone = get_the_author_meta('phone');
$fax = get_the_author_meta('fax');
$open = [];
$close = [];
for ($i = 1; $i <= 7; $i++) {
    $open[] = get_the_author_meta($i . '_day_open');
    $close[] = get_the_author_meta($i . '_day_close');
}
?>

<div class="about-the-author-wrap">
    <div class="row">
        <div class="author-image">
            <?php echo get_avatar($id, 200); ?>
        </div>
        <div class="author-info">
            <br/>
            <strong>Active Specialty: </strong><?php echo $practice_type; ?><br/><br/>
            <strong>School:</strong> <?php echo $dental_school; ?><br/><br/>
            <strong>Degree:</strong> <?php echo $degree; ?><br/><br/>
            <strong>Year:</strong> <?php echo $dental_school_graduation_year; ?><br/><br/>
            <strong>Email:</strong> <?php echo $email; ?><br/><br/>
            <?php if (isset($website_url) && !empty($website_url)) { ?>
                <strong>Website:</strong> <a href="<?php echo $website_url; ?>"><?php echo $website_url; ?></a> <br/>
                <br/>
            <?php } ?>
            <h2>Primary Location</h2>
            <?php echo $address; ?><br/>
            <?php echo $city; ?>, <?php echo $state; ?>, <?php echo $zip; ?><br/><br/>
            <?php if (isset($phone) && !empty($phone)) { ?>
                <strong>Phone:</strong> <?php echo $phone; ?><br/><br/>
            <?php } ?>
            <?php if (isset($fax) && !empty($fax)) { ?>
                <strong>Fax:</strong> <?php echo $fax; ?><br/><br/>
            <?php } ?>
            <h2>Office Hours</h2>
            <?php for ($i = 0; $i < count($open); $i++) {
                if(!empty($open[$i]) && !empty($close[$i])) {
                    switch ($i) {
                        case 0:
                            echo "Sunday";
                            break;
                        case 1:
                            echo "Monday";
                            break;
                        case 2:
                            echo "Tuesday";
                            break;
                        case 3:
                            echo "Wednsday";
                            break;
                        case 4:
                            echo "Thursday";
                            break;
                        case 5:
                            echo "Friday";
                            break;
                        case 6:
                            echo "Saturday";
                            break;
                    }
                    echo ' ' . $open[$i] . ' am - ' . $close[$i] . ' pm<br/>';
                }
                ?>
            <?php } ?>
            <br/>
        </div>
        <div id="map"></div>
        <h4><a href="" id="map-link">Get Directions</a></h4>
        <style>
            #map {
                height: 400px;
                width: 100%;
            }
        </style>
        <script>
            function initMap() {
                var lat, lng;
                $.ajax({
                    url: "https://maps.googleapis.com/maps/api/geocode/json?address=<?php echo $address; ?>,<?php echo $city; ?>,<?php echo $state; ?>&key=AIzaSyA3TI_6H074rSCoNpcDVqGBoYh9wB_zm4s",
                    async: false,
                    success: function (data) {
                        var location = data.results[0].geometry.location;
                        lat = location.lat;
                        lng = location.lng;
                        $('#map-link').attr('href', 'https://www.google.com/maps?saddr=My+Location&daddr=' + lat + "," + lng);
                    }
                });
                var uluru = {lat: lat, lng: lng};
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 16,
                    center: uluru
                });
                var marker = new google.maps.Marker({
                    position: uluru,
                    map: map
                });
            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3TI_6H074rSCoNpcDVqGBoYh9wB_zm4s&callback=initMap">
        </script>
    </div>
</div>
