//Mallika Rana//
//2408240//

const defaultCityName="Dehri"
window.addEventListener("load",()=>defaultCity(defaultCityName))
//For default city
async function defaultCity(city){
    try{
        //Fetching data as per the city name
        const response=await fetch(`http://localhost/weather%20app/Mallika_Rana_2408240.php?q=${city}`);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data=await response.json();
        console.log(data);
        
        document.querySelector("#cityName").innerHTML=data.name;
        document.querySelector("#image").src=`http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
         /**To round up the temperture we use Math.round()**/
        document.querySelector(".temperature").innerHTML=Math.round(data.main.temp)+" °C";
        document.querySelector(".condition").innerHTML=data.weather[0].description;
        document.querySelector(".pressure").innerHTML=data.main.pressure+"Pa";
        document.querySelector(".windSpeed").innerHTML=data.wind.speed+"m/s";
        document.querySelector(".humidity").innerHTML=data.main.humidity+"%";
        
        //Get local date and date
        timestampOffset=data.timezone;
        const currentDate=new Date()
        //for time zone
        const timestamp=Math.floor(currentDate.getTime()/1000)+timestampOffset;
        const convertedDate=new Date(timestamp*1000);

        const localDateTime=convertedDate.toLocaleString('en-us',{
            day:'numeric',
            month:'short',
            year:'numeric',
            timezone:'UTC'
        });
        document.querySelector("#date").innerHTML=localDateTime;

    }catch(error){
        document.querySelector(".error").style.display="grid";
        document.querySelector("#weatherCondition").style.display="none";
    }
}

async function weatherPastData(){
    const response=await fetch(`http://localhost/weather%20app/Mallika_Rana_2408240.php?pastData=true`);
    const data=await response.json();
    console.log(data);
    //const dataJsonString = await response.text();
    //const data = JSON.parse(dataJsonString);

    let table=document.querySelector("#WeatherData");
    let tbody=table.querySelector("#weatherInfo");

    var k=0;
    for(let i=0;i<data.length-1;i++){
        let row=tbody.insertRow(k);
        let cell1=row.insertCell(0);
        let cell2=row.insertCell(1);
        let cell3=row.insertCell(2);
        let cell4=row.insertCell(3);
        let cell5=row.insertCell(4);
        let cell6=row.insertCell(5);
        let cell7=row.insertCell(6);

        cell1.innerHTML=data[i].Day_and_Date;
        cell2.innerHTML=data[i].Day_of_week;
        cell3.innerHTML=`<img src="https://openweathermap.org/img/w/${data[i].Weather_Icon}.png" height="40px" >`;
        cell4.innerHTML=Math.round(data[i].Temperature)+" °C";
        cell5.innerHTML=data[i].Pressure+"Pa";
        cell6.innerHTML=data[i].Wind_Speed+"m/s";
        cell7.innerHTML=data[i].Humidity+"%";
    }
}
weatherPastData()
//Calling the function defaultCityName
defaultCity(defaultCityName)

const searchBox=document.querySelector(".searchEngine input");
const searchButton=document.querySelector(".searchEngine button");

//To fetch the data for input city
async function checkWeather(cityName){
    const response=await fetch(`http://localhost/weather%20app/Mallika_Rana_2408240.php?q=${cityName}`);

    if(response.status==404){
        document.querySelector(".error").style.display="block";
        document.querySelector("#weatherCondition").style.display="none";
        
    }else{
        document.querySelector(".error").style.display="none";
        document.querySelector("#weatherCondition").style.display="block";
        const data=await response.json();

        console.log(data);

        document.querySelector("#cityName").innerHTML=data.name;
        document.querySelector("#image").src=`http://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
         /**To round up the temperture we use Math.round()**/
        document.getElementsByClassName("temperature")[0].innerHTML=Math.round(data.main.temp)+" °C";
        document.querySelector(".condition").innerHTML=data.weather[0].description;
        document.querySelector(".pressure").innerHTML=data.main.pressure+"Pa";
        document.querySelector(".windSpeed").innerHTML=data.wind.speed+"m/s";
        document.querySelector(".humidity").innerHTML=data.main.humidity+"%";

        document.querySelector(".error").style.display="none";

        //Get local date and date
        timestampOffset=data.timezone;
        const currentDate=new Date()
        //for time zone
        const timestamp=Math.floor(currentDate.getTime()/1000)+timestampOffset;
        const convertedDate=new Date(timestamp*1000);

        const localDateTime=convertedDate.toLocaleString('en-us',{
            day:'numeric',
            month:'short',
            year:'numeric',
            timezone:'UTC'
        });
        document.querySelector("#date").innerHTML=localDateTime;

        document.querySelector("#WeatherData").style.display="none";
    }
}

searchButton.addEventListener("click",()=>{
    checkWeather(searchBox.value);
})

searchBox.addEventListener("keypress",(event)=>{
    if (event.key==="Enter");
    checkWeather(searchBox.value);
})
