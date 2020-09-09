<?php 
require_once 'Database.php';

class Crud extends Database 
{

    public function __construct()
    {
        parent::__construct();
    }


    // get data
    public function getData()
    {
        $query = 'SELECT id,nama_buku,tanggal_rilis,penulis,harga,link_gambar FROM data_perpustakaan';
        
        $result = $this->conn->query($query);

        $rows = [];
        
        while($row = $result->fetch_object()){
            $rows[] = $row;
        }
        
        return $rows;
    }


    // get data by id
    public function getDataById($id)
    {
        $query = " SELECT id,nama_buku,tanggal_rilis,penulis,harga,link_gambar FROM data_perpustakaan WHERE id = ? ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_object();
    }

    // insert data
    public function insertData()
    {
        // initial date
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimezone($timezone);

        // generate data
        $nama_buku = $_POST['nama_buku'];
        $tanggal_rilis = $_POST['tanggal_rilis'];
        $penulis = $_POST['penulis'];
        $harga = $_POST['harga'];
        $created_at = $date->format('d-m-Y H:i:s');
        $created_by = $_SESSION['username'];
        
        if( $resultUpload = $this->uploadData($_FILES) ){
            $query = " INSERT INTO data_perpustakaan (nama_buku,tanggal_rilis,penulis,harga,link_gambar,created_at,created_by) VALUES (?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssssss', $nama_buku,$tanggal_rilis,$penulis,$harga,$resultUpload,$created_at,$created_by);
            $stmt->execute();

            return $this->conn->affected_rows;

        } else {
            return false;
        }
    }

    // update data
    public function updateData()
    {
        // initial date
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimezone($timezone);

        // generate data
        $id = $_POST['edit_id'];
        $nama_buku = $_POST['edit_nama_buku'];
        $tanggal_rilis = $_POST['edit_tanggal_rilis'];
        $penulis = $_POST['edit_penulis'];
        $harga = $_POST['edit_harga'];
        $updated_at = $date->format('d-m-Y H:i:s');
        $updated_by = $_SESSION['username'];
        
        if( $_FILES['edit_gambar_buku']['error'] == 4 ){
            $query = "UPDATE data_perpustakaan SET 
                            nama_buku = ?, 
                            tanggal_rilis = ?, 
                            penulis = ?, 
                            harga = ?,
                            updated_at = ?, 
                            updated_by = ? 
                            
                            WHERE id = ?";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssssss', $nama_buku,$tanggal_rilis,$penulis,$harga,$updated_at,$updated_by,$id);
            $stmt->execute();

            return $this->conn->affected_rows;
        } else {
            
            if( $resultUpload = $this->uploadData($_FILES) ){
                $query = "UPDATE data_perpustakaan SET 
                            nama_buku = ?, 
                            tanggal_rilis = ?, 
                            penulis = ?, 
                            harga = ?,
                            link_gambar = ?,
                            updated_at = ?, 
                            updated_by = ? 
                            
                            WHERE id = ?";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssssssss', $nama_buku,$tanggal_rilis,$penulis,$harga,$resultUpload,$updated_at,$updated_by,$id);
            $stmt->execute();

            return $this->conn->affected_rows;
            }
        }

        
    }

    // delete data
    public function deleteData($id)
    {
       $query = " DELETE FROM data_perpustakaan WHERE id = ? ";

       $stmt = $this->conn->prepare($query);
       $stmt->bind_param('s', $id);
       $stmt->execute();

       return $this->conn->affected_rows;
    }

    // upload data
    public function uploadData($data)
    {
        if( isset($data['edit_gambar_buku']) ){
            
            // update data
            $uniqId = uniqid();
            $fileName = $uniqId . '-' . $data['edit_gambar_buku']['name'];
            $tmpName = $data['edit_gambar_buku']['tmp_name'];
            $location = 'file/'. $fileName;

            if(  move_uploaded_file($tmpName, $location) ) {
                
                return $fileName;

            } else {

                return false;

            }

        } else {
            
            // insert data
            $uniqId = uniqid();
            $fileName = $uniqId . '-' . $data['gambar_buku']['name'];
            $tmpName = $data['gambar_buku']['tmp_name'];
            $location = 'file/'. $fileName;
            
            if(  move_uploaded_file($tmpName, $location) ) {
                
                return $fileName;
            
            } else {
            
                return false;
            
            }
        }
    }
}


?>