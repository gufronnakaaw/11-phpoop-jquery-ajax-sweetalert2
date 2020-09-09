<?php 
session_start();
require 'app/init.php';

if( !isset($_SESSION['login']) ){
    header('Location: /latihan/PHP-OOP/auth/');
    exit;
}

$crud = new Crud;

$status = 'error';
$msg = 'forbidden';

$fileName = $_FILES['gambar_buku']['name'];
$imgSize = $_FILES['gambar_buku']['size'];
$imgError = $_FILES['gambar_buku']['error'];

$location = 'file/'. $fileName;
$validExtension = ['jpg', 'jpeg','png'];
$imgFileType = strtolower( pathinfo($location, PATHINFO_EXTENSION) );


if( isset($_POST['nama_buku']) ){
    
    if( empty($_POST['nama_buku']) && empty($_POST['tanggal_rilis']) && empty($_POST['penulis']) && empty($_POST['harga']) && $imgError == 4 ){
        $status = 'error';
        $msg = 'Data tidak boleh kosong!';
    } else if( empty($_POST['nama_buku']) ){
        $status = 'error';
        $msg = 'Nama buku tidak boleh kosong!';
    } else if( empty($_POST['tanggal_rilis']) ){
        $status = 'error';
        $msg = 'Tanggal rilis tidak boleh kosong!';
    } else if( empty($_POST['penulis']) ){
        $status = 'error';
        $msg = 'Penulis tidak boleh kosong!';
    } else if( empty($_POST['harga']) ){
        $status = 'error';
        $msg = 'Harga tidak boleh kosong!';
    } else if( $imgError == 4 ){
        $status = 'error';
        $msg = 'Gambar tidak boleh kosong!';
    } else if( $imgSize > 1500000 ){
        $status = 'error';
        $msg = 'Gambar terlalu besar!';
    } else if( !in_array( $imgFileType, $validExtension ) ){
        $status = 'error';
        $msg = 'Yang anda masukan bukan JPG, JPEG, PNG!';
    }else{
        
        if( $crud->insertData() > 0 ){
            $status = 'success';
            $msg = 'data berhasil di tambah';
        } else {
            $status = 'error';
            $msg = 'data gagal ditambahkan';
        }
    }
       
}

$response = [
    'msg' => $msg,
    'status' => $status
];

echo json_encode($response);
?>