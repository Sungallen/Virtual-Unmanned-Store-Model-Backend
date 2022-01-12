<?php
require "DataBase.php";
$db = new DataBase();
if ((isset($_POST['product1']) || isset($_POST['product2']) || isset($_POST['product3'])) && isset($_POST['sum']) && isset($_POST['UID'])) {
    if ($db->dbConnect()) {
        if ($db->addrecord("shoppingrecord", $_POST['product1'], $_POST['product2'], $_POST['product3'], $_POST['sum'], $_POST['UID'])) {
            echo "Thank you";
        } else echo "add Failed";
    } else echo "Error: Database connection";
} else echo "All fields are required";

?>