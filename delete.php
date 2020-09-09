<?php 
session_start();
require 'app/init.php';

if( !isset($_SESSION['login']) ){
    header('Location: /latihan/PHP-OOP/auth/');
    exit;
}

$crud = new Crud;

$msg = 'forbidden';
$status = 'error';

if( isset($_POST['id']) ){

    if( $crud->deleteData( $_POST['id'] ) > 0 ){
        $status = 'success';
        $msg = 'Data berhasil dihapus';
    } else {
        $status = 'error';
        $msg = 'Data gagal dihapus';
    }

}

$response = [
    'msg' => $msg,
    'status' => $status
];

echo json_encode($response);
?>