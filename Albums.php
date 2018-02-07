<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
    <title>
        Albums
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
            <li class="current"><a href="Albums.php?action=cds">Albums:</a></li>
            <li class="button"><a href="Tracks.php?action=tracks">Tracks</a></li>
        </ul>
    </div>
    <div id="centerbox">
        <a href="addalbum.php?action=add"><span class="addbutton">Add Album</span></a>
    </div>
    <div id="centerbox">
        <form action="" method="get">
            <input type="search" name="search" placeholder="Search title...">
        </form>
        <table class = "cardTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Genre</th>
                <th>Price</th>
                <th>Options...</th>
            </tr>
        </thead>
        <tbody>
        <?php
        require_once "validation.php";
        
        if((isset($_GET['action'])) && ($_GET['action'] == 'artist') && isset($_GET['id'])){
            $artist = $_GET['id'];
            $sql = "SELECT * FROM cd INNER JOIN artist ON cd.artID = artist.artID WHERE cd.artID = '$artist'";
            echo "<p>";
            
            $stmt = $conn->query($sql);
            if ($stmt->num_rows){
                while($row = $stmt->fetch_assoc()) {
        ?>
                    <tr>
                        <td><?php echo $row["cdID"]; ?></td>
                        <td><?php echo $row["cdTitle"]; ?></td>
                        <td><?php echo $row["artName"]; ?></td>
                        <td><?php echo $row["cdGenre"]; ?></td>
                        <td><?php echo "£" .$row["cdPrice"]; ?></td>
                        <td>
                            <a href="Albums.php?action=delete&id=<?php echo $row['cdID']; ?>">Delete</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="addalbum.php?action=update&id=<?php echo $row['cdID']; ?>">Edit</a>
                            &nbsp;&nbsp;&nbsp;
                           <a href="Tracks.php?action=album&id=<?php echo $row['cdID']; ?>">Tracks</a>
                        </td>
                    </tr>    
        <?php
                }
            }else{
                echo "No results :p";
            }
            
        }elseif(isset($_GET['search'])){
            $album = $_GET['search'];
            $fail = validate_artName($album);

            if($fail == ""){
                $sql = "SELECT * FROM cd INNER JOIN artist ON cd.artID = artist.artID WHERE cdTitle LIKE '%$album%'";  
                echo "<p>";
                $stmt = $conn->query($sql);
                if ($stmt->num_rows){
                    while($row = $stmt->fetch_assoc()) {
        ?>
                        <tr>
                            <td><?php echo $row["cdID"]; ?></td>
                            <td><?php echo $row["cdTitle"]; ?></td>
                            <td><?php echo $row["artName"]; ?></td>
                            <td><?php echo $row["cdGenre"]; ?></td>
                            <td><?php echo "£" .$row["cdPrice"]; ?></td>
                            <td>
                                <a href="Albums.php?action=delete&id=<?php echo $row['cdID']; ?>">Delete</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="addalbum.php?action=update&id=<?php echo $row['cdID']; ?>">Edit</a>
                                &nbsp;&nbsp;&nbsp;
                               <a href="Tracks.php?action=album&id=<?php echo $row['cdID']; ?>">Tracks</a>
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
            $sql = "SELECT * FROM cd INNER JOIN artist ON cd.artID = artist.artID GROUP BY cdID";   
            echo "<p>";
            $stmt = $conn->query($sql);                           
        
            if ($stmt->num_rows > 0){
                while($row = $stmt->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo $row["cdID"]; ?></td>
                    <td><?php echo $row["cdTitle"]; ?></td>
                    <td><?php echo $row["artName"]; ?></td>
                    <td><?php echo $row["cdGenre"]; ?></td>
                    <td><?php echo "£" .$row["cdPrice"]; ?></td>
                    <td>
                        <a href="Albums.php?action=delete&id=<?php echo $row['cdID']; ?>">Delete</a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="addalbum.php?action=update&id=<?php echo $row['cdID']; ?>">Edit</a>
                        &nbsp;&nbsp;&nbsp;
                       <a href="Tracks.php?action=album&id=<?php echo $row['cdID']; ?>">Tracks</a>
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
    $sql = "DELETE FROM cd WHERE cdID = '".$_GET['id']."'";
    $stmt = $conn->query($sql);
    if($stmt) {

        echo "Album deleted! ".$_GET['id']. ".";

    }else{
        echo "Not deleted...";
    }

}

?>