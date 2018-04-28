<?php

/*
 * Session Management for phtml
 *
 * Achilles Systems (c) 2014
 *
 */

//global $DatabaseName, $HostName, $UserName, $PasswordName

session_start();
date_default_timezone_set('Asia/Jakarta');


class db_mySQL {

  //* public: connection parameters */
  var $Host;
  var $Database;
  var $User;
  var $Password;
  var $Port;

  /* public: current error number and error text */
  var $Errno    = 0;
  var $Error    = "";

  /* private: link and query handles */
  var $Link_ID  = 0;
  var $Query_ID = 0;

  var $Auto_Free     = 0;     ## Set to 1 for automatic mysqli_free_result()
  var $Debug         = 0;     ## Set to 1 for debugging messages.
  var $Halt_On_Error = 1;     ## 1 (halt with message), 2 (ignore errors quietly), 3 (ignore errror, but spit a warning)

  /* public: result array and current row number */
  var $Table;
  var $Row;

  /* public: connection management */


  public function init() {

      $location = getcwd();
      if(strpos($location,"htdocs")!==false){
          $this->Database = "kucingjoget";
          $this->Host = "localhost";
          $this->User = "root";
          $this->Password = "";
          $this->Port = "3306";
      }else{
          $this->Database = "kucingjoget";
          $this->Host = "indowollongong.com";
          $this->User = "ardi";
          $this->Password = 'Koetjingkampung123$sql';
          $this->Port = "3306";
      }


    $this->connect();
  }

  function connect() {

    $this->Link_ID = @mysqli_connect($this->Host, $this->User, $this->Password, $this->Database, $this->Port);
      if (!$this->Link_ID) {
          echo "Host:".$this->Host."\r\nUser:".$this->User."\r\nPassword:".$this->Password."\r\nDB:".$this->Database;exit;
          $this->halt("connection failed.");
      }

    if (!@mysqli_select_db($this->Link_ID, $this->Database)) {
      $this->halt("cannot use database ".$this->Database);
    }

    //sync timezone between PHP & MySQL
    $now = new DateTime();
    $mins = $now->getOffset() / 60;

    $sgn = ($mins < 0 ? -1 : 1);
    $mins = abs($mins);
    $hrs = floor($mins / 60);
    $mins -= $hrs * 60;

    $offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);
    $this->Link_ID->query("SET time_zone='$offset';");

    return $this->Link_ID;
  }

  public function close() {
    return @mysqli_close($this->Link_ID);
  }


  function error() {
    return $this->error = mysqli_error($this->Link_ID);
  }

  function errno() {
    return $this->errno = mysqli_errno($this->Link_ID);
  }

  /* public: perform a query */
  function query($Query_String) {

    if ($this->Query_ID) {
      @mysqli_free_result($this->Query_ID);
      $this->Query_ID = 0;
    }


    $this->Query_ID = @mysqli_query($this->Link_ID, $Query_String);
    $this->Row   = 0;
    $this->Errno = mysqli_errno($this->Link_ID);
    $this->Error = mysqli_error($this->Link_ID);
    if (!$this->Query_ID) {
      $this->halt("Invalid SQL: ".$Query_String);
    }

    return $this->Query_ID;
  }

  /* private: error handling */
  function halt($msg) {
    global $SERVER_NAME, $SERVER_ADDR, $PHP_SELF, $REQUEST_METHOD;

    if ($this->Link_ID) {
      $this->Error = @mysqli_error($this->Link_ID);
      $this->Errno = @mysqli_errno($this->Link_ID);
    } else {
      $this->Error = @mysqli_error();
      $this->Errno = @mysqli_errno();
    }
    if ($this->Halt_On_Error == "no")
      return;

    die($msg); //development server
    //die("Sorry, the server is momentanely in maintenance.<p>Please try later."); //live server
  }

  function fetch_row(){
    return mysqli_fetch_row($this->Query_ID);
  }

  function fetch_array(){
    return mysqli_fetch_array($this->Query_ID);
  }

  function fetch_assoc(){
    return mysqli_fetch_assoc($this->Query_ID);
  }

  function con(){
    return $this->Link_ID;
  }

  /**
   * [save description]
   * @param  [type] $table_name [description]
   * @param  array  $data       [description]
   * @return [type]             [description]
   * @author FK <fian.kurniawan@vivia-indonesia.com>
   */
  function save($table_name = null, $data = array()){
    $fields = $this->getFields($table_name);

    $query  = "INSERT INTO ".$table_name." (".implode(', ', $fields).") ";
    $query .= "VALUES (";

    foreach ($fields as $key => $field) {
      if(!empty($data[$field])){
        $insert_values[] = "'".$data[$field]."'";
      }else{
        $insert_values[] = "''";
      }
    }
    $query .= implode(', ', $insert_values);
    $query .= ")";
    return $this->query($query);
  }

  /**
   * [getFields description]
   * @param  [type]  $table_name [description]
   * @param  boolean $primary    [description]
   * @return [type]              [description]
   * @author FK <fian.kurniawan@vivia-indonesia.com>
   */
  function getFields($table_name = null, $primary = true){
    $result    = $this->query("SELECT * FROM ".$table_name);
    $field_obj = $result->fetch_fields();

    foreach ($field_obj as $key => $value) {
      $fields[] = $value->name;
    }
    return $fields;
  }

  function find($first = 'first', $options = array()) {
    $mysqli   = new mysqli($this->Host, $this->User, $this->Password, $this->Database);

    $sel_fields = "*";
    $cond_arr   = array();
    $fields     = $this->getFields($options['table_name']);
    $data       = array();

    if(!empty($options['fields'])){
      $sel_fields = implode(", ", $options['fields']);
    }

    $find_query  = "SELECT ".$sel_fields." FROM ";
    $find_query .= $options['table_name'];
    if(!empty($options['conditions'])){
      $find_query .= " WHERE ";
      foreach($options['conditions'] as $key => $cond){
        $cond_arr[] = $key. " = ".$cond;
      }
      $find_query .= implode(" AND ", $cond_arr);
    }
    if($first == 'first'){
      $find_query .= " LIMIT 1 ";
    }

    if ($result = mysqli_query($mysqli, $find_query)) {
      $i =0;
      while ($row = mysqli_fetch_row($result)) {
        foreach ($fields as $key => $field) {
          $data[$i][$field] = $row[$key];
        }
        $i++;
      }
      mysqli_free_result($result);
    }
    mysqli_close($mysqli);


    if($first == 'first' && !empty($data)){
      return $data[0];
    }
    return $data;
  }

  function last_insert_id()
  {
    return mysqli_insert_id($this->Link_ID);
  }
}

?>
