<?php
//TODO Implment RSS Feed & Blog pull up by title 
require_once 'src/db.php';
$imagedir = "../img/uploads/odua.co/";
$dbconn = post_connect(DB::NICGIO);
$query = "SELECT about, hire_short,  array_to_json(slideshow) FROM odua ORDER BY id DESC LIMIT 1;";
$raw_entery = pg_query($query) or die ('Query failed: '. pg_last_error());
$data = pg_fetch_array($raw_entery, null, PGSQL_ASSOC);
pg_free_result($raw_entery);
pg_close($dbconn);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once('src/styles.php');?>
        <title>Odua</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="js/galleria-1.3.5.min.js"></script>
        <link rel="stylesheet" type="text/css" href="js/theme/gallera.odua_standard_theme.css" />
    </head>
    <body>
        <?php require_once('src/header.php');
            GenerateHeader(PAGE::HOME);
        ?>
        <content>
            <top>
                <div class="container">
                    <div class="galleria">
                        <?php
                            $root = IMAGELOCATION;
                            foreach (json_decode($data['array_to_json']) as $image)
                            {
                                $iurl = $root.$image;
                                echo '<img width="440" height="260" src="'.$iurl.'">';
                            }
                        ?>
                    </div>
                    <script>
                        Galleria.loadTheme('js/theme/galleria_odua_standard_theme.js');
                        Galleria.run('.galleria', {
                            extend: function(){
                                var gallery = this;
                                gallery.play(5000);
                            }
                        });
                    </script>
                </div>
                <hr>
            </top>
            <bottom>
                <div class="info-container">
                    <div id='left-side' class='info-box'>
                        <name>we're</name>
                        <div><?php echo $data['about'];?></div>
                    </div>
                    <div id='right-side' class='info-box'>
                        <name>hire</name>
                        <div><?php echo $data['hire_short'];?></div>
                    </div>
                </div>
                <!--<div>Suscribe to our RSS!</div>-->
            </bottom>
        </content>
        <?php include_once('src/footer.php');?>
    </body>
</html>
<?php 
    
?>