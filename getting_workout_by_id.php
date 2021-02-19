<?php

header('Access-Control-Allow-Origin: *');
// echo("hello");

require("credentials.php");

if(isset($_POST["workout_request_id"])){

    $workout_id = $_POST["workout_request_id"];

    $sql = "SELECT * FROM workouts WHERE id = '$workout_id'";
    $result = mysqli_query($conn, $sql);
    

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);


        echo(json_encode($row));
    }else{ 
        echo "0 results";
    
  }
  
} else{
  echo "no id received";
}



?>