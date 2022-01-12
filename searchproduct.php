<?php
require "DataBase.php";
$db = new DataBase();
if(isset($_POST['title'])){
    if($db->dbConnect()){
        $price = $db->searchproduct("product", $_POST['title']);
        echo $price;
    }else echo "please enter product again";

}else echo "did not enter product";

?>