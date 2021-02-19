function on_page_load(){}
  
function load_workouts(){
    // alert("onload function executed");

        
 
    



    // console.log("this is a test");
    // navigator.notification.alert('Loading LocalHost!',  alertDismissed,'Game Over','Done');
  $.post("http://hiitapp.jakesegall.net/request_workouts.php", function(data, status){
    console.log(data)
    var workouts_data=JSON.parse(data);
    console.log(workouts_data);
    for(var i = 0; i < workouts_data.length; i++){
      // var row = workouts_data[i];

      // clone and set up workout tabloids
      
      var tabloid = document.getElementById("tabloid_template");

      var clone_tabloid = tabloid.cloneNode(true);
      clone_tabloid.style.display="block"

      document.getElementById("tabloid_list").appendChild(clone_tabloid);

    //   window.imagedownloader.download(
    //     workouts_data[i]["thumbnail_link"],
    //     function successFn() {
    //         alert('Image was downloaded');
    //     },
    //     function failureFn() {
    //         alert('Fail to download image');
    //     }
    // );

      // img.src=workouts_data[0]["thumbnail_link"]

      clone_tabloid.children[0].src= "http://localhost/"+workouts_data[i]["thumbnail_link"]

      clone_tabloid.children[1].innerHTML=workouts_data[i]["exercise_name"];

      clone_tabloid.setAttribute("onclick", "open_workout("+workouts_data[i]["id"]+")");
    
      console.log(workouts_data[i]["thumbnail_link"]);


    }
  });
   
}



function open_workout(workout_id){
  localStorage.setItem("workout_id",workout_id)
  window.location.href = "workout_template.html";
  


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

function alertDismissed() {
  // do something
}

document.addEventListener("deviceready", onDeviceReady, false);
function onDeviceReady() {
  // checkConnection();
  load_workouts();
       
  // permissions.hasPermission(permissions.CAMERA, function( status ){
  //   if ( status.hasPermission ) {
  //     console.log("Yes :D ");
  //   }
  //   else {
  //     console.warn("No :( ");
  //   }
  // });
    
  // navigator.notification.alert(
  //   'Hello!',  // message
  //   alertDismissed,         // callback
  //   'Game Over',            // title
  //   'Done'                  // buttonName
    
  // );

}

