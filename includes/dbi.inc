<?php


class Database {
    var $lasterror="";
    var $lastsql="";
    var $database;
    var $host;
    var $user;
    var $password;
    var $db;
    var $resultMulti;
    var $errMulti;
    var $debug=false;   
    var $isconnected=false; 
    var $insert_ids=array();

    function __construct($database="ch1647_oildir",$host="localhost",$user="ch1647_oildir",$password="8r:I|l2Rrf)P"){
    
        $this->database=$database;
        $this->host=$host;
        $this->user=$user;
        $this->password=$password;

        $this->db = new mysqli($this->host, $this->user, $this->password, $this->database);

        /* check connection */
        if (@$this->db->connect_error) {
            $this->lasterror="Connect failed: ".$this->db->error;
            return;
        }
        if(!strlen(@$this->db->sqlstate)){
          $this->lasterror="Connect failed: Unknown Consultant";
          return;
        }

        @$this->db->set_charset('utf8');


        $this->isconnected=true;
    }

    function __destruct(){
        @$this->db->close();
    }
    
    function escape($value){
        return @$this->db->real_escape_string($value);
    }
    function get_data($sql,$parms,$page_size=0,$page=0,$type=MYSQL_ASSOC){
    
        $newarray=array();
        $this->lasterror="";
        foreach($parms as $parmnumber=>$parm){
            $sql=str_replace("[{$parmnumber}]",@$this->db->real_escape_string($parm),$sql);
        }
        
        //do paging
        if($page_size){
            $limit=$page_size;
            $offset=$page_size*$page;
            $sql.=" limit {$limit} offset {$offset}";
        }
        
        $this->lastsql=$sql;
        
        if($this->debug) print $sql."<br>";
    
        if($result = @$this->db->query($sql,MYSQLI_USE_RESULT)){
            $headers=$result->fetch_fields();
            $newarray[0]=array();
            foreach($headers as $colnum=>$col){
                if($type==MYSQL_NUM){
                    $newarray[0][$colnum]=$col;
                } else {
                    $newarray[0][$col->name]=$col;
                }
            }
            
            while($row=$result->fetch_array($type)){
                $newarray[]=$row;
            } 
            $result->free();
        } else {
          $this->lasterror=@$this->db->error;

          if($this->debug) print $this->db->error."<br>";

          return false;
        }
        
        return $newarray;
    }

    function get_data_multi($sql,$parms,$page_size=0,$page=0,$type=MYSQL_ASSOC){
    
      $newarray=array();
      $this->lasterror="";

      foreach($sql as $num=>$item){
        foreach($parms as $parmnumber=>$parm){
            $item=str_replace("[{$parmnumber}]",$this->db->escape_string($parm),$item);
        }
        $this->lastsql=$item;
        if($this->debug) print $item."<br>";
        
        if($num==(count($sql)-1)){
          if($result = @$this->db->query($item,MYSQLI_USE_RESULT)){
              $headers=$result->fetch_fields();
              $newarray[0]=array();
              foreach($headers as $colnum=>$col){
                  if($type==MYSQL_NUM){
                      $newarray[0][$colnum]=$col;
                  } else {
                      $newarray[0][$col->name]=$col;
                  }
              }
              
              while($row=$result->fetch_array($type)){
                  $newarray[]=$row;
              } 
              $result->free();
          } else {
            $this->lasterror=@$this->db->error;
  
            if($this->debug) print $this->db->error."<br>";
  
            return false;
          }
        } else {
          if(!$result = $this->db->query($item)){
              $this->lasterror=$this->db->error;
              if($this->debug) print $this->db->error."<br>";
                        
              return false;
          }
        }
      }
      return $newarray;
  }
    
  function set_data($sql,$parms){
  
        $this->lasterror="";
  
      foreach($parms as $parmnumber=>$parm){
          $sql=str_replace("[{$parmnumber}]",$this->db->escape_string(htmlentities($parm,ENT_COMPAT,"ISO-8859-1",false)),$sql);//$this->db->escape_string($parm),$sql);
      }
        $this->lastsql=$sql;  
        if($this->debug) print $sql."<br>";
  
      if($result = $this->db->query($sql)){
          return $this->db->affected_rows;
      } else {
          $this->lasterror=$this->db->error;

          if($this->debug) print $this->db->error."<br>";

          return false;
      }
      return $result;
  
  }
  

  function set_data_return_id($sql,$parms){
  
        $this->lasterror="";
  
      foreach($parms as $parmnumber=>$parm){
          $sql=str_replace("[{$parmnumber}]",$this->db->escape_string($parm),$sql);
      }
        $this->lastsql=$sql;
        if($this->debug) print $sql."<br>";
  
      if($result = $this->db->query($sql)){
         return $this->db->insert_id;
      } else {
          $this->lasterror=$this->db->error;

          if($this->debug) print $this->db->error."<br>";

          return false;
      }
  
  }
  
  function set_data_multi($sql,$parms){

      $this->lasterror="";

      if(!$this->db->query("begin")){
          $this->lasterror=$this->db->error;
          if($this->debug) print $this->db->error."<br>";
                    
          return false;
      }
      
      foreach($sql as $num=>$item){
        foreach($parms as $parmnumber=>$parm){
            $item=str_replace("[{$parmnumber}]",$this->db->escape_string($parm),$item);
        }
        $this->lastsql=$item;
        if($this->debug) print $item."<br>";
        
        if(!$result = $this->db->query($item)){
            $this->lasterror=$this->db->error;
            $this->db->query("rollback");

            if($this->debug) print $this->db->error."<br>";
                      
            return false;
        }
      }

      if(!$this->db->query("commit")){
          $this->lasterror=$this->db->error;
          if($this->debug) print $this->db->error."<br>";
                    
          return false;
      }
      
      return true;
      
   }

    
}







?>
