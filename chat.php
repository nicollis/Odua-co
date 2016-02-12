<?php
require_once 'src/db.php';
$imagedir = "../img/uploads/odua.co/";
$dbconn = post_connect(DB::NICGIO);
$query = "SELECT more_about, open_source FROM odua ORDER BY id DESC LIMIT 1;";
$raw_entery = pg_query($query) or die ('Query failed: '. pg_last_error());
$data = pg_fetch_array($raw_entery, null, PGSQL_ASSOC);
pg_free_result($raw_entery);
pg_close($dbconn);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once('src/styles.php');?>
        <title>About Odua</title>
    </head>
    <body>
        <?php require_once('src/header.php');
            GenerateHeader(PAGE::CHAT);
        ?>
        <content id="chat-page">
            <div id="chat-left">
                <div class=info-box>
                    <name>more about</name><br>
                    <div><?php echo $data['more_about'];?></div>
                </div>
                <div class=info-box>
                    <name>open sourced</name><br>
                    <div><?php echo $data['open_source'];?></div>
                </div>
            </div>
            <div id="chat-right">
                <?php
                    function spamcheck($field) {
                      // Sanitize e-mail address
                      $field=filter_var($field, FILTER_SANITIZE_EMAIL);
                      // Validate e-mail address
                      if(filter_var($field, FILTER_VALIDATE_EMAIL)) {
                        return TRUE;
                      } else {
                        return FALSE;
                      }
                    }
                ?>
                <name id="form_title">contact</name>
                <?php
                // display form if user has not clicked submit
                if (!isset($_POST["email"])) {
                  ?>
                <form id="contact_block" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                    <name>name</name><input type="text" name="name" required placeholder="John Smith"><br>
                    <name>email</name><input type="email" name="email" required placeholder="jsmith@mymail.com"><br>
                    <name>message</name><textarea required name="message" placeholder="I would like to talk to you!"></textarea><br>
                    <input class="button" type="submit" value="send" />
                </form>
                <?php 
                    } else {  // the user has submitted the form
                      // Check if the "from" input field is filled out
                      if (isset($_POST["email"])) {
                        // Check if "from" email address is valid
                        $mailcheck = spamcheck($_POST["email"]);
                        if ($mailcheck==FALSE) {
                          echo "Invalid input";
                        } else {
                          $name = $_POST["name"];
                          $from = $_POST["email"]; // sender
                          $message = "Message From: ".$name."\n\n";
                          $message = $message . $_POST["message"];
                          // message lines should not exceed 70 characters (PHP rule), so wrap it
                          $message = wordwrap($message, 70);
                          // send mail
                          mail("contact@odua.co","Contact Form Message",$message,"From: $from\n");
                          echo "<br><br><br>Thank you, I'll get to your comment as soon as I can!";
                        }
                      }
                    }
                ?><br>
                <p><b>email:</b> <a><?php echo hide_email('contact@odua.co'); ?></a></p>
                <a href="https://www.positivessl.com" style="font-family: arial; font-size: 10px; color: #212121; text-decoration: none;"><img src="https://www.positivessl.com/images-new/PositiveSSL_tl_trans2.png" alt="SSL Certificate" title="SSL Certificate" border="0" /></a>
            </div>
        </content>
        <?php include_once('src/footer.php');?>
    </body>
</html>