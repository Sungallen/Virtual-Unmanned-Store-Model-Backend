<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $username, $password)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && password_verify($password, $dbpassword)) {
                $login = true;
            } else $login = false;
        } else $login = false;

        return $login;
    }

    function signUp($table, $fullname, $email, $username, $password)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        $this->sql =
            "select count(*) from " .$table;
        $result = mysqli_query($this->connect, $this->sql);
        $userid = mysqli_fetch_row($result);
        $newuser = $userid[0] + 1;
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (id, fullname, username, password, email) VALUES ('" .$newuser ."', '" . $fullname . "','" . $username . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }
    function shoppingrecord($table, $username)
    {
        $num = 0;
        $username = $this->prepareData($username);
        $this->sql = "select shop_id,product1,product2,product3,sum from " . $table . " where UID = '".$username."'";
        $result = mysqli_query($this->connect, $this->sql);
        while($row = mysqli_fetch_array($result)){
            foreach($row AS $data) {
                if($num == 1) {
                    if($data != null) {
                        echo $data . ' ';
                    }
                    $num = 0;
                    continue;
                }
                $num++;
            }
            echo '!';
        }



    }
    function searchproduct($table, $title){
        $title = $this->prepareData($title);
        $this->sql = "SELECT price FROM ". $table. " WHERE title = '".$title."'";
        $result = mysqli_query($this->connect, $this->sql);
        $price = mysqli_fetch_row($result);
        echo $price[0];
    }
    function addrecord($table, $product1, $product2, $product3, $sum, $UID)
    {
        $product1 = $this->prepareData($product1);
        $product2 = $this->prepareData($product2);
        $product3 = $this->prepareData($product3);
        $sum = $this->prepareData($sum);
        $UID = $this->prepareData($UID);
        $this->sql =
            "select count(*) from " .$table;
        if($product2 == "nothing"){
            $product2 = "";
        }
        if($product3 == "nothing"){
            $product3 = "";
        }
        $result = mysqli_query($this->connect, $this->sql);
        $record_id = mysqli_fetch_row($result);
        $new_record = $record_id[0] + 1;
        $this->sql =
            "INSERT INTO " . $table . " (shop_id, product1, product2, product3, sum, UID) VALUES ('" .$new_record ."', '" . $product1 . "','" . $product2 . "','" . $product3 . "','" . $sum . "','".$UID."')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }
}


?>
