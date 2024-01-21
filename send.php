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
        echo "<script>alert('Can Not Add An Empty List!')</script>"
        
        ;
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

    <!-- Begining Of Form -------------------------------------------------------------------------! -->
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
            <div class="todo-app">
                <h2>To DO | List<img src="./images/icon.png" alt="This is the logo"></h2>
                    <div class="row">
                        <input type="text" name="input-box" placeholder="Add your text">
                            <button onclick="addTask()">Add</button>
                    </div>

                    <!-- Here i created the Un-Orderd List! -->
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


                <!-- Here I decided to do an Inline css style!  -->
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
                </style> <!-- End of css-------------------------------------------------------------------------! -->
                
            
                    </ul>
<!-- End of Un-Orderd-List--------------------------------------------------------------------------------------------------!  -->
            </div>
    </form> <!-- End of Form-------------------------------------------------------------------------!          -->
    </div>

    <!-- Begin of JS Script -->
     <script>
        // Here is select all list items in the list container
        var listItems = document.querySelectorAll("#list-container li");

        // Here i add a click event listener to each list item
        listItems.forEach(function(listItem) {
            listItem.addEventListener("click", function() {
                // Then here i toggled the 'checked' class on the clicked list item
                this.classList.toggle("checked");
            });
        });

        // And then i selected all elements with the class 'close'
        var closeSpan = document.querySelectorAll('.close');

        // I added a JS Function to remove a task
        function removeTask(index) {
        // Find the list item with the given index
        var listItem = document.getElementById("item-" + index);
        
        // Here am trying to check if the list item has the 'checked' class
        if (listItem.classList.contains('checked')) {
            // I Created a new XMLHttpRequest object
            var xhr = new XMLHttpRequest(); // a JavaScript API to create AJAX requests. Its methods provide the ability to send network requests between the browser and a server. // in simple terms, communicate with servers.
            
            // I set the HTTP method and URL for the request.
            xhr.open("POST", "delete.php");
            // I set the request header
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            // Here i define what to do when the response is received
            xhr.onload = function() {
            if (xhr.status === 200) {
                // If the response is successful, remove the list item from the DOM
                listItem.parentNode.removeChild(listItem);
            } else {
                // If there is an error, display an alert message
                alert('An error occurred while deleting the item.');
            }
            };
            // He i finally send the request with the index of the task to be removed
            xhr.send("index=" + index);
        } else {
            // If the list item is not checked, display an alert message
            alert('Item must be checked before it can be removed.');
        }
        }
            // In summary, this code adds a click event listener to each list item in a container element. When a list item is clicked, it toggles the 'checked' class on that list item. Additionally, there is a function that can be called to remove a task from the list. This function sends a POST request to a PHP file with the index of the task to be removed. If the task is checked, the function removes the corresponding list item from the DOM. Otherwise, it displays an alert message.

    </script>
    <!-- End Of Js Script -->
</body>
</html>