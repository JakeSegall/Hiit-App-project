<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("credentials.php");


#Recieved new workout form data from the client and put it in to the database. 

if (isset($_POST["workout_title"], $_POST["workout_description"], $_POST["published_or_private"], $_FILES["workout_thumbnail"], $_POST["exercise_JSON"])){

    $title = $_POST["workout_title"];
    $description = $_POST["workout_description"];
    $status = $_POST["published_or_private"];
    $exercise_json = $_POST["exercise_JSON"];

    $target_dir = "images/";
    $target_file = $target_dir .  date('Y-m-d-H-i-s') .  basename($_FILES["workout_thumbnail"]["name"]);
    // $thumbnail_path = "https://LocalHost/".$target_dir . "/". $_FILES["workout_thumbnail"];
    $uploadOk = 1;
    // var_dump($_FILES["workout_thumbnail"]);
    // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["workout_thumbnail"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        if (move_uploaded_file($_FILES["workout_thumbnail"]["tmp_name"] , $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["workout_thumbnail"]["name"]));
        }
        else{
            echo "file is not copied.";
        }
        
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    $sql = "INSERT INTO workouts (exercise_name, description , published, thumbnail_link, exercises)
        VALUES ('$title', '$description', '$status', '$target_file', '$exercise_json')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    header('Location:  '. $_SERVER["REQUEST_URI"]);

    echo("hello");



// }else{
//     echo("insuffiecient data");
}





if (isset($_POST["edit_title"], $_POST["edit_description"], $_POST["edit_published_or_private"], $_POST["edit_exercise_JSON"], $_POST["edit_workout_id"])){

    $title = $_POST["edit_title"];
    $description = $_POST["edit_description"];
    $status = $_POST["edit_published_or_private"];
    $exercise_json = $_POST["edit_exercise_JSON"];
    $edit_workout_id = $_POST["edit_workout_id"];

    $target_dir = "images/";
    $target_file = $target_dir .  date('Y-m-d-H-i-s') .  basename($_FILES["edit_thumbnail"]["name"]);
    // $thumbnail_path = "https://LocalHost/".$target_dir . "/". $_FILES["workout_thumbnail"];
    $uploadOk = 1;
    // var_dump($_FILES["workout_thumbnail"]);
    // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (is_uploaded_file($_FILES["edit_thumbnail"]["tmp_name"])){
        $check = getimagesize($_FILES["edit_thumbnail"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            if (move_uploaded_file($_FILES["edit_thumbnail"]["tmp_name"] , $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["edit_thumbnail"]["name"]));
            }
            else{
                echo "file is not copied.";
            }
            
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        $sql = "UPDATE workouts SET exercise_name = '$title', description = '$description' , published = '$status', thumbnail_link='$target_file', exercises='$exercise_json' WHERE id='$edit_workout_id'";
    } else{
        $sql = "UPDATE workouts SET exercise_name = '$title', description = '$description' , published = '$status', exercises='$exercise_json' WHERE id='$edit_workout_id'";
    }
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    header('Location:  '. $_SERVER["REQUEST_URI"]);

    echo("hello");



// }else{
//     echo("insuffiecient data");
}



#Creating a variable called sql and then selecting the data from the database called workouts. 
$sql = "SELECT * FROM workouts ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

 // output data of each row
 $workout_array=array();

if (mysqli_num_rows($result) > 0) { 
    while($row = mysqli_fetch_assoc($result)) {
        // echo "id: " . $row["id"]. "  " . $row["thumbnail_link"]. " " . $row["exercise_name"]. " " . $row["description"]. "<br>";
        $workout_array[]=$row;
    }
}








    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="js/jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="server.css">
    <link rel="stylesheet" href="bootstrap_tabs.css">
    <script src="js/server.js"></script>
    <script src="js/bootstrap_tabs.js"></script>
</head>
<body onload="onload()">
    <div class="tab">
    <button class="tablinks" onclick="openCity(event, 'workouts')">workouts</button>
    <button class="tablinks" onclick="openCity(event, 'create')">create workout</button>
    <button class="tablinks" onclick="openCity(event, 'edit')">edit workout</button>
  
    </div>

    

    <!-- Tab content -->
    <div id="create" class="tabcontent">
        <h3>Create workout</h3>
        <form enctype="multipart/form-data" action="" class="grid_1" method="post" enctype="multipart/form-data">
            <input placeholder = "Workout title" name="workout_title" type="text">
            <textarea name="workout_description"  cols="30" rows="10"></textarea>
            <input placeholder = "workout file" name="workout_thumbnail" type="file">
            <h3>Exercise List</h3>
            <input type="hidden" id="exercise_string" name="exercise_JSON">
            <input type="button" value ="Add exercise" onclick="create_div('exercise_list')" > 
            <div  id = "exercise_list">
                 <div class = "single_exercise_input"> <input placeholder = "Exercise Name" onkeypress = "exercise_list_change()" type ="text" > <input placeholder = "amount/duration" onkeypress= "exercise_list_change()" type ="text"> <input type = "button"  value="delete" onclick="delete_1(this)"></div> 
            </div>
            <select name="published_or_private" >
                <option  value="1">published</option>
                <option  value="0">private</option>
            </select>
            <input type="submit">
        </form>
    </div>



    <div id="edit" class="tabcontent">
        <h3>Edit workout</h3>
        <select onchange="fetch_workout_data(this)">
            <option disabled selected>select workout to edit</option>
        
            <?php foreach($workout_array as $each_workout)  { ?>
                 <option value = "<?php echo($each_workout["id"]) ?>" class = "edit_workout"> <?php echo($each_workout["exercise_name"]) ?></option>
                 <?php } ?>
        </select>
        <form enctype="multipart/form-data" action="" class="grid_1" method="post" enctype="multipart/form-data">
            <input value = "" placeholder = "Workout title" name="edit_title" id = "workout_title" type="text">
            <textarea name="edit_description" id="edit_description" cols="30" rows="10"></textarea>

            <h3>Exercise List</h3>
            <input type="hidden" id="exercise_string_edit" name="edit_exercise_JSON">
            <input type="button" value ="Add exercise" onclick="create_div('exercise_list_edit')" > 
            <div  id = "exercise_list_edit">
                <!-- <div class = "single_exercise_input"> <input placeholder = "Exercise Name" onkeypress = "exercise_list_change()" type ="text" > <input placeholder = "amount/duration" onkeypress= "exercise_list_change()" type ="text"> <input type = "button"  value="delete" onclick="delete_1(this)"></div> -->
            </div>

            <select name="edit_published_or_private" id="published_or_private">
                <option  value="1">published</option>
                <option  value="0">private</option>
            </select>
            <input name="edit_thumbnail" id="edit_thumbnail" type="file">
            <img id ="edit_workout_image" src= "">  
            <input type="submit">
            <input value = "" type="hidden" id="hidden_id" name = "edit_workout_id"> 
        </form>
    </div>

    

    <div id="workouts" class="tabcontent">
    <h3>All workouts</h3>
        <div class = "workout_list">
            <?php foreach($workout_array as $each_workout)  { ?>
                <div class = "workout_box">
                   <div class = "workout_title"> <?php echo($each_workout["exercise_name"]) ?> </div>
                   <div class = "workout_description"> <?php echo($each_workout["description"]) ?> </div>
                   <img src = "<?php echo($each_workout["thumbnail_link"]) ?>"> 
                </div>
            <?php } ?>

        </div>
    </div>

    
 
    
    
</body>
</html>
