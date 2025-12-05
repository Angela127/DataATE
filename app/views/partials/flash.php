<?php
if(isset($_SESSION['flash'])){
    $message=$_SESSION['flash']['message'];
    $type=$_SESSION['flash']['type']; //'success' or 'error'

    //use 'success' class for success, 'danger' (or similar) for error
    $class= ($type === 'success') ? 'success' : 'error' ;

    //Pico.css uses <article> for notices.
    //we'll use a simple div with custom styling for simplicity here.
    echo "<div class='flash-message $class' style='padding: 1rem; margin-bottom: 1rem; border-radius: 5px; color: #fff; background: " . ($class === 'success' ? '#28a745' : '#dc3545') . ";'>";
    echo htmlspecialchars($message);
    echo "</div>";

    //clear the flash message
    unset($_SESSION['flash']);
}

?>