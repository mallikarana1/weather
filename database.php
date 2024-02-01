<?php
//Mallika Rana
//2408240

//Check connection
function connectDatabase($dbHost,$dbUname,$dbPassword){
    $mysqli=null;
    try{
        $mysqli=new mysqli($dbHost,$dbUname,$dbPassword);
        if($mysqli->connect_errno){
            die("Connection failed:".$mysqli->connect_errno);
        }
        return $mysqli;
    }catch(Exception $th){
        return null;
    }
}

//creating database
function createDatabase($dbHost,$dbUname,$dbPassword) {
    $databaseName = "weather";
    $mysqli = mysqli_connect($dbHost, $dbUname, $dbPassword);
    try {
        // Create database
        $sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $databaseName";
        if (!mysqli_query($mysqli, $sqlCreateDatabase)) {
            throw new Exception("Error creating database: " . mysqli_error($mysqli));
        }
        return $databaseName;
        // echo "Database 'weather' created successfully.\n ";
    } catch (Exception $th) {
        // echo "Error: " . $th->getMessage();
    } finally {
        mysqli_close($mysqli);
    }
}

function createTable($dbHost,$dbUname,$dbPassword) {
    $mysqli = mysqli_connect($dbHost, $dbUname, $dbPassword);

    try {
        // Select the weather database
        mysqli_select_db($mysqli, "weather");

        // Create the weatherdata table
        $sqlCreateTable = "CREATE TABLE IF NOT EXISTS weatherdata (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Day_and_Date VARCHAR(15),
            Day_of_week VARCHAR(20),
            Weather_Condition VARCHAR(40),
            Weather_Icon VARCHAR(50),
            Temperature INT(6),
            Pressure INT(6),
            Wind_Speed DECIMAL(5,2),
            Humidity INT(5)    
        )";
        if (!mysqli_query($mysqli, $sqlCreateTable)) {
            throw new Exception("Error creating table: " . mysqli_error($mysqli));
        }
        //echo "Table 'weatherdata' created successfully.\n ";
    } catch (Exception $th) {
        // echo "Error: " . $th->getMessage();
    } finally {
        mysqli_close($mysqli);
    }
}

//function to insert or update data in database/
function insertWeatherData($mysqli,$database,$dates, $day,$weather_condition,$weather_icon,$temperature,$pressure,$wind_speed,$humidity){
    try{
        mysqli_select_db($mysqli, $database);
        $insert_in_sql="INSERT INTO weatherdata (Day_and_Date,Day_of_week,Weather_Condition,Weather_Icon,Temperature,Pressure,Wind_Speed,Humidity)
        VALUES ('$dates', '$day','$weather_condition','$weather_icon','$temperature','$pressure','$wind_speed','$humidity')";
        $mysqli->query($insert_in_sql);
        //echo "Inserted";
    }catch(Exception $th){
        //echo'{"Error":"'.$th->getMessage().'"}';
    }finally{
        mysqli_close($mysqli);
    }
}

// to display data
function displayDatabase($dbHost,$dbUname,$dbPassword,$database,$result,$dates){
    $mysqli=connectDatabase($dbHost,$dbUname,$dbPassword,$database);
    mysqli_select_db($mysqli, $database);
    
    $sql="SELECT * FROM weatherdata WHERE Day_and_Date<'$dates' LIMIT 7";
    $res=$mysqli->query($sql);
    if($res->num_rows>0){
        $all_data=array();
        while($row=$res->fetch_assoc()){
            $all_data[]=$row;
        }
        array_push($all_data,json_encode($result));
        echo json_encode($all_data);
    }else{
        //echo "error";
    }  

    mysqli_close($mysqli);
}


?>
