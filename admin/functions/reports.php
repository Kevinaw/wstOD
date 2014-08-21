<?php
session_start();
  print <<<EOD
      <html>
      <head>
      <style>
        html {
        height:100%; /* fix height to 100% for IE */
        max-height:100%; /* fix height for other browsers */
        padding:0; /*remove padding */
        margin:0; /* remove margins */
        border:0; /* remove borders */
        background:#fff; /*color background - only works in IE */
        font-size:80%; /*set default font size */
        font-family:"trebuchet ms", tahoma, verdana, arial, sans-serif; /* set default font */
        /* hide overflow:hidden from IE5/Mac */
        /* \*/
        overflow:hidden; /*get rid of scroll bars in IE */
        /* */
        }
        body {
        height:100%; /* fix height to 100% for IE */
        max-height:100%; /* fix height for other browsers */
        overflow:hidden; /*get rid of scroll bars in IE */
        padding:0; /*remove padding */
        margin:0; /* remove margins */
        border:0; /* remove borders */
        }
        #content { 
        display:block; /* set up as a block */
        height:100%; /* set height to full page */
        max-height:100%;
        padding:10;
        overflow:auto; /* add scroll bars as required */
        position:relative; /* set up relative positioning so that z-index will work */
        z-index:3; /* allocate a suitable z-index */
        }
        .pad2 {
        display:block;
        height:200px; /* height to miss header and footer */
        }
        #header {padding:10; position:absolute; left:0; top:0; right:20; z-index:100; background-color:#fff; }

          table { border-collapse:collapse; width:100%; }
          td { border:1px solid silver; }
          th { background-color:silver; }
      </style>
      </head>
      <body>
      <div id='header'>
          <div style='float:right;'>
          <a href='../index.php'>back</a>
          </div>
          <img src='/images/logo_small.jpg' align=left><br>
          <b>Welcome {$_SESSION["admin_user"]["name"]}</b>
EOD;

  
$name=ucwords(str_replace(array(".php","_","/admin/functions/"),array(""," ",""),$_SERVER["PHP_SELF"]));
if(!in_array($name,array_values($_SESSION["admin_user"]["access"]))){
    print "Access Denied";
    exit;
}

  $d=dir("reports/");
  print <<<EOD
      <form action='#' method='post'>
      <b>Choose a Report: </b><select name='report'>
EOD;
  $names=array();
  while(false!==($entry = $d->read())) {
      if($entry=="." or $entry==".." or is_dir("reports/".$entry)) continue;
      $name=ucwords(str_replace(array(".sql","_"),array(""," "),$entry));
      $names[$entry]=$name;
      if($_POST["report"]==$entry) $selected="selected"; else $selected="";

      print <<<EOD
        <option value="{$entry}" {$selected}>{$name}</option>
EOD;
  
  }
  $d->close();

  print <<<EOD
        </select>
        <input type='submit' name='view' value='View'>
        <br>
        <input type='checkbox' name='debug'> Debug 
        </form>
        <hr>
      </div>
      <div id='content'>
      <div class="pad2"></div>
EOD;

if(isset($_POST["view"])){
    $settings=array();
    
    include "reports/".$_POST["report"];

    draw_grid($names[$_POST["report"]],$sql,$settings);    
}

print "</div></body></html>";


function draw_grid($name,$sql,$settings){
    global $_POST;

    require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
    $db=new Database();

    if(isset($_POST["debug"])) $db->debug=true;
    
    if($data=$db->get_data_multi($sql,array())){
    
        $colcount=count($data[0]);
        print <<<EOD
            <table>
            <tr><th colspan={$colcount}>{$name}</th></tr>
EOD;

        $lastrow=count($data)-1;
        foreach($data as $rownumber=>$row){

            print "<tr>";
            if($rownumber==0){
                foreach($row as $name=>$value){
                    print "<th>{$value->name}</th>";
                }
            } else {
                if($settings["total_row"]==true and $rownumber==$lastrow){
                  foreach($row as $name=>$value){
                      print "<th>{$value}</th>";
                  }
                } else {
                  foreach($row as $name=>$value){
                      print "<td>{$value}</td>";
                  }
                }
            }
            print "</tr>";
        }
        print "</table>";
        
    } else {
        print $db->lasterror;
    }
}

?>