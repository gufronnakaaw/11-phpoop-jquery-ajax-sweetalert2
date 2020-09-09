$(document).ready(function(){

var preloader = $('#preloader');

// tambah section
$('#form_tambah').submit(function(e){
    e.preventDefault();

    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var fd = new FormData(this);

    $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function(res){
            let data = JSON.parse(res);

            if(data.status == 'success'){
                Swal.fire({
                    title: `${data.status}`,
                    text: `${data.msg}`,
                    icon: `${data.status}`
                }).then(function () {
                    $('#modal_tambah').modal('hide');
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: `${data.status}`,
                    text: `${data.msg}`,
                    icon: `${data.status}`
                });
            }
        },
        error: function(){

        } 
    }); 
});
// end tambah section


// view section

// with id
// $( document ).on('click', '#btn-view', function(){
//     var id = $(this).data('id');
//     preloader.show();

//     $.ajax({
//         url: 'get_by_id.php',
//         method: 'post',
//         data: {id},
//         success: function(res){
//             preloader.hide();

//             let data = JSON.parse(res);

//             $('#view_img').attr('src', `file/${data.link_gambar}`);
//             $('#view_nama_buku').val(data.nama_buku);
//             $('#view_penulis').val(data.penulis);
//             $('#view_tanggal_rilis').val(data.tanggal_rilis);
//             $('#view_harga').val(data.harga);
//         },
//         error: function(){

//             setTimeout(() => {
//                 preloader.hide();
            
//                 Swal.fire({
//                     title: 'Cannot view data',
//                     text: 'Please check your connection',
//                     icon: 'error'
//                 }).then(function(){
//                     $('#modal_view').modal('hide');
//                 });
//             }, 2000);

//         }
//     });
// });

// with class
$('.btn-view').click(function(){
    $('#modal_view').modal('show');

    var id = $(this).data('id');

    preloader.show();

    $.ajax({
        url: 'get_by_id.php',
        method: 'post',
        data: {id},
        success: function(res){
            preloader.hide();

            let data = JSON.parse(res);

            $('#view_img').attr('src', `file/${data.link_gambar}`);
            $('#view_nama_buku').val(data.nama_buku);
            $('#view_penulis').val(data.penulis);
            $('#view_tanggal_rilis').val(data.tanggal_rilis);
            $('#view_harga').val(data.harga);
        },
        error: function(){

            setTimeout(() => {
                preloader.hide();
            
                Swal.fire({
                    title: 'Cannot view data',
                    text: 'Please check your connection',
                    icon: 'error'
                }).then(function(){
                    $('#modal_view').modal('hide');
                });
            }, 2000);

        }
    });
});

$('.btn-edit').click(function(){
    $('#modal_edit').modal('show');
    preloader.show();

    var id = $(this).data('id');

    $.ajax({
        url: 'get_by_id.php',
        method: 'post',
        data: {id},
        success: function(res){
            preloader.hide();

            let data = JSON.parse(res);

            $('#edit_id').val(data.id);
            $('#edit_img').attr('src', `file/${data.link_gambar}`);
            $('#edit_nama_buku').val(data.nama_buku);
            $('#edit_penulis').val(data.penulis);
            $('#edit_tanggal_rilis').val(data.tanggal_rilis);
            $('#edit_harga').val(data.harga);
        },
        error: function(){

            setTimeout(() => {
                preloader.hide();
            
                Swal.fire({
                    title: 'Cannot show update data',
                    text: 'Please check your connection',
                    icon: 'error'
                }).then(function(){
                    $('#modal_edit').modal('hide');
                });
            }, 2000);

        }
    });
})

// edit section
// $( document ).on('click', '#btn-edit', function(){
//     preloader.show();

//     var id = $(this).data('id');

//     $.ajax({
//         url: 'get_by_id.php',
//         method: 'post',
//         data: {id},
//         success: function(res){
//             preloader.hide();

//             let data = JSON.parse(res);

//             $('#edit_id').val(data.id);
//             $('#edit_img').attr('src', `file/${data.link_gambar}`);
//             $('#edit_nama_buku').val(data.nama_buku);
//             $('#edit_penulis').val(data.penulis);
//             $('#edit_tanggal_rilis').val(data.tanggal_rilis);
//             $('#edit_harga').val(data.harga);
//         },
//         error: function(){

//             setTimeout(() => {
//                 preloader.hide();
            
//                 Swal.fire({
//                     title: 'Cannot show update data',
//                     text: 'Please check your connection',
//                     icon: 'error'
//                 }).then(function(){
//                     $('#modal_edit').modal('hide');
//                 });
//             }, 2000);

//         }
//     });
// });


$('#form_edit').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    let url = $(this).attr('action');
    let method = $(this).attr('method');
    let id = $('#edit_id').val();
    fd.append('edit_id',id);
    
    $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function(res){
            let data = JSON.parse(res);

            if(data.status == 'success'){
                Swal.fire({
                    title: `${data.status}`,
                    text: `${data.msg}`,
                    icon: `${data.status}`
                }).then(function () {
                    $('#modal_edit').modal('hide');
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: `${data.status}`,
                    text: `${data.msg}`,
                    icon: `${data.status}`
                });
            }
        }
    })
    
});
// end edit section


// delete section
$( document ).on('click', '#btn-delete', function(){
    var id = $(this).data('id');

    Swal.fire({
        title: 'Yakin',
        text: "Data anda akan hilang!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'delete.php',
                method: 'post',
                data: { id },
                success: function (res) {
                    let data = JSON.parse(res);

                    if (data.status == 'success') {
                        Swal.fire({
                            text: `${data.msg}`,
                            title: `${data.status}`,
                            icon: `${data.status}`
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                }, 
                error: function(){ 
                    preloader.show();

                    setTimeout(() => {
                        preloader.hide();

                        Swal.fire({
                            title: 'Something Wrong!',
                            text: 'Cannot delete data',
                            icon: 'error'
                        });

                    }, 2000);

                }
            });
        }
    })
})


// on hide
$('#modal_view').on('hide.bs.modal',function(){
    $('#view_img').attr('src', '');
    $('#view_nama_buku').val('');
    $('#view_penulis').val('');
    $('#view_tanggal_rilis').val('');
    $('#view_harga').val('');
});

$('#modal_edit').on('hide.bs.modal',function(){
    $('#edit_img').attr('src', '');
    $('#edit_nama_buku').val('');
    $('#edit_penulis').val('');
    $('#edit_tanggal_rilis').val('');
    $('#edit_harga').val('');
    $('#edit_id').removeAttr('value');
});


$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
});