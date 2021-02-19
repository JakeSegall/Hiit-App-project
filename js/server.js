function onload(){
    openCity(event, "workouts")
}

function create_div(destination){
    
    var function_to_run = "exercise_list_change()";
    var delete_function = "delete_1(this)";
    if (destination == "exercise_list_edit"){
        function_to_run = "exercise_edit_list_change()";
        delete_function = "delete_2(this)"
        
    }

    var div = document.createElement("div");
    div.classList.add("single_exercise_input");

    var input =  document.createElement("input");
    input.placeholder = "exercise_name";
    input.type = "text";
    input.setAttribute("onkeyup", function_to_run);
    div.appendChild(input);

    var input_1 =  document.createElement("input");
    input_1.placeholder = "amount/duration";
    input_1.type = "text";
    input_1.setAttribute("onkeyup", function_to_run);
    div.appendChild(input_1);

    var input_2 =  document.createElement("input");
    input_2.value = "delete";
    input_2.type = "button"
    input_2.setAttribute("onclick", delete_function);

    div.appendChild(input_2);
 

       
 
    
    document.getElementById(destination).appendChild(div)

    return div
}

function delete_1(delete_button){
    delete_button.parentElement.remove()
    exercise_list_change()
}

function delete_2(delete_button){
    delete_button.parentElement.remove()
    exercise_edit_list_change()
}




function exercise_list_change(){
   var exercise_data = []
   var exercise_array = document.getElementById("exercise_list").children
   for(i=0; i < exercise_array.length; i++){
       var single_exercise = {
           "exercise_name":exercise_array[i].children[0].value,
           "amount_duration":exercise_array[i].children[1].value
       }
       exercise_data.push(single_exercise)
   }
   document.getElementById("exercise_string").value= JSON.stringify(exercise_data)

    
}

function exercise_edit_list_change(){
    var exercise_data = []
    var exercise_array = document.getElementById("exercise_list_edit").children
    for(i=0; i < exercise_array.length; i++){
        var single_exercise = {
            "exercise_name":exercise_array[i].children[0].value,
            "amount_duration":exercise_array[i].children[1].value
        }
        exercise_data.push(single_exercise)
    }
    document.getElementById("exercise_string_edit").value= JSON.stringify(exercise_data)
 
     
 }
 
function fetch_workout_data(project_select){
   var edit_workout_id = project_select.value
   $.post("workout_data.php", {workout_id: edit_workout_id}, function(data, status){
       console.log(data)
       var workout_json = JSON.parse(data)
       console.log(workout_json)
       document.getElementById("workout_title").value =  workout_json[0]["exercise_name"]
       document.getElementById("edit_description").value =  workout_json[0]["description"]
       document.getElementById("published_or_private").value =  workout_json[0]["published"]
       document.getElementById("edit_workout_image").src =  workout_json[0]["thumbnail_link"]
       document.getElementById("hidden_id").value =  workout_json[0]["id"]
       document.getElementById("exercise_string_edit").value =  workout_json[0]["exercises"]

       var exercise_array = JSON.parse(workout_json[0]["exercises"])
       console.log(exercise_array)

       document.getElementById("exercise_list_edit").innerHTML = ""

       for(var i=0; i < exercise_array.length; i++){
           var new_exercise_div = create_div("exercise_list_edit");
           new_exercise_div.children[0].value = exercise_array[i]["exercise_name"]
           new_exercise_div.children[1].value = exercise_array[i]["amount_duration"]

        
       }
   })
}



