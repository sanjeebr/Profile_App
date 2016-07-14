$(".display").html('<h1>Page Under Construction</h1>');

$('#dashboard').on('click', function() {
    $('#link-dashboard').addClass('active');
    $('#link-role').removeClass('active');
    $('#link-privilege').removeClass('active');
    $('#link-assign-role').removeClass('active');
    $(".display").html('<h1>Page Under Construction</h1>');
});

$('#assign-role').on('click', function() {
    $('#link-assign-role').addClass('active');
    $('#link-dashboard').removeClass('active');
    $('#link-role').removeClass('active');
    $('#link-privilege').removeClass('active');
    $(".display").html('<h1>Assign Role</h1><br><div class="form-inline">'
        + '<div class="well" id="well"></div></div>');
    create_email_dropdown();
});

$('#role').on('click', function() {
    $('#link-role').addClass('active');
    $('#link-privilege').removeClass('active');
    $('#link-dashboard').removeClass('active');
    $('#link-assign-role').removeClass('active');
    $(".display").html('<h1>Create New Role</h1><br><div class="form-group well well-lg msg">'
        + '<div class="input-group">' + '<input type="text" class="form-control"'
        + ' id="name" placeholder="Role">' + '<span class="input-group-btn">'
        + '<button type="submit" class="btn btn-default" id="add-role">'
        + 'Create</button>' + '</span> </div>');
});

$('#privilege').on('click', function() {
    $('#link-privilege').addClass('active');
    $('#link-role').removeClass('active');
    $('#link-dashboard').removeClass('active');
    $('#link-assign-role').removeClass('active');
    $(".display").html('<h1>Add/Delete Privilege</h1><br><div class="form-inline">'
        + '<div class="well" id="well"></div></div>');
    create_resource_dropdown();
});

$(document).on('click', '#add-role', function() {
    $.ajax({
        url: 'role_privilege.php',
        data: {
            name : $('#name').val(),
            type : 'add_role',
        },
        type: 'POST',
        success: function(data) {
            $('.msg').append('<h3>' + $('#name').val() + ' Role was created</h3>');
            $('#name').val('');
        }
    });
});

function create_resource_dropdown() {
    $.ajax({
        url: 'role_privilege.php',
        data: {
            type : 'resource',
        },
        type: 'POST',
        success: function(data) {
            $("#well").append('<label>Resource: </label><select name="dropdown"'
                + ' class="form-control" id="resource-dropdown"></select>​');
            var obj = JSON.parse(data);
            for (var i = 1; i <= obj.length; i++) {
            var element_index = i-1;
            $("#resource-dropdown").append('<option value="' + obj[element_index].id
                + '">' + obj[element_index].name + '</option>');
            }
            create_role_dropdown();
        }
    });
}

function create_role_dropdown() {
    $.ajax({
        url: 'role_privilege.php',
        data: {
            type : 'role',
        },
        type: 'POST',
        success: function(data) {
            $("#well").append('<label>Role: </label><select name="dropdown"'
                + 'class="form-control" id="role-dropdown"></select>​');
            var obj = JSON.parse(data);
            for (var i = 1; i <= obj.length; i++) {
            var element_index = i-1;
            $("#role-dropdown").append('<option value="' + obj[element_index].id
                + '">' + obj[element_index].name + '</option>');
            }
            $("#well").append('<div id="checkbox-privilege" class="form-control"></div>​');
            create_privilege_checkbox();
        }
    });
}

function create_privilege_checkbox() {
    $.ajax({
        url: 'role_privilege.php',
        data: {
            resource : $('#resource-dropdown').val(),
            role : $('#role-dropdown').val(),
            type : 'privilege',
        },
        type: 'POST',
        success: function(data) {
            var obj = JSON.parse(data);
            for (var i = 1; i <= obj.length; i++) {
            var element_index = i-1;
            var is_checked =  (null !== obj[element_index].p_id) ? 'checked' : '';
            $("#checkbox-privilege").append('<label class="radio-inline">'
                + '<input type="checkbox" class="privilege" value="'
                + obj[element_index].id + '"' + is_checked + '>'
                + obj[element_index].name + '</label>');
            }
        }
    });
}

$(document).on('click', '.privilege', function() {
    var type;

    if($(this).prop("checked")) {
        type = 'add_privilege';
    } else {
        type = 'delete_privilege';
    }

    $.ajax({
            url: 'role_privilege.php',
            data: {
                privilege : $(this).val(),
                resource : $('#resource-dropdown').val(),
                role : $('#role-dropdown').val(),
                type : type,
            },
            type: 'POST'
        });
});

$(document).on('change', 'select[name="dropdown"]', function() {
    $("#checkbox-privilege").html('');
    create_privilege_checkbox();
});

function create_email_dropdown() {
    $.ajax({
        url: 'role_privilege.php',
        data: {
            type : 'email',
        },
        type: 'POST',
        success: function(data) {
            $("#well").append('<label>Email: </label><select name="emaildropdown"'
                + ' class="form-control" id="email-dropdown"></select>​');
            var obj = JSON.parse(data);
            for (var i = 1; i <= obj.length; i++) {
            var element_index = i-1;
            $("#email-dropdown").append('<option value="' + obj[element_index].id
                + '">' + obj[element_index].email +'</option>');
            }
            $("#well").append('<div id="radio-role" class="form-control"></div>​');
            create_role_radiobtn();
        }
    });
}

function create_role_radiobtn() {
    $.ajax({
        url: 'role_privilege.php',
        data: {
            e_id : $('#email-dropdown').val(),
            type : 'role-assign',
        },
        type: 'POST',
        success: function(data) {
            var obj = JSON.parse(data);
            for (var i = 1; i <= obj.length; i++) {
            var element_index = i-1;
            var is_checked =  (null !== obj[element_index].e_id) ? 'checked' : '';

            $("#radio-role").append('<label class="radio-inline">'
                + '<input type="radio" class="role-assign" name="role" value="'
                + obj[element_index].id + '"' +'id="'
                + obj[element_index].id + '"' + is_checked + '>'
                + obj[element_index].name + '</label>');
            }
        }
    });
}

$(document).on('click', '.role-assign', function() {
    $.ajax({
            url: 'role_privilege.php',
            data: {
                role : $(this).val(),
                e_id : $('#email-dropdown').val(),
                type : 'update_role',
            },
            type: 'POST'
        });
});

$(document).on('change', 'select[name="emaildropdown"]', function() {
    $("#radio-role").html('');
    create_role_radiobtn();
});