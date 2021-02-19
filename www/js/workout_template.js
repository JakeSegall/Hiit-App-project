
function description(){ 
   var workout_id=localStorage.getItem("workout_id");
   console.log(workout_id);
   document.getElementById("comment_workout_id").value = workout_id

   $.post("http://hiitapp.jakesegall.net/getting_workout_by_id.php", {workout_request_id:workout_id}, function(data,status){
  
      console.log(data);
      var workout_json = JSON.parse(data);
      console.log(workout_json)
      document.getElementById("image").src = "http://localhost/"+workout_json["thumbnail_link"];
      document.getElementById("workout_title").innerHTML = workout_json["exercise_name"];
      document.getElementById("description").innerHTML = workout_json["description"];
      
      var exercises = JSON.parse(workout_json["exercises"]);
      console.log(exercises)

      for(var i=0; i < exercises.length; i++){
          var new_exercise_div = document.createElement("div");
          new_exercise_div.className = "single_exercise";
          document.getElementById("exercises").appendChild(new_exercise_div);

          var new_exercise_name_div = document.createElement("div");
          new_exercise_name_div.className = "single_exercise_name";
          new_exercise_name_div.innerHTML = exercises[i]["exercise_name"];
          new_exercise_div.appendChild(new_exercise_name_div);

          var new_exercise_duration_div = document.createElement("div");
          new_exercise_duration_div.className = "single_exercise_amount";
          new_exercise_duration_div.innerHTML = exercises[i]["amount_duration"];
          new_exercise_div.appendChild(new_exercise_duration_div);
      } //end of forloop
   })
 }

 function checkConnection() {
  var networkState = navigator.connection.type;

  var states = {};
  states[Connection.UNKNOWN]  = 'Unknown connection';
  states[Connection.ETHERNET] = 'Ethernet connection';
  states[Connection.WIFI]     = 'WiFi connection';
  states[Connection.CELL_2G]  = 'Cell 2G connection';
  states[Connection.CELL_3G]  = 'Cell 3G connection';
  states[Connection.CELL_4G]  = 'Cell 4G connection';
  states[Connection.CELL]     = 'Cell generic connection';
  states[Connection.NONE]     = 'No network connection';

  alert('Connection type: ' + states[networkState]);
}

function body_ready(){
  description();

}

function toggle_chat(){
var workout_id=localStorage.getItem("workout_id");
  document.getElementById("comment_box").style.left = "5%"
  document.getElementById("comment_button").style.opacity = "0"
  $.post("http://hiitapp.jakesegall.net/receiving_comment_request.php", {workout_request_id:workout_id},  function(data,status){
    console.log("response",data);

    var comment_data=JSON.parse(data);
    console.log(comment_data);
    for(var i = 0; i< comment_data.length; i++){

      var single_comment_box = document.createElement("div");
      single_comment_box.className = "single_comment";
      // new_div.innerHTML = comment_data[i]["username"];
      document.getElementById("comment_viewer").appendChild(single_comment_box);

      var comment_header = document.createElement("div");
      comment_header.className = "comment_header";
      single_comment_box.appendChild(comment_header);
      

      var username_container = document.createElement("div")
      username_container.innerHTML = comment_data[i]["username"];
      comment_header.appendChild(username_container);



      var date_container = document.createElement("div")
      date_container.innerHTML = comment_data[i]["date"];
      comment_header.appendChild(date_container);


      var comment_container = document.createElement("div")
      comment_container.innerHTML = comment_data[i]["comment"];
      single_comment_box.appendChild(comment_container);



      
      
    }
    //send a request to a different php page to get the comments. 
    
  })
}

function send_comments(){
  var new_comment_data = $("#comment_form").serializeArray();
  console.log(new_comment_data)
  $.post("http://hiitapp.jakesegall.net/receiving_comments.php", new_comment_data, function(data,status){
    console.log("server_response",data);


  })
}

function toggle_close_chat(){
  document.getElementById("comment_box").style.left = "100%"
  document.getElementById("comment_button").style.opacity = "1"
}


