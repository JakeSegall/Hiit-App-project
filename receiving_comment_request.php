<?php 


header('Access-Control-Allow-Origin: *');
// echo("hello");


require("credentials.php");

if(isset($_POST["workout_request_id"])){
    
    $workout_id= $_POST["workout_request_id"];
  
  
    $sql = "SELECT username, comment, date FROM comments WHERE workout_id = '$workout_id' ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) { 
      $comment_array=array();
      while($row = mysqli_fetch_assoc($result)) {
        $comment_array[]=$row;
      }
      echo(json_encode($comment_array));
    } else {
      echo "0 results";
    }
  
    mysqli_close($conn);
  
  }
  else{
    echo "did not run";
  };



?>