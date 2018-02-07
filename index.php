<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot;"/>
    <title>
        HOME
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
            <li class="current"><a href="index.php">Home:</a></li>
            <li class="button"><a href="Artists.php">Artists</a></li>
            <li class="button"><a href="Albums.php?action=cds">Albums</a></li>
            <li class="button"><a href="Tracks.php?action=tracks">Tracks</a></li>
        </ul>
    </div>
    
    <div id="container">
        <div id="inner">
            <div class = "child">
                <?php
                echo "Total value of CD's:";
                $sql = "SELECT ROUND(SUM(cdPrice),2) FROM cd";   

                echo "<p>";
                $stmt = $conn->query($sql);                           
                $row = $stmt->fetch_row();
                echo "£" .$row[0];

                echo "</p>";
                ?>
            </div>
            <div class = "child">
                <?php
                echo "Total number of artists:";
                $sql = "SELECT COUNT(DISTINCT artName) FROM artist";   

                echo "<p>";
                $stmt = $conn->query($sql);                           
                $row = $stmt->fetch_row();
                echo  $row[0]. " Artists";

                echo "</p>";
                ?>
            </div>
            <div class = "child">
                <?php
                echo "Total number of albums:";
                $sql = "SELECT COUNT(DISTINCT cdID) FROM cd";   

                echo "<p>";
                $stmt = $conn->query($sql);                           
                $row = $stmt->fetch_row();
                echo  $row[0]. " Albums";

                echo "</p>";
                ?>
            </div>
            <div class = "child">
                <?php
                echo "Total duration of tracks:";
                $sql = "SELECT SUM(duration) FROM track";   

                echo "<p>";
                $stmt = $conn->query($sql);                           
                $row = $stmt->fetch_row();
                $seconds = $row[0];
                $hours = floor($seconds / 3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;

                echo "$hours","h ", "$minutes", "m ", "$seconds", "s";
                echo "</p>";
                ?>
            </div> 
            <div class = "child">
                <?php
                echo "Total number of unique genres:";
                $sql = "SELECT COUNT(DISTINCT cdGenre) FROM cd";   

                echo "<p>";
                $stmt = $conn->query($sql);                           
                $row = $stmt->fetch_row();
                echo  $row[0]. " different Genres";

                echo "</p>";
                ?>
            </div>
        </div>
        <div id="inner">
            <div class = "child">
                <?php
                $sql = "SELECT cdTitle,cdPrice,artist.artName FROM `cd`,artist WHERE cd.artID = artist.artID ORDER BY cdPrice DESC LIMIT 3";
                $stmt = $conn->query($sql);                          
                if ($stmt->num_rows > 0){
                    echo "The most expensive albums are: ";
                    echo "<p>";
                    while($row = $stmt->fetch_assoc()) {
                        echo $row["cdTitle"]. " - by " .$row["artName"]. " -- Price: £" .$row["cdPrice"];
                        echo "</p>";
                    }
                }else{
                    echo "something went wrong :P";
                }
                ?>
            </div>
            <div class = "child">
                <form action="" method="post">
                    <input type="search" name="search" placeholder="Search ID">
                </form>

                <?php
                require_once "validation.php";

                if(isset($_POST['search'])){
                    $artID = $_POST['search'];
                    $fail = validate_artID($artID);
                        if($fail == ""){
                            $sql = "SELECT artID, artName FROM artist WHERE artID = $artID";   
                            echo "<p>";
                            echo "<p>";
                            $stmt = $conn->query($sql);                           
                            if ($stmt->num_rows > 0){
                                while($row = $stmt->fetch_assoc()) {
                                    echo "Artist ID ".$row["artID"]. " is " .$row["artName"];
                                    echo "</p>";
                                }
                            }else{
                                echo "No results";
                            }
                        }else{
                            echo "Use the above to search for an Artist using an ID number... ONLY numbers!";
                        }
                    }else{
                    echo "<p>";
                    echo "Use the above to search for an Artist using an ID number";
                }
                ?>
            </div>
        </div>
    </div>
   
    </body>
</html>