<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
    <title>
        Artists
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
            <li class="current"><a href="Artists.php">Artists:</a></li>
            <li class="button"><a href="Albums.php?action=cds">Albums</a></li>
            <li class="button"><a href="Tracks.php?action=tracks">Tracks</a></li>
        </ul>
    </div>
    <div id="centerbox">
        <a href="addartist.php?action=add"><span class="addbutton">Add Artist</span></a>
    </div>
    <div id="centerbox">
        <form action="" method="get">
            <input type="search" name="search" placeholder="Search name...">
        </form>
        <table class = "cardTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Options...</th>
            </tr>
        </thead>
        <tbody>
        <?php
        require_once "validation.php";
            
        if(isset($_GET['search'])){
            $artist = $_GET['search'];
            $fail = validate_artName($artist);
            
            if($fail == ""){
                $sql = "SELECT * FROM artist WHERE artName LIKE '%$artist%'";  
                echo "<p>";
                $stmt = $conn->query($sql);
                if ($stmt->num_rows){
                    while($row = $stmt->fetch_assoc()) {
                        $id = $row["artID"];
        ?>
                        <tr>
                            <td><?php echo $row["artID"]; ?></td>
                            <td><?php echo $row["artName"]; ?></td>
                            <td>
                                <a href="Artists.php?action=delete&id=<?php echo $row['artID']; ?>">Delete</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="addartist.php?action=update&id=<?php echo $row['artID']; ?>">Edit</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="Albums.php?action=update&id=<?php echo $row['artID']; ?>">Album</a>
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
        $sql = "SELECT * FROM artist GROUP BY artID";   
        echo "<p>";
        $stmt = $conn->query($sql);                           
        
            if ($stmt->num_rows > 0){
                while($row = $stmt->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row["artID"]; ?></td>
                    <td><?php echo $row["artName"]; ?></td>
                    <td>
                        <a href="Artists.php?action=delete&id=<?php echo $row['artID']; ?>">Delete</a>
                         &nbsp;&nbsp;&nbsp;
                        <a href="addartist.php?action=update&id=<?php echo $row['artID']; ?>">Edit</a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="Albums.php?action=artist&id=<?php echo $row['artID']; ?>">Album</a>
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
    $sql = "DELETE FROM artist WHERE artID = '".$_GET['id']."'";
    $sql1 = "DELETE FROM cd WHERE artID = '".$_GET['id']."'";
    
    $stmt = $conn->query($sql1);
    $stmt = $conn->query($sql);
    if($stmt) {

        echo "Record deleted! ".$_GET['id']. ".";

    }else{
        echo "Not deleted...";
    }

}

?>