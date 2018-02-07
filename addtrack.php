<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
         <script src="validation.js"></script> 
    <title>
        Add Track
        </title>
    </head>
<body>
    <?php
    include 'db.php';                                      //include the database connection
    
    ?>
    <div id= "banner">
        <img id=title src="banner.png">
    </div>
   
    <div id="navbar">
        <ul>
            <li class="button"><a href="index.php">Home</a></li>
            <li class="button"><a href="Artists.php">Artists</a></li>
            <li class="button"><a href="Albums.php?action=cds">Albums</a></li>
            <li class="button"><a href="Tracks.php?action=tracks">Tracks:</a></li>
        </ul>
    </div>
    <div id="centerbox">
    <?php
        if(($_GET['action'] == 'update') && isset($_GET['id'])){                                              
            $sql = "SELECT trackName, duration, cdID FROM track WHERE trackID = '".$_GET['id']."'";
            $stmt = $conn->query($sql);
            $row = $stmt->fetch_assoc();

            $name = $row['trackName'];
            $duration = $row['duration'];
            $cdid = $row['cdID'];
        }else{
            $name = "";
            $duration = "";
            $cdid = "";
        }
    ?>
        <table class="add">
      <th colspan="2" align="center">Add Album</th>
      <form method="post" action="" onsubmit="return validateTrack(this)" onchange="return validateTrack(this)">
        <tr><td>Track Name</td>
            <td><input class="addin" type="text" maxlength="255" id="Name" value="<?php echo $name ?>" onchange="return validateName(value)" onkeyup="return validateName(value)" name="addName"></td>
        </tr>  
        <tr><td>CD</td>
            <td><select name="cd">
                <?php 
                if($cdid != ""){
                    $sql = "SELECT cdID, cdTitle FROM cd WHERE cdID = '$cdid'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch_assoc();
                    
                    $cdID1 = $row['cdID'];
                    echo "<option value=\"$cdID\">" . $row['cdTitle'] . "</option>";
                    
                }else{
                    $cdID1 = -1;
                }
                $sql = "SELECT cdID,cdTitle FROM cd ORDER BY cdID ASC";
                $stmt = $conn->query($sql);
                 
                while ($row = $stmt->fetch_assoc()){
                    $cdID = $row['cdID'];
                    if($cdID != $cdID1)
                        echo "<option value=\"$cdID\">" . $row['cdTitle'] . "</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr><td>Duration</td>
            <td><input class="addin" type="text" maxlength="10" id="Time" value="<?php echo $duration ?>" onchange="return validateDuration(value)" onkeyup="return validateDuration(value)" name="addTime"></td>
        </tr>
        <tr><td colspan="5" align="center"><input type="submit" value="Add"></td></tr>  
      </form>
    </table>
      <?php

        if(isset($_POST['addName']) and isset($_POST['addTime']) and isset($_POST['cd'])){
            $Name = strip_tags($_POST['addName']);
            $Duration = strip_tags($_POST['addTime']);
            $CDid = strip_tags($_POST['cd']);
            $trackid = strip_tags($_GET['id']);
            
            if($_GET['action'] == 'add'){
                $sql = "INSERT INTO track (trackID, trackName, duration, cdID) VALUES (NULL, '$Name', '$Duration', '$CDid');";   
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                    header("Location: Tracks.php");
                }else {
                    echo "Error: Entry not added " . $conn->error;
                }                         
            }else if($_GET['action'] == 'update'){
                $err = "";
                
                if($Name != $name){
                    $sql = "UPDATE track SET trackName ='$Name' WHERE trackID = '$trackid';";
                    if(!$conn->query($sql))
                        $err += "Name error";
                }
                if($Duration != $duration){
                    $sql = "UPDATE track SET duration = '$Duration' WHERE trackID = '$trackid';";
                    if(!$conn->query($sql))
                        $err += "Duration error";
                }
                if($CDid != $cdid){
                    $sql = "UPDATE track SET cdID = '$CDid' WHERE trackID = '$trackid';";
                    if(!$conn->query($sql))
                        $err += "cdID error";
                }   
                if ($err == "") {
                    echo "Record updated successfully";
                    header("Location: Tracks.php");
                }else {
                    echo "Error: Entry not updated " . $conn->error;
                } 
            }
        }
        ?>
    
    </div>
  </body>
</html>