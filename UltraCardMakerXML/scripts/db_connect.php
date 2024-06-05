<?php

$conn = mysqli_connect('localhost', 'Alter', 'Geist', 'ultracardmaker');

if(!$conn){
    echo "Connection error: " . mysqli_connect_error($conn);
}

?>