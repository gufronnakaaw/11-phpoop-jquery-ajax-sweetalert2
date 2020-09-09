<?php 
require_once '../app/User.php';

$user = new User;

$msg = 'forbidden';;
$sts = 'error';

if( isset($_POST['username_login']) ){
    $hasil = $user->login();

    if($hasil === 1){
        $msg = 'berhasil login';
        $sts = 'success';
    } else if($hasil === 2){
        $msg = 'password salah';
        $sts = 'error';
    } else if($hasil === 3){
        $msg = 'username tidak ada';
        $sts = 'error';
    }
}

$response = [
    'msg' => $msg,
    'status' => $sts
];

echo json_encode($response);
?>