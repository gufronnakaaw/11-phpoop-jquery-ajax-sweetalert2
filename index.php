<?php 
session_start();
require_once 'app/init.php';
require 'templates/header.php'; 


if( !isset($_SESSION['login']) ){
    header('Location: /latihan/PHP-OOP/auth/');
    exit;
}


$crud = new Crud;

$hasil = $crud->getData();

?>

<div id="preloader">
    <div id="loader"></div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="index.php">Perpustakaan</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
</div>
</nav>

<div class="container">
    
    <div class="float-right">
        <button class="btn btn-success mb-3 mt-3 btn-sm" id="btn-tambah" data-toggle="modal" data-target="#modal_tambah">Tambah Data</button>

        <a href="logout.php" class="btn btn-info mb-3 mt-3 btn-sm">Logout</a>
    </div>

    <table class="table text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        <?php if( $hasil ): ?>

            <?php $no = 1; foreach($hasil as $result): ?>
                <tr>
                    <td class="align-middle"><?= $no; ?></td>
                    <td>
                        <img src="file/<?= $result->link_gambar; ?>" width="80" height="80">
                    </td>
                    <td class="align-middle"><?= $result->nama_buku; ?></td>
                    <td class="align-middle">

                        <button class="btn btn-sm btn-warning btn-view" id="btn-view" data-id="<?= $result->id ?>">View</button>

                        <button class="btn btn-sm btn-info btn-edit" data-id="<?= $result->id ?>">Edit</button>

                        <button class="btn btn-sm btn-danger" id="btn-delete" data-id="<?= $result->id ?>">Delete</button>

                    </td>
                </tr>
            <?php $no++; endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="4">
                    <p>Data Empty</p>
                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>
</div>

<!-- modal tambah -->
<div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Tambah data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="insert.php" method="post" id="form_tambah" enctype="multipart/form-data" autocomplete="off">
                <label for="nama_buku">Nama buku</label>
                <input type="text" class="form-control" id="nama_buku" name="nama_buku">
                <label for="tanggal_rilis">Tanggal rilis</label>
                <input type="text" class="form-control" id="tanggal_rilis" name="tanggal_rilis">
                <label for="penulis">Penulis</label>
                <input type="text" class="form-control" id="penulis" name="penulis">
                <label for="harga">Harga</label>
                <input type="text" class="form-control" id="harga" name="harga">
                <div class="custom-file">
                    <input type="file" id="gambar_buku" class="custom-file-input" name="gambar_buku">
                    <label for="gambar_buku" class="custom-file-label mt-3">Choose file</label>
                </div>
            
        </div>
        <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="btn-tambah-data" name="btn-tambah-data">Tambah</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal edit -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal_edit">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form autocomplete="off" action="update.php" method="post" id="form_edit" enctype="multipart/form-data">
                <div class="mb-3 d-flex justify-content-center">
                    <img src="" id="edit_img" width="180" height="180">
                </div>
                <input type="hidden" id="edit_id">
                <label for="edit_nama_buku"  style="display: block;">Nama buku</label>
                <input type="text" class="form-control" id="edit_nama_buku" name="edit_nama_buku" required>
                <label for="edit_tanggal_rilis">Tanggal rilis</label>
                <input type="text" class="form-control" id="edit_tanggal_rilis" name="edit_tanggal_rilis" required>
                <label for="edit_penulis">Penulis</label>
                <input type="text" class="form-control" id="edit_penulis" name="edit_penulis" required>
                <label for="edit_harga">Harga</label>
                <input type="text" class="form-control" id="edit_harga" name="edit_harga" required>
                <div class="custom-file">
                    <input type="file" id="edit_gambar_buku" class="custom-file-input" name="edit_gambar_buku">
                    <label for="edit_gambar_buku" class="custom-file-label mt-3">Choose file</label>
                </div>
            
        </div>
        <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info" id="btn-edit-data">Edit</button>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- modal view -->
<div class="modal fade" id="modal_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="mb-3 d-flex justify-content-center">
                <img src="" id="view_img" width="180" height="180">
            </div>
            <label for="view_nama_buku">Nama Buku</label>
            <input type="text" class="form-control" id="view_nama_buku" disabled>          
            <label for="view_tanggal_rilis">Tanggal Rilis</label>          
            <input type="text" class="form-control" id="view_tanggal_rilis" disabled>          
            <label for="view_penulis">Penulis</label>          
            <input type="text" class="form-control" id="view_penulis" disabled>          
            <label for="view_harga">Harga</label>          
            <input type="text" class="form-control" id="view_harga" disabled>          
        </div>
        </div>
    </div>
</div>

<?php include('templates/footer.php') ?>