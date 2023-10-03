<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    </head>
    <style>
        .error {
        color: #F00;
        }
      </style>
    <script>
        $().ready(function () {
            $("#signUpForm").validate({
                rules: {
                    fname: "required",
                    lname: "required",
                    username: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    client_number:{
                        required: true,
                        minlength: 5,
                        number: true
                    },
                    gender:{
                        required: true,
                    },
                    password:{
                        required: true,
                        minlength: 8,
                    }
                },
                messages: {
                    client_emergency_contact_number: " Please enter Contact Person Number",
                    client_gender:{required: true,},
                    fname: " Please enter firstname",
                    lname: " Please enter lastname",
                    gender: " Please enter gender",
                    email: {
                        required: " Please enter a email",
                        email: "Please add '@' on your email"
                    },
                    password: {
                        minlength: "Please input a password atlease 8 characters",
                    }
                }
            });
        });
    </script>
    <body>
            <form method="post" id="signUpForm" enctype="multipart/form-data">
                    <!-- Add your input fields for the new account data here -->
                    <div class="mb-3">
                        <label for="image">Upload Image (Max 5MB):</label>
                        <input class="form-control" type="file" name="image" accept="image/*" id="image">
                    </div>
                    <div class="mb-3"> 
                        <label for="fname" class="form-label">Firstname: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">Lastname: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">Gender: <span class="text-danger">*</span></label>
                        <select class="form-control" name="gender" id="gender" required>
                            <option selected="true" disabled>-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email: <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password: <span class="text-danger">*</span></label>
                        <input class="form-control" type="password" name="password">
                        </div>
                    </div>
                    <div class="mb-3">
                    <label for="">Select Role: <span class="text-danger">*</span></label>
                    <select name="role" id="" class="form-control" required>
                      <option selected="true" disabled>-- Select Role --</option>
                      <option value="Derma">Derma</option>
                      <option value="Staff">Staff</option>
                    </select>
                    </div>
                    <button type="submit" name="submit" class="btn bg-purple text-white">Save</button>
                </form>
                <script>
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "bi bi-eye-slash" );
            $('#show_hide_password i').removeClass( "bi bi-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "bi bi-eye-slash" );
            $('#show_hide_password i').addClass( "bi bi-eye" );
        }
    });
});
    </script>
    </body>
</html>