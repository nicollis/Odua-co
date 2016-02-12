<?php
interface PAGE
{
    const HOME = 0;
    const BLOG = 1;
    const APPS = 2;
    const HIRE = 3;
    const CHAT = 4;
}

define ("IMAGELOCATION", "http://nic.odua.co/img/uploads/odua.co/");
define ("PORTFOLIOIMAGELOCATION", "http://nic.odua.co/img/uploads/");

function GenerateHeader($page){
    echo '<img src="img/logo.png"/>
    <hr>
    <header>
        <ul>';
        if ($page==PAGE::HOME) echo '<strong>';
        echo '<li><a href="index.php">Home</a></li></strong>
            <vr></vr>';
        if ($page==PAGE::BLOG) echo '<strong>';
        echo '<li><a href="blog.php">Blog</a></li></strong>
            <vr></vr>';
        if ($page==PAGE::APPS) echo '<strong>';
        echo '<li><a href="apps.php">Apps</a></strong>
                <ul>';
                    GenerateApps();
        echo   '</ul>
            </li>
            <vr></vr>';
        if ($page==PAGE::HIRE) echo '<strong>';
        echo '<li><a href="hire.php">Hire</a></li></strong>
            <vr></vr>';
        if ($page==PAGE::CHAT) echo '<strong>';
        echo '<li><a href="chat.php">Chat</a></li></strong>
        </ul>
    </header>';
}

function GenerateApps(){
    require_once 'src/db.php';
    $dbconn = post_connect(DB::NICGIO);
    $query = "SELECT name, url FROM projects WHERE is_on_odua = TRUE AND visible = TRUE ORDER BY NAME ASC";
    $raw_projects_titles = pg_query($query) or die ('Query failed: '. pg_last_error());
    
    //Make <li> for each project
    while($line = pg_fetch_array($raw_projects_titles, null, PGSQL_ASSOC))
    {
        $p_name = $line["name"];
        $p_url = $line["url"];
        echo "<li><a href='{$p_url}'>{$p_name}</a></li>";
    }
    
    //Free results and close DB
    pg_free_result($raw_projects_titles);
    pg_close($dbconn);
}
?>