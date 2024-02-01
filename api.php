<?php
//Mallika Rana
//2408240

function fetch_current_data($city){
    try{
        //fetching data
        $url='https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid=1aa348ac52921f53d4d3395ee76f3bed&units=metric';
        //Read a file into string
        $dataString=file_get_contents($url);
        //decode a JSON object to php object 
        $data=json_decode($dataString,true);
        return $data;
    }catch(Exception $th){
        echo "error".$th->getMessage();
    }
}
?>