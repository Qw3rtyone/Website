<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
    <title>
        Tracks
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
            <li class="current"><a href="Tracks.php?action=tracks">Tracks:</a></li>
        </ul>
    </div>
    <div id="centerbox">
        <a href="addtrack.php?action=add"><span class="addbutton">Add Tracks</span></a>
    </div>   
    <div id="centerbox">
        <form action="" method="get">
            <input type="search" name="search" placeholder="Search track...">
        </form>

        <table class = "cardTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Duration</th>
                <th>Album Name</th>
                <th>Options...</th>
            </tr>
        </thead>
        <tbody>
        <?php
        require_once "validation.php";
        if((isset($_GET['action'])) && ($_GET['action'] == 'album') && isset($_GET['id'])){
            $album = $_GET['id'];
            $sql = "SELECT trackName, duration, cd.cdTitle FROM track INNER JOIN cd ON cd.cdID = track.cdID WHERE track.cdID = $album ORDER BY cd.cdTitle, trackName";
            echo "<p>";
            
            $stmt = $conn->query($sql);
            if ($stmt->num_rows){
                while($row = $stmt->fetch_assoc()) {
        ?>
                    <tr>
                        <td><?php echo $row["trackName"]; ?></td>
                        <td><?php $seconds = $row["duration"];
                                  $minutes = floor($seconds / 60);
                                  $seconds -= $minutes * 60;
                                  echo "$minutes", "m ", "$seconds", "s";
                            ?></td>
                        <td><?php echo $row["cdTitle"]; ?></td>
                        <td>
                            <a href="Tracks.php?action=delete&id=<?php echo $row['trackID']; ?>">Delete</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="addtrack.php?action=update&id=<?php echo $row['trackID']; ?>">Edit</a>
                        </td>
                    </tr>     
        <?php
                }
            }else{
                echo "No results :p";
            }
            
        }elseif(isset($_GET['search'])){
                    $track = strip_tags($_GET['search']);
                    $fail = validate_trackName($track);
            
            if($fail == ""){
                $sql = "SELECT trackName, duration, cd.cdTitle FROM track INNER JOIN cd ON cd.cdID = track.cdID WHERE trackName LIKE '%$track%' ORDER BY cd.cdTitle, trackName";  
                echo "<p>";
                $stmt = $conn->query($sql);
                if ($stmt->num_rows){
                    while($row = $stmt->fetch_assoc()) {
        ?>
                        <tr>
                            <td><?php echo $row["trackName"]; ?></td>
                            <td><?php $seconds = $row["duration"];
                                      $minutes = floor($seconds / 60);
                                      $seconds -= $minutes * 60;
                                      echo "$minutes", "m ", "$seconds", "s";
                                ?></td>
                            <td><?php echo $row["cdTitle"]; ?></td>
                            <td>
                                <a href="Tracks.php?action=delete&id=<?php echo $row['trackID']; ?>">Delete</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="addtrack.php?action=update&id=<?php echo $row['trackID']; ?>">Edit</a>
                            </td>
                        </tr>    
        <?php
                    }
                }else{
                    echo "No results :p";
                }
        
            }else{
                echo "$fail";
            }
        }else{
        $sql = "SELECT trackID, trackName, duration, track.cdID, cd.cdTitle FROM track INNER JOIN cd ON cd.cdID = track.cdID ORDER BY cd.cdTitle, trackName";   
        echo "<p>";
        $stmt = $conn->query($sql);                           
        
            if ($stmt->num_rows > 0){
                while($row = $stmt->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row["trackName"]; ?></td>
                    <td><?php $seconds = $row["duration"];
                              $minutes = floor($seconds / 60);
                              $seconds -= $minutes * 60;
                              echo "$minutes", "m ", "$seconds", "s";
                        ?></td>
                    <td><?php echo $row["cdTitle"]; ?></td>
                    <td>
                        <a href="Tracks.php?action=delete&id=<?php echo $row['trackID']; ?>">Delete</a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="addtrack.php?action=update&id=<?php echo $row['trackID']; ?>">Edit</a>
                    </td>
                </tr>    
            <?php
                }
            }
        }
        ?>
            
        </tbody>
        </table>
        
    </div>

   
</body>
</html>

<?php
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