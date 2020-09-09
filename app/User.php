<?php 
session_start();
require_once 'Database.php';

class User extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $usernameLogin = $_POST['username_login'];
        $passwordLogin = $_POST['password_login'];

        $query = "SELECT * FROM data_user WHERE username = ?";

        $stmt =  $this->conn->prepare($query);
        $stmt->bind_param('s', $usernameLogin);
        $stmt->execute();

        $result = $stmt->get_result();

        // cek username
        // mengembalikan true kalo ada usernamenya
        // mengembalikan false kalo tidak ada usernamenya
        if( $result->num_rows ){
            $row = $result->fetch_object();

            // cek password
            if( password_verify($passwordLogin, $row->password) ){
                $_SESSION['username'] = $row->username;
                $_SESSION['login'] = TRUE;
                return 1;
            } else {

                // return 2 berarti password salah
                return 2; 
            }
        } else {
            
            // return 3 berarti tidak ada username
            return 3;
        }
    }
}

