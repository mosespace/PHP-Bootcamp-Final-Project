<!-- This file  handles the deletion of the item from the $_SESSION['items'] array. -->
<?php
// start the session
session_start();

// check if the index parameter is set
if (isset($_POST['index'])) {
  // get the index of the item to be deleted
  $index = $_POST['index'];

  // check if the index is valid
  if (isset($_SESSION['items'][$index])) {
    // remove the item from the items array in the session
    unset($_SESSION['items'][$index]);
  }
}
?>