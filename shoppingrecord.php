<?php
require "DataBase.php";
$db = new DataBase();
if(isset($_POST['username'])) {
    if ($db->dbConnect()) {
        $array = $db->shoppingrecord("shoppingrecord", $_POST['username']);
        //$result = implode(" ", $array);
        echo $array;
    } else echo "failed";
}else echo "All fields are required"


?>