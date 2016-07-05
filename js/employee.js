$(document).ready(function() {
    $( 'form' ).on( 'submit', function() {

        $.ajax({
            url: 'ajax.php',
            data: {
                name : $('#name').val()
            },
            type: 'POST',
            success: function (data) {
                $(".table-responsive").html(data);
            }

        });


        return false;
    });
});