<?php include 'includes/Head.php';?>

<title>Home</title>
<link rel ="stylesheet" href="css/style.css">
<link rel ="stylesheet" href="css/home.css"> 

<?php include 'includes/Navigation.php';?>
<?php 
$key = $_POST["Search"];

$keyart = $key;
$keyart0 = $keyart;
?>

<div id="connectioncontent">
    
<div class="content">    
<?php 
    if ($stmt=$mysqli->prepare("SELECT DISTINCT uid, ufname, ulname, ucity, uscore, ulink, ubio, regtime FROM User, Likes, SubGenre WHERE User.uid != $uid AND Likes.lsgenre = SubGenre.sgid AND User.uid = Likes.luid AND (SubGenre.sggenre like ? OR ubio like ? OR ucity like ? OR ulname like ? OR ufname like ?);")){
        $key = '%'.$key.'%';
        $stmt->bind_param("sssss", $key, $key, $key, $key, $key);
        $stmt->execute();
        $stmt->bind_result($fuid, $fufname, $fulname, $fucity, $fuscore, $fulink, $fubio, $fregtime);
        $stmt->store_result();
        if ($stmt->num_rows >= 1){
            ?><ul class="following">
                <li>You may look for them? Their contents contains keywords "<?php echo $keyart;?>"</li>
            </ul>
            <ol><?php
            while ($stmt->fetch()) { ?>
                <li class='group'>
                    <div class="box" id="follower">
                        <div class="pics">
                            <a href= "">
                                <img src="Pictures/Users/<?php echo $fulink; ?>" width=150px height=150px>
                            </a>
                        </div>
                        <div class="links">
                            <a href= "User.php?User=<?php echo $fuid;?>">
                                <div class="discription">
                                    <h5><?php echo $fubio; ?></h5>
                                    <em class="time">
                                        Member since <?php echo date("Y-m-d", strtotime($fregtime)); ?>
                                    </em>
                                </div>
                            </a>
                        </div>
                        <ul>
                            <li><?php echo $fufname." ".$fulname; ?></li>
                            <li><img src="Pictures/Logos/score.png" width=10px height=10px> <?php echo $fuscore; ?></li>
                            <li><img src="Pictures/Logos/at.png" width=10px height=10px> <?php echo $fucity; ?></li> <?php
                            if ($stmt1 = $mysqli->prepare("SELECT * FROM Follow WHERE follower = ? AND followee = ?;")){
                                $stmt1->bind_param("ii", $uid, $fuid);
                                $stmt1->execute();
                                $stmt1->store_result();
                                if ($stmt1->num_rows == 1){ ?>
                            <div id="alreadyFollow">
                                You are currently following this person
                            </div> <?php 
                                } else { ?>
                            <form action="includes/Follow.php" method="post">
                                <input type="hidden" name="Followee" value="<?php echo $fuid;?>">
                                <input type="hidden" name="UID" value="<?php echo $uid;?>">
                                <input class="submitbutton" id="connectionFollow" type="submit" name="SignUp" value="Follow">
                            </form>  <?php
                                }
                            }?>
                        </ul>
                    </div>
                </li> <?php 
            }
        }
    } ?>
            </ol>       
</div>  
    
<div class="content"> <?php 
    if ($stmt=$mysqli->prepare("SELECT DISTINCT aid, artname, aemail, asite, alink, abio FROM Art, Have, SubGenre WHERE sgid = hsgenre AND haid = aid AND (SubGenre.sggenre LIKE ? OR artname LIKE ? OR aemail LIKE ? OR asite LIKE ? OR abio LIKE ?);")){
        $keyart = '%'.$keyart.'%';
        $stmt->bind_param("sssss", $keyart, $keyart, $keyart, $keyart, $keyart);
        $stmt->execute();
        $stmt->bind_result($aid, $fartname, $faemail, $fasite, $falink, $fabio);
        $stmt->store_result();
        if ($stmt->num_rows >= 1){ ?>
        <ul class="following">
            <li>You may look for those artists? Their contents contains keywords "<?php echo $keyart0;?>"</li>
        </ul>
        <ol> <?php
            while ($stmt->fetch()) { ?>
                <li class='group'>
                    <div class="box" id="bands">
                        <div class="pics">
                            <a href= "">
                                <img src="Pictures/Art/<?php echo $falink; ?>" width=150px height=150px>
                            </a>
                        </div>
                        <div class="links">
                            <a href= "Artist_Detail.php?Artist=<?php echo $aid; ?>" >
                                <div class="discription">
                                    <h5><?php echo $fabio; ?></h5>
                                </div>
                            </a>
                        </div>
                        <ul>
                            <li id="bandname"><a href="
                                <?php 
                                if(substr($fasite, 0, 4) != "http")echo "http://".$fasite; 
                                ?>"><?php echo $fartname; ?></a></li>
                            <?php
                            if ($stmt1 = $mysqli->prepare("SELECT * FROM Fans WHERE fan = ? AND follow = ?;")){
                                $stmt1->bind_param("ii", $uid, $aid);
                                $stmt1->execute();
                                $stmt1->store_result();
                                if ($stmt1->num_rows == 1){ ?>
                            <div id="alreadyFollow">
                                You are currently following this artist
                            </div> <?php 
                                } else { ?>
                            <form action="includes/Fan.php" method="post">
                                <input type="hidden" name="AID" value="<?php echo $aid;?>">
                                <input type="hidden" name="UID" value="<?php echo $uid;?>">
                                <input class="submitbutton" id="connectionFollow" type="submit" name="SignUp" value="Follow">
                            </form>  <?php
                                }
                            }?>
                        </ul>
                    </div>
                </li> <?php 
            }
        }
    } ?>
            </ol>
</div>
    
        

</div>
</body>
</html>

    
                
