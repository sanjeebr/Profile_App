$(document).ready(function() {
    $( 'form' ).on( 'submit', function() {

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

        return false;
    });

    $( '.pagination' ).on( 'click', function() {
        var curr = parseInt($('#page-no').val());
        if ('previous' === $(this).attr('id')) {
            $('#page-no').val(curr - 1);
        } else if ('next' === $(this).attr('id')) {
            $('#page-no').val(curr + 1);
        }
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

        return false;
    });

    function  display(data) {

                if ('no data' === data) {
                    $(".table-responsive").html('<div class="container text-center">'+
                        '<div class="alert alert-danger">'+
                        '<h2>No employee records.</h2>'+
                        '</div></div>'
                    );
                } else {
                    $(".table-body").empty();

                    var obj = JSON.parse(data);
                    for (var i = 1;i <= obj.length;i++) {
                        $(".table-body").append('<tr><td>' + i + '</td><td>'
                            + '<img src="' + obj[i-1].photo
                            + '" class="img-rounded" alt="profile_pic" width="160"'
                            + 'height="160">'
                            + '</td><td>'
                            + '<strong>Name:</strong>'
                            + obj[i-1].first_name + ' '
                            + obj[i-1].middle_name + ' '
                            + obj[i-1].last_name
                            + '<br><strong>Gender:</strong>'
                            + obj[i-1].gender
                            + '<br><strong>DOB:</strong>'
                            + obj[i-1].date_of_birth
                            + '<br><strong>Marital Status:</strong>'
                            + obj[i-1].marital
                            + '</td><td>'
                            + '<strong>Street:</strong>'
                            + obj[i-1].r_street
                            + '<br><strong>City:</strong>'
                            + obj[i-1].r_city
                            + '<br><strong>State:</strong>'
                            + obj[i-1].r_state
                            + '<br><strong>Pin no:</strong>'
                            + obj[i-1].r_pin
                            + '<br><strong>Phone no:</strong>'
                            + obj[i-1].r_phone
                            + '<br><strong>Fax no:</strong>'
                            + obj[i-1].r_fax
                            + '</td><td>'
                            + '<strong>Street:</strong>'
                            + obj[i-1].o_street
                            + '<br><strong>City:</strong>'
                            + obj[i-1].o_city
                            + '<br><strong>State:</strong>'
                            + obj[i-1].o_state
                            + '<br><strong>Pin no:</strong>'
                            + obj[i-1].o_pin
                            + '<br><strong>Phone no:</strong>'
                            + obj[i-1].o_phone
                            + '<br><strong>Fax no:</strong>'
                            + obj[i-1].o_fax
                            + '</td><td>'
                            + '<strong>Employment:</strong>'
                            + obj[i-1].employment
                            + '<br><strong>Employer:</strong>'
                            + obj[i-1].employer
                            + '<br><strong>Note:</strong>'
                            + obj[i-1].note
                            + '<br><strong>Communication:</strong>'
                            + obj[i-1].communication
                            + '</td></tr>'
                        );
                    }
                }

            };

});