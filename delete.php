<?php
include 'db.php';

if(($_GET['action'] == 'delete') && isset($_GET['id'])) {
    $sql = "DELETE FROM track WHERE trackID = '".$_GET['id']."'";
    $stmt = $conn->query($sql);
    if($stmt) {

        echo "Track deleted! ".$_GET['id']. ".";

    }else{
        echo "Not deleted...";
    }

}

?>