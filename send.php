<?php

// Start a PHP session
session_start();

// Check if a session variable called 'items' is not set
if (!isset($_SESSION['items'])) {
    // If it's not set, initialize it as an empty array
    $_SESSION['items'] = array();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the value of the 'input-box' field from the POST request
    $name = $_POST['input-box'];

    // Check if the 'input-box' field is empty
    if (empty($name)) {
        // If it's empty, display an alert message using JavaScript
        echo '<script>alert("Field can not be empty!")</script>';
    } else {
        // If it's not empty, add its value to the 'items' array in the session
        $_SESSION['items'][] = $name;
    }
    // In summary, this code starts a session and initializes a session variable called 'items' as an empty array if it's not already set. It checks if the request method is POST and gets the value of a form input field called 'input-box'. If the field is empty, it displays an alert message. Otherwise, it adds the field value to the 'items' array in the session.
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
                        // Here i create a new `ul` element using the `DOMElement` class
                        $newUl = new DOMElement('ul');

                        // Here i loop through each item in the 'items' array stored in the session variable
                        foreach ($_SESSION['items'] as $index => $item) {
                            // For each item, i created a new `li` element with an id of `item-$index` and the item as its text content!
                            // Also i added a `span` element with a class of `close` and an `onclick` attribute that calls a `removeTask` function with the current index as its argument.
                            echo "<li id='item-$index'>$item<span class=\"close\" onclick='removeTask($index)'>&times;</span></li>";
                        }

                        // In summary, the code creates a new unordered list (ul) element and populates it with a list of items stored in the $_SESSION['items'] array. For each item in the array, a new list item (li) element is created with a unique id attribute and a "close" button (span) that calls a removeTask() function when clicked.
                ?>


                // Inline css style! 
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