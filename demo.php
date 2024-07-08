<?php
error_reporting(0);
if( $_GET["name"] || $_GET["weight"] )
{
echo "Welcome ". $_GET['name']. "<br />";
echo "You are ". $_GET['weight']. " kgs in weight.";
exit();
}
?>