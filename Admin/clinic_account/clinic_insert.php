<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    </head>
    
    <body>
            <form method="post" action="insert_update_acc.php" enctype="multipart/form-data">
                    <!-- Add your input fields for the new account data here -->
                    <div class="mb-3">
                        <label for="image">Upload Image (Max 5MB):</label>
                        <input type="file" name="image" accept="image/*" id="image">
                    </div>
                    <div class="mb-3"> 
                        <label for="fname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="fname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <div class="input-group" id="show_hide_password">
                        <input class="form-control" type="password" name="password">
                        <div class="input-group-text">
                            <a href=""><i class="bi bi-eye-slash text-black" aria-hidden="true"></i></a>
                        </div>
                        </div>
                    </div>
                    <div class="mb-3">
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