<?php

//Get the base-64 string from data
$filteredData = substr($_POST['img_value'], strpos($_POST['img_value'], ",") + 1);

//Decode the string
$unencodedData = base64_decode($filteredData);

//Save the image
$filename = md5($_SERVER['REMOTE_ADDR'] . rand()) . '.png';
$folder = 'uploads/';
file_put_contents($folder . $filename, $unencodedData);

//TODO: Implement Facebook Group Posting
