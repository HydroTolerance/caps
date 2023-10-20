<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<style>
  body {
  padding-bottom: 30px;
  position: relative;
  min-height: 100%;
}

a {
  transition: background 0.2s, color 0.2s;
}
a:hover,
a:focus {
  text-decoration: none;
}
#content-wrapper {
  width: 100%;
  position: absolute;
  padding: 15px;
  top: 100px;
}
/* Purple Shit */
.bg-purple {
background-color: #6537AE;
}
.btn-purple:hover{
            background-color: purple;
            color: white;
        }

#navbar-wrapper {
    width: 100%;
    position: absolute;
    z-index: 2;
}
#wrapper.toggled #navbar-wrapper {
    position: absolute;
    margin-right: -250px;
}
#navbar-wrapper .navbar {
  border-width: 0 0 0 0;
  background-color: #eee;
  font-size: 14px;
  margin-bottom: 0;
  border-radius: 0;
}
#navbar-wrapper .navbar a {
  color: #757575;
}
#navbar-wrapper .navbar a:hover {
  color: #F8BE12;
}

#content-wrapper {
  width: 100%;
  position: absolute;
  padding: 15px;
  top: 100px;
}
#wrapper.toggled #content-wrapper {
  position: absolute;
  margin-right: -250px;
}




</style>
<body>
<div id="navbar-wrapper">
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
      </div>
      <div>
      <nav class="navbar navbar-light">
        <div class="container-fluid d-flex justify-content-end">
            <div class="dropdown">
                  <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $userData['client_avatar']; ?>" class="rounded-circle" height="30px" width="30px">
                    <span class="d-none d-sm-inline mx-1"><b> Hello!</b> <?php echo $userData['client_firstname']; ?></span>
                  </a>
                <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1">
                  <li><a class="dropdown-item" >Settings</a></li>
                  <li><a class="dropdown-item" href="../profile/account.php">Profile</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>
    </nav>
      </div>
    </div>
  </nav>
</div>

</body>
</html>