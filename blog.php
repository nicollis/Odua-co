<!DOCTYPE html>
<html>
    <head>
        <?php include_once('src/styles.php');?>
        <title>Odua's Blog</title>
    </head>
    <body>
        <?php require_once('src/header.php');
            GenerateHeader(PAGE::BLOG);
        ?>
        <content>
            <div id=main class="blog">
            <search-box>
                <input type=text placeholder="search entries" name="search" id="search" value='<?php if(isset($_GET["s"])){echo $_GET["s"];}?>' onkeyup="checkSubmit(event);">
            </search-box>
            <?php require_once 'src/db.php';
                //Connect to the DB and pull language data
                $dbconn = post_connect(DB::NICGIO);
                if(!isset($_GET["s"]))
                    $query = 'SELECT title, date, entry, array_to_json(tags) FROM blog WHERE is_on_odua = TRUE AND visible = TRUE ORDER BY id DESC;';
                else{
                    $search = substr(filter_var($_GET["s"], FILTER_SANITIZE_STRING),0,140);
                    $query = "SELECT title, date, entry, array_to_json(tags) FROM blog WHERE '".$search."' % ANY(tags) OR lower(entry) LIKE '%".$search."%' OR lower(title) LIKE '%".$search."%' AND visible = TRUE;";
                }
                $raw_blog = pg_query($query) or die ('Query failed: '. pg_last_error());
                //Make language group for each langugae
                if(pg_num_rows($raw_blog)>=1){
                    while ($line = pg_fetch_array($raw_blog, null, PGSQL_ASSOC)) {
                        echo "<blog-entry>
                                <h1 class='title'>{$line['title']}</h1>
                                <p class='datestamp'>{$line['date']}</p>
                                <p class='blog-data'>
                                    {$line['entry']}
                                </p>
                                <p class='tags'>tags: ";
                        $tag_array = json_decode($line['array_to_json'], true);
                        foreach ($tag_array as $key=>$value){
                            if($key>0){ echo ", ";}
                            echo $value;
                        }
                        echo "</p>
                                <hr>
                            </blog-entry>";
                    }//end $line while
                }else{
                    echo "<blog-entry>
                                <h1 class='title'>No Entry's Found</h1>
                                <p class='datestamp'>0000-00-00</p>
                                <p class='blog-data'>
                                    Sorry, the search \"{$search}\" did not pull up any results. If you feel like you got this out of an error please let me know via the contact page.
                                </p>
                                <hr>
                        </blog-entry>";              
                }
                // Free resultset and close DB
                pg_free_result($raw_blog);
                pg_close($dbconn);
            ?>
            </div>
        </content>
        <?php include_once('src/footer.php');?>
    </body>
</html>