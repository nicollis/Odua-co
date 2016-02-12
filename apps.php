<!DOCTYPE html>
<html>
    <head>
        <?php include_once('src/styles.php');?>
        <title>Apps by Odua</title>
    </head>
    <body>
        <?php require_once('src/header.php');
            GenerateHeader(PAGE::APPS);
        ?>
        <content id="apps_content">
            <?php #GENERATE APPS LIST FROM PORTFOLIO DATABASE
                require_once 'src/db.php';
                $dbconn = post_connect(DB::NICGIO);
                $query = "SELECT name, url, description, photo, is_on_android, is_on_web, is_on_ios FROM projects WHERE is_on_odua = TRUE AND visible = TRUE ORDER BY NAME ASC";
                $raw_projects = pg_query($query) or die ('Query failed: '. pg_last_error());

                //Make <li> for each project
                while($line = pg_fetch_array($raw_projects, null, PGSQL_ASSOC))
                {
                    $p_name = $line["name"];
                    $p_url = $line["url"];
                    $p_desc = strlen($line["description"]) >= 171 ? substr($line["description"],0 , 167)."..." : $line["description"];
                    $p_photo = PORTFOLIOIMAGELOCATION . $line["photo"];
                    $p_android = $line["is_on_android"] == 't' ? '<img src="img/android.png">':'';
                    $p_web = $line["is_on_web"] == 't' ? '<img src="img/chrome.png">':'';
                    $p_ios = $line["is_on_ios"] == 't' ? '<img src="img/ios.png">':'';
                    echo "<a href='{$p_url}'><apptag>
                            <name>{$p_name}</name>
                            <img src='{$p_photo}'/>
                            <disc>
                                {$p_desc}
                            </disc><br>
                            <platforms>
                                {$p_web}
                                {$p_android}
                                {$p_ios}
                            </platforms>
                        </apptag></a>";
                }
                //Free results and close DB
                pg_free_result($raw_projects);
                pg_close($dbconn);
            ?>
        </content>
        <?php include_once('src/footer.php');?>
    </body>
</html>