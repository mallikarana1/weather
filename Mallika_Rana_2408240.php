<?php
//Mallika Rana
//2408240

include("database.php");
include("api.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type:application/json");

$dbHost="localhost";
$dbUname="root";
$dbPassword="";
$mysqli=connectDatabase($dbHost,$dbUname,$dbPassword);
$database=createDatabase($dbHost,$dbUname,$dbPassword);
createTable($dbHost,$dbUname,$dbPassword);

//Check if city parameter is set in the URL query
if (isset($_GET["q"])){
    $city=$_GET["q"];
    $result=fetch_current_data($city);
    //var_dump($result);
    $dates=date('Y-m-d',$result['dt']);
    $day=date('l',$result['dt']);
    $weather_condition=$result['weather'][0]['description'];
    $weather_icon=$result['weather'][0]['icon'];
    $temperature=$result['main']['temp'];
    $pressure=$result['main']['pressure'];
    $wind_speed=$result['wind']['speed'];
    $humidity=$result['main']['humidity'];
}else{
    return null;
    // echo '{"error":"No city provided!"}';
}
 //inserting data
insertWeatherData($mysqli,$database,$dates, $day,$weather_condition,$weather_icon,$temperature,$pressure,$wind_speed,$humidity);

// Display data from the database
$jsonData = displayDatabase($dbHost, $dbUname, $dbPassword,$database, $result,$dates);
echo $jsonData;

if (isset($_GET["pastData"])) {
    $mysqli= new mysqli($dbHost, $dbUname, $dbPassword, $database);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $query = "SELECT * FROM weatherdata";
    $dataResult = mysqli_query($mysqli, $query);

    if ($dataResult === false) {
        die("Error executing query: " . mysqli_error($mysqli));
    }

    // Convert the result to an associative array
    $data = [];
    while ($row = mysqli_fetch_assoc($dataResult)) {
        $data[] = $row;
    }

    if (!empty($data)) {
        // Print or use the data as needed
        $Jdata = json_encode($data);
        var_dump($Jdata);
    }

    // Close the database connection
    mysqli_close($mysqlii);
}

?>