<?php
session_start();

  print <<<EOD
      <img src="/images/logo_small.jpg" align=left> <br><b>Admin Site</b><br clear=all>
EOD;

if(isset($_POST["login"])) login($_POST);
if(isset($_POST["logout"])) unset($_SESSION["admin_user"]);

if(isset($_SESSION["admin_user"])){

  print "<h3>Welcome {$_SESSION["admin_user"]["name"]}</h3><hr>";

  $d=dir("functions/");
  $output=array();
  while(false!==($entry = $d->read())) {
      if($entry=="." or $entry==".." or is_dir("functions/".$entry)) continue;
      $name=ucwords(str_replace(array(".php","_"),array(""," "),$entry));
      
      if(in_array($name,array_values($_SESSION["admin_user"]["access"]))){
          $output[$name]=<<<EOD
            <a href="functions/{$entry}">{$name}</a><br>
EOD;
      }
  
  }

  $d->close();
  
  //----kevin----delete listings_requests, and add it to the end
  unset($output['Listings Requests']);
  unset($output['Listings']);
  //end
  
  ksort($output);
  print join("",$output);
//----kevin----20140824: add new functions
  print "<a href='/site/listings/add.php?is_admin=true'>Add Listing</a><br>";
  print "<a href='/site/listings/edit.php?is_admin=true'>Edit Listing</a><br>";
  print "<a href='functions/listings_requests.php'>Listings Requests</a><br>";
  print "<a href='functions/listings.php'>All Listings</a><br>";
  //end

  print "<br><form action='#' method='post'><input type='submit' name='logout' value='Logout'></form>";

} else {

  print <<<EOD
      <form action="#" method="post">
      <table><tr>
      <td>User Id:</td><td><input type='text' name='id'></td>
      </tr><tr>
      <td>Password:</td><td><input type='password' name='password'></td>
      </tr><tr>
      <th colspan=2><input type='submit' name='login' value="Login"></th>
      </tr></table>
      </form>
EOD;
  
  
}


function login($val){
  global $_SESSION;
  
  require_once $_SERVER['DOCUMENT_ROOT']."/includes/dbi.inc";
  $db=new Database();
  
  $sql="select access.name as access,salesperson.name as name,salesperson.id as sales_id from salesperson join access on salesperson.id=salesperson_id where username='[id]' and password='[password]'";
  if($data=$db->get_data($sql,$val)){
      if(count($data)>1){
          $access=array();
          foreach($data as $rownumber=>$row){
              if($rownumber==0) continue;
              $name=$row["name"];
              $id=$row["sales_id"];
              $access[]=$row["access"];
          }
          $_SESSION["admin_user"]=array("name"=>$name,"access"=>$access,"id"=>$id);
      }
  }

}

?>