<?php
require_once 'src/db.php';
$imagedir = "../img/uploads/odua.co/";
$dbconn = post_connect(DB::NICGIO);
$query = "SELECT hire_tag, hire_details, hire_skills FROM odua ORDER BY id DESC LIMIT 1;";
$raw_entery = pg_query($query) or die ('Query failed: '. pg_last_error());
$data = pg_fetch_array($raw_entery, null, PGSQL_ASSOC);
$skills = json_decode($data['hire_skills'], true);
pg_free_result($raw_entery);
pg_close($dbconn);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once('src/styles.php');?>
        <title>Hire Odua</title>
    </head>
    <body>
        <?php require_once('src/header.php');
            GenerateHeader(PAGE::HIRE);
        ?>
        <content>
            <h3 id=hire-header><?php echo $data['hire_tag'];?></h3>
            <ul class=three-skills>
                <?php
                    $first_item = true;
                    $root = IMAGELOCATION;
                    foreach ($skills as $skill)
                    {
                        $a_skill = json_decode($skill, true);
                        $iurl = $root.$a_skill['photo'];
                        
                        if($first_item != true)
                            echo '<vr></vr>';
                        else
                            $first_item = false;

                        echo '<li class=skill>
                                <img class="skill_img" src="'.$iurl.'"/>
                                <h3>'.$a_skill['title'].'</h3>
                                <p>'.$a_skill['detail'].'</p>
                            </li>'
                        ;
                    }
                ?>
            </ul>
            <hr>
            <p class=hire-details>
                <?php echo $data['hire_details'];?>
            </p>
            <h3><a href="chat.php">Get in Touch</a></h3>
        </content>
        <?php include_once('src/footer.php');?>
    </body>
</html>