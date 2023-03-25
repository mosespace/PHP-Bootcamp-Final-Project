<?php

session_start();

// initialize the items array in the session if it doesn't already exist
if (!isset($_SESSION['items'])) {  //This checks if the session variable named "items" has been set. If it hasn't been set, it initializes it as an empty array using the assignment statement $_SESSION['items'] = array();.
    $_SESSION['items'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { // This checks if the HTTP request method used by the client to send data to the server is "POST".
    // collect value of input field
    $name = $_POST['input-box']; // This line assigns the value of the input field named "input-box" to the variable $name.
    if (empty($name)) { // This if statement checks if the $name variable is empty.
        echo '<script>alert("Field can not be empty!")</script>';
    } else {
        // add the new item to the items array in the session
        $_SESSION['items'][] = $name;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do | List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <div class="todo-app">
                <h2>To DO | List<img src="./images/icon.png" alt="This is the logo"></h2>
                    <div class="row">
                        <input type="text" name="input-box" placeholder="Add your text">
                            <button onclick="addTask()">Add</button>
                    </div>
                    <ul id="list-container">
                    <?php
                /// Here I Loop through the items array in the session and display each item as a list item
             // create a new ul element
        $newUl = new DOMElement('ul');

        foreach ($_SESSION['items'] as $index => $item) {
            echo "<li id='item-$index'>$item<span class=\"close\" onclick='removeTask($index)'>&times;</span></li>";
        
            // Use PHP to output the value of $index to a JavaScript variable
            //JavaScript code that creates and appends the span element inside the loop that generates the list items, like this:
        }
                // loop through the items array in the session and display each item as a list item with a "Delete" button
                // foreach ($_SESSION['items'] as $index => $item) {
                //     echo "<li>$item<button class=\"delete-button\" name=\"delete\" value=\"$index\">Delete</button></li>";
                ?>
                <style>
                        ul li span.close {
                        position: absolute !important;
                        right: 0;
                        top: 5px;
                        width: 40px;
                        height: 40px;
                        font-size: 22px;
                        color: #555;
                        line-height: 40px;
                        text-align: center;
                        border-radius: 50%;
                    }
                    ul li span.close:hover {
                        background: #edeef0;
                    }
                </style>

                    </ul>
                    
            </div>
    </form>
    </div>
     <script>
        // Get all the list items
        var listItems = document.querySelectorAll("#list-container li");

        // Add an event listener to each list item
        listItems.forEach(function(listItem) {
            listItem.addEventListener("click", function() {
                // Toggle the 'checked' class on the list item
                this.classList.toggle("checked");
            });
        });

        var closeSpan = document.querySelectorAll('.close');

// Loop through each span and add a click event listener
function removeTask(index) {
  var listItem = document.getElementById("item-" + index);
  
  // Check if the list item has the 'checked' class
  if (listItem.classList.contains('checked')) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
      if (xhr.status === 200) {
        // Remove the li element from the list
        listItem.parentNode.removeChild(listItem);
      } else {
        alert('An error occurred while deleting the item.');
      }
    };
    xhr.send("index=" + index);
  } else {
    alert('Item must be checked before it can be removed.');
  }
}




//    // Get all the close spans
// var closeSpan = document.querySelectorAll('.close');

// // Loop through each span and add a click event listener
// closeSpan.forEach(function(span) {
//     span.addEventListener('click', function() {
//         // Get the parent li element of the span
//         var listItem = span.parentNode;

//         // Get the index of the item being deleted
//         var index = Array.prototype.indexOf.call(listItem.parentNode.children, listItem);

//         // Remove the item from the session array
//         if (index > -1) {
        //   { <?php unset($_SESSION['items']['']); ?>;}
//         }

//         // Remove the li element from the list
//         listItem.parentNode.removeChild(listItem);
//     });
// });
// listContainer.addEventListener("click", function(e){
//     if(e.target.tagName === "LI"){
//         e.target.classList.toggle("listItems");
//     }
//     else if(e.target.tagName === "SPAN"){
//         e.tagName.parent.Element.remove();
//     }
// }, false);
    
    </script>
</body>
</html>