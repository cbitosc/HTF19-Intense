<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"test");

// Check connection
if (!$conn) {
    die("Connection failed: " .mysqli_connect_error());
}
//echo "Connected successfully";

$sql = "SELECT REGION,DISTRICT,STATE FROM POWERDB GROUP BY REGION HAVING COUNT(*) >= 1";
//$sql = "SELECT REGION,DISTRICT,STATE FROM POWERDB WHERE REGION = 'LB Nagar'";
$rows = mysqli_query($conn,$sql);

$latis = array();
$longis = array();
$areas = array();

while($row = mysqli_fetch_assoc($rows))
{
    $str = "{$row['REGION']}, {$row['DISTRICT']}, {$row['STATE']}, India";
    $box = geocode($str);
    array_push($latis,$box[0]);
    array_push($longis,$box[1]);
    array_push($areas,$row['REGION']);
}

print_r($latis);
print_r($longis);
print_r($areas);

?>

<?php 
// function to geocode address, it will return false if unable to geocode address
function geocode($address){
 
    // url encode the address
    $address = urlencode($address);
     
    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyBNwUWSiCFthbptHkAXd9lBPESiDrJa08I";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
        //echo $lati," ",$longi;
        // verify if data is complete
        if($lati && $longi && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }
 
    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}
?>