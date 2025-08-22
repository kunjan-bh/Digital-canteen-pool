
<?php
    
    include ('../includes/dbconn.php');
    $feed_id = $_GET['feedId'];
    $delete = "delete from feedback where id = '$feed_id'";
    $result = mysqli_query($dbconn, $delete);
    header("Location: allFeedback.php");
?>