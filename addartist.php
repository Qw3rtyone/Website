<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
        <script src="validation.js"></script>
    <title>
        Add Artists
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
            $sql = "SELECT artName FROM artist WHERE artID = '".$_GET['id']."'";
            $stmt = $conn->query($sql);
            $row = $stmt->fetch_assoc();
            $name = $row['artName'];
        }else{
            $name = "";
        }
    ?>
        <table class="add">
      <th colspan="2" align="center">Add Artist</th>
      <form method="post" action="" onsubmit="return validateAlbum(this)" onchange="return validateAlbum(this)">
        <tr><td>Artist Name</td>
          <td><input class="addin" type="search" maxlength="200" id="Name" value="<?php echo $name ?>" onkeyup="return validateName(value)" name="search"></td></tr>
      </form>
    </table>
      <?php
        require_once "validation.php";
        if($_GET['action'] == 'add'){
            if(isset($_POST['search'])){
                $artist = $_POST['search'];
                $fail = validate_artName($artist);
                    if($fail == ""){
                        $sql = "INSERT INTO artist (artID, artName) VALUES (NULL, '$artist');";   
                        if ($conn->query($sql) === TRUE) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: Entry not added" . $conn->error;
                        }                          
                    }else{
                        echo "Invalid characters...";
                    }
            }
        }else if(($_GET['action'] == 'update') && isset($_GET['id'])){
                if(isset($_POST['search'])){
                    $artID = $_GET['id'];                                                        
                    $artist = $_POST['search'];
                    $fail = validate_artName($artist);
                    if($fail == ""){
                        $sql = "UPDATE artist SET artName ='$artist' WHERE artID = $artID;";   
                        if ($conn->query($sql)) {
                            echo "New record created successfully";
                            header("Location: Artists.php");
                        } else {
                            echo "Error: Entry not added" . $conn->error;
                        }                          
                    }else{
                        echo "Invalid characters...";
                    }
                }
            
        }
        ?>
    
    </div>
  </body>
</html>

    