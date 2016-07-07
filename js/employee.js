$(document).ready(function() {
    create_display_table();
    get_employee();

    $( 'form' ).on( 'submit', function() {
        $('#page-no').val('0');
        get_employee();

        return false;
    });

    $( '.sorting' ).on( 'click', function() {
        if ('ASC' === $(this).attr('name')) {
            $('.sorting').attr('name',"DESC");
            $(this).html('<span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>');
        } else {
            $('.sorting').attr('name',"ASC");
            $(this).html('<span class="glyphicon glyphicon-sort-by-alphabet"></span>');
        }
        get_employee();

        return false;
    });

    $( '.pagination' ).on( 'click', function() {
        var curr = parseInt($('#page-no').val());
        if ('previous' === $(this).attr('id')) {
            if ('0' < $('#page-no').val()) {
                $('#page-no').val(curr - 1);
            } else {
                $('#previous').addClass('disabled');
            }
        } else if ('next' === $(this).attr('id')) {
            $('#previous').removeClass('disabled');
            $('#page-no').val(curr + 1);
        }
        get_employee();

        return false;
    });
});

function display(data) {
    if ('no data' === data) {
        $(".display").html('<div class="container text-center">'+
            '<div class="alert alert-danger">'+
            '<h2>No employee records.</h2>'+
            '</div></div>'
        );
    } else {
        create_display_table();
        var obj = JSON.parse(data);

        for (var i = 1; i <= obj.length; i++) {
            var element_index = i-1;
            var serial_no = $('#page-no').val()*2  + i;
            $(".table-body").append('<tr><td>' + serial_no + '</td><td>'
                + '<img src="' + obj[element_index].photo
                + '" class="img-rounded" alt="profile_pic" width="160"'
                + 'height="160">'
                + '</td><td>'
                + '<strong>Name:</strong>'
                + obj[element_index].first_name + ' '
                + obj[element_index].middle_name + ' '
                + obj[element_index].last_name
                + '<br><strong>Gender:</strong>'
                + obj[element_index].gender
                + '<br><strong>DOB:</strong>'
                + obj[element_index].date_of_birth
                + '<br><strong>Marital Status:</strong>'
                + obj[element_index].marital
                + '</td><td>'
                + '<strong>Street:</strong>'
                + obj[element_index].r_street
                + '<br><strong>City:</strong>'
                + obj[element_index].r_city
                + '<br><strong>State:</strong>'
                + obj[element_index].r_state
                + '<br><strong>Pin no:</strong>'
                + obj[element_index].r_pin
                + '<br><strong>Phone no:</strong>'
                + obj[element_index].r_phone
                + '<br><strong>Fax no:</strong>'
                + obj[element_index].r_fax
                + '</td><td>'
                + '<strong>Street:</strong>'
                + obj[element_index].o_street
                + '<br><strong>City:</strong>'
                + obj[element_index].o_city
                + '<br><strong>State:</strong>'
                + obj[element_index].o_state
                + '<br><strong>Pin no:</strong>'
                + obj[element_index].o_pin
                + '<br><strong>Phone no:</strong>'
                + obj[element_index].o_phone
                + '<br><strong>Fax no:</strong>'
                + obj[element_index].o_fax
                + '</td><td>'
                + '<strong>Employment:</strong>'
                + obj[element_index].employment
                + '<br><strong>Employer:</strong>'
                + obj[element_index].employer
                + '<br><strong>Note:</strong>'
                + obj[element_index].note
                + '<br><strong>Communication:</strong>'
                + obj[element_index].communication
                + '</td></tr>'
            );
        }
    }

};

function create_display_table() {
    $(".display").html(
        '<div  class="table-responsive">'
        +'<h2>Employee Details</h2>'
        +'<table class="table table-hover">'
        +'<thead>'
        +'<tr>'
        +'<th><h4><strong>Serial No</strong></h4></th>'
        +'<th><h4><strong>Photo</strong></h4></th>'
        +'<th><h4><strong>Personal Info</strong></h4></th>'
        +'<th><h4><strong>Residence Address</strong></h4></th>'
        +'<th><h4><strong>Office Address</strong></h4></th>'
        +'<th><h4><strong>Other Info</strong></h4></th>'
        +'</tr>'
        +'</thead>'
        +'<tbody class="table-body">'
        +'</tbody>'
        +'</table>'
        +'</div>'
    );
} ;

function get_employee() {
    $.ajax({
        url: 'ajax.php',
        data: {
            name : $('#name').val(),
            order : $('.sorting').attr('name'),
            page : $('#page-no').val()
        },
        type: 'POST',
        success: display
    });
}