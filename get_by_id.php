<?php 
session_start();
require 'app/init.php';

$crud = new Crud;


if( isset($_POST['id']) ){
    
    $result = $crud->getDataById($_POST['id']);

}

echo json_encode($result);

?>