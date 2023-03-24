<?php
// Here i create an empty array to store items
// After, i start the session;
session_start();

// initialize the items array in the session if it doesn't already exist
if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['input-box'];
    if (empty($name)) {
        echo '<script>alert("Field can not be empty!")</script>';
    } else {
        // add the new item to the items array in the session
        $_SESSION['items'][] = $name;
    }
}

// if (isset($_POST['delete'])) {
//     // remove the item at the specified index from the items array in the session
//     $index = $_POST['delete'];
//     unset($_SESSION['items'][$index]);
//     // re-index the items array to remove any gaps in the indices
//     $_SESSION['items'] = array_values($_SESSION['items']);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do | List</title>
    <link rel="stylesheet" href="./style.css">
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
                foreach ($_SESSION['items'] as $item) {
                    echo "<li>$item</li>";
                }
                // loop through the items array in the session and display each item as a list item with a "Delete" button
                // foreach ($_SESSION['items'] as $index => $item) {
                //     echo "<li>$item<button class=\"delete-button\" name=\"delete\" value=\"$index\">Delete</button></li>";
                ?>
                    </ul>
                    
                    <!-- <button onclick="addTask()">Remove Checked</button> -->
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
    </script>
</body>
</html>