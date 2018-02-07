<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
         <script src="validation.js"></script> 
    <title>
        Add Album
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
            $sql = "SELECT cdTitle, artID, cdPrice, cdGenre, cdNumTracks FROM cd WHERE cdID = '".$_GET['id']."'";
            $stmt = $conn->query($sql);
            $row = $stmt->fetch_assoc();
            
            $name = $row['cdTitle'];
            $price = $row['cdPrice'];
            $genre = $row['cdGenre'];
            $tracks = $row['cdNumTracks'];
            $artid = $row['artID'];
             
        }else{
            $name = "";
            $price = "";
            $genre = "";
            $tracks = "";
        }
    ?>
        <table class="add">
      <th colspan="2" align="center">Add Album</th>
      <form method="post" action="" onsubmit="return validateAlbum(this)" onchange="return validateAlbum(this)">
        <tr><td>Album Name</td>
            <td><input class="addin" type="text" maxlength="255" id="Name" value="<?php echo $name ?>" onchange="return validateName(value)" onkeyup="return validateName(value)" name="addName"></td>
        </tr>  
        <tr><td>Artist</td>
            <td><select name="artist">
                <?php 
                if($artid != ""){
                    $sql = "SELECT * FROM artist WHERE artID = '$artid'";
                    $stmt = $conn->query($sql);
                    $row = $stmt->fetch_assoc();
                    
                    $artID1 = $row['artID'];
                    echo "<option value=\"$artID\">" . $row['artName'] . "</option>";
                    
                }else{
                    $artID1 = 0;
                }
                $sql = "SELECT * FROM artist ORDER BY artID ASC";
                $stmt = $conn->query($sql);
                 
                while ($row = $stmt->fetch_assoc()){
                    $artID = $row['artID'];
                    if($artID != $artID1)
                        echo "<option value=\"$artID\">" . $row['artName'] . "</option>";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr><td>Price</td>
            <td><input class="addin" type="text" maxlength="6" id="Price" value="<?php echo $price ?>" onchange="return validatePrice(value)" onkeyup="return validatePrice(value)" name="addPrice"></td>
        </tr>
        <tr><td>Genre</td>
            <td><input class="addin" type="text" maxlength="20" id="Genre" value="<?php echo $genre ?>" onchange="return validateGenre(value)" onkeyup="return validateGenre(value)" name="addGenre"></td>
        </tr>
        <tr><td>Tracks</td>
            <td><input class="addin" type="text" maxlength="3" id="Tracks" value="<?php echo $tracks?>" onchange="return validateTracks(value)" onkeyup="return validateTracks(value)" name="addTracks"></td>
        </tr>
        <tr><td colspan="5" align="center"><input type="submit" value="Add"></td></tr>  
      </form>
    </table>
      <?php

        if(isset($_POST['addName']) and isset($_POST['addPrice']) and isset($_POST['addGenre']) and isset($_POST['addTracks']) and isset($_POST['artist'])){
            $Name = strip_tags($_POST['addName']);
            $Price = strip_tags($_POST['addPrice']);
            $Genre = strip_tags($_POST['addGenre']);
            $Tracks = strip_tags($_POST['addTracks']);
            $Artid = strip_tags($_POST['artist']);
            
            if($_GET['action'] == 'add'){
                $sql = "INSERT INTO cd (cdID, artID, cdTitle, cdPrice, cdGenre, cdNumTracks) VALUES (NULL, '$Artid', '$Name', '$Price', '$Genre', '$Tracks');";   
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                }else {
                    echo "Error: Entry not added " . $conn->error;
                }                          
            }else if($_GET['action'] == 'update'){
                $err = "";
                $CDid = strip_tags($_GET['id']);
                
                if($artid != $Artid){
                    $sql = "UPDATE cd SET artID = $Artid WHERE cdID = $CDid;";
                    if($conn->query($sql))
                        $err += " Artist error";
                }
                if($name != $Name){
                    $sql = "UPDATE cd SET cdTitle = '$Name' WHERE cdID = $CDid;";
                    if($conn->query($sql))
                        $err += " Name error";
                }
                if($price != $Price){
                    $sql = "UPDATE cd SET cdPrice = $Price WHERE cdID = $CDid;";
                    if(!$conn->query($sql))
                        $err += " Price error";
                }
                if($genre != $Genre){
                    $sql = "UPDATE cd SET cdGenre = '$Genre' WHERE cdID = $CDid;";
                    if(!$conn->query($sql))
                        $err += " Genre error";
                }
                if($tracks != $Tracks){
                    $sql = "UPDATE cd SET cdNumTracks = $Tracks WHERE cdID = $CDid;";
                    if(!$conn->query($sql))
                        $err += "Tracks error";
                }
                
                if ($err == "") {
                    echo "Record updated successfully";
                    header("Location: Albums.php");
                }else {
                    echo "Error: Entry not updated " . $conn->error;
                }    
            }
            
        }
        ?>
    
    </div>
  </body>
</html>
