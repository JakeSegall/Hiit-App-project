<?php 

header('Access-Control-Allow-Origin: *');
// echo("hello");


require("credentials.php");

$sql = "SELECT * FROM workouts WHERE published = 1 ORDER BY id desc";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) { 
  // output data of each row
  $workout_array=array();
  while($row = mysqli_fetch_assoc($result)) {
    // echo "id: " . $row["id"]. "  " . $row["thumbnail_link"]. " " . $row["exercise_name"]. " " . $row["description"]. "<br>";
    $workout_array[]=$row;

  }
  echo(json_encode($workout_array));
} else {
  echo "0 results";
}

mysqli_close($conn);

?>
