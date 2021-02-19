<?php 



header('Access-Control-Allow-Origin: *');
// echo("hello");


require("credentials.php");

if(isset($_POST["username"], $_POST["comment"], $_POST["comment_workout_id"])){

    $username = $_POST["username"];
    $comment= $_POST["comment"];
    $comment_workout_id = $_POST["comment_workout_id"];



    $sql = "INSERT INTO comments (username, comment, workout_id)
        VALUES ('$username', '$comment', '$comment_workout_id')";

    

    if (mysqli_query($conn, $sql)) {
        echo ("New record created successfully");
    } else {
        echo( "Error: " . $sql . "<br>" . mysqli_error($conn));
    }
    
}

else{echo("no data received");}


?>