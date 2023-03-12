$(function(){
  
    $('#editUser').click(function () {
        var userUrl = $(this).data('url');
        $.get( userUrl  , function( data ) {
            $ ('#myModal').modal('show');
            console.log(data)
            $('#name').text(data.name);
            $('#email').text(data.email);
            $('#group').text(data.groupInt);
            $('#role').text(data.role);
        })
     });
     
});
