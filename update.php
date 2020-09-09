<?php 
session_start();
require 'app/init.php';

if( !isset($_SESSION['login']) ){
    header('Location: /latihan/PHP-OOP/auth/');
    exit;
}

$crud = new Crud;

$msg = 'forbidden';
$status  = 'error';

if( isset($_POST['edit_nama_buku']) ){

    if( $crud->updateData() > 0 ){
        $msg = 'update berhasil';
        $status = 'success';
    } else {
        $msg = 'tidak ada yang di update!';
        $status = 'error';
    }

}

$response = [
    'msg' => $msg,
    'status' => $status
];

echo json_encode($response);

?>