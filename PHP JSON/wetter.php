<?php

$wetter = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=Freiburg,de&appid=6650e7b05cddd4d2358dd76a24ad7103&lang=de");

$wetter = json_decode($wetter);

foreach ($wetter->weather as $item){
    echo "In ".$wetter->name . " ist es zurzeit " . $item->description;
}