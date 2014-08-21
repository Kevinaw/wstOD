<?php
session_start();
  print "<div style='float:right;'><a href='../index.php'>back</a></div><img src='/images/logo_small.jpg' align=left><br><b>Welcome {$_SESSION["admin_user"]["name"]}</b><br clear=all><hr>";

$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}

if(isset($_POST["save"])){
    file_put_contents("../../site/chat.txt",$_POST["scroll_text"]);
}

$scroll_text="";
if(file_exists("../../site/chat.txt")){
    $scroll_text=file_get_contents("../../site/chat.txt");
}

print <<<EOD
    <h3>Edit Scroller</h3>
    <form action="#" method="post">
    Chat Text: <br>
    <textarea name="scroll_text" rows=5 cols=80>{$scroll_text}</textarea><br>
    <input type='submit' name='save' value='Save'>
    </form>
EOD;




?>