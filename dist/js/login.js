$('#cekbox').click(function(){
    if( $(this).is(':checked') ){
        $('#password_login').attr('type', 'text');
    } else {
        $('#password_login').attr('type', 'password');
    }
});

$('#form_login').submit(function(e){
    e.preventDefault();

    let fd = new FormData(this);
    let url = $(this).attr('action');
    let method = $(this).attr('method');

    $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function(res){
            let data = JSON.parse(res);

            if(data.status == 'success'){
                window.location.href = '/latihan/PHP-OOP/';
            } else {
                Swal.fire({
                    title: `${data.status}`,
                    text: `${data.msg}`,
                    icon: `${data.status}`
                });
            }
            
        },
        error: function(){
            Swal.fire({
                title: 'Ups',
                text: 'Something Wrong!',
                icon: 'error'
            });
        }
    });
});