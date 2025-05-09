<?php
echo "<title>BeatSphere</title>";
include_once('header_footer/header.php');  

include_once('controller/beatsphere.php');  
$controller = new beatsphere(); 
$controller->bastapageni();  

include_once('header_footer/footer.php');  
?>
