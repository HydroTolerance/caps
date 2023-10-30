<?php
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}
?>

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

#wrapper {
  padding-left: 0;
  transition: all 0.5s ease;
  position: relative;
}

#sidebar-wrapper {
  z-index: 1000;
  position: fixed;
  left: 250px;
  width: 0;
  height: 100%;
  margin-left: -250px;
  overflow-y: auto;
  overflow-x: hidden;
  background: #6537AE;
  transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
  width: 250px;
}

.sidebar-brand {
  position: absolute;
  top: 0;
  width: 250px;
  text-align: center;
  padding: 20px 0;
}
.sidebar-brand h2 {
  margin: 0;
  font-weight: 600;
  font-size: 24px;
  color: #fff;
}

.sidebar-nav {
  position: absolute;
  top: 75px;
  width: 250px;
  margin: 0;
  padding: 0;
  list-style: none;
}
.sidebar-nav > li {
  text-indent: 10px;
  line-height: 42px;
}
.sidebar-nav > li a {
  display: block;
  text-decoration: none;
  color: #fff;
  font-weight: 600;
  font-size: 16px;
}
.sidebar-nav > li > a:hover,
.sidebar-nav > li.active > a {
  text-decoration: none;
  color: #000;
  background: #fff;

}
.sidebar-nav > li > a i.fa {
  font-size: 24px;
  width: 60px;
}
/* Purple Shit */
.bg-purple {
background-color: #6537AE;
}
.btn-outline-purple{
  border-color: #6537AE;
  color: #6537AE;
}
.bg-purple:hover{
            background-color: purple;
            color: white;
        }
        .btn-outline-purple:hover{
  border-color: purple;
color: purple;
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

@media (min-width: 992px) {
  #wrapper {
    padding-left: 250px;
  }
  
  #wrapper.toggled {
    padding-left: 60px;
  }

  #sidebar-wrapper {
    width: 250px;
  }
  
  #wrapper.toggled #sidebar-wrapper {
    width: 60px;
  }
  
  #wrapper.toggled #navbar-wrapper {
    position: absolute;
    margin-right: -190px;
}
  
  #wrapper.toggled #content-wrapper {
    position: absolute;
    margin-right: -190px;
  }

  #navbar-wrapper {
    position: relative;
  }

  #wrapper.toggled {
    padding-left: 60px;
  }

  #content-wrapper {
    position: relative;
    top: 0;
  }

  #wrapper.toggled #navbar-wrapper,
  #wrapper.toggled #content-wrapper {
    position: relative;
    margin-right: 60px;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  #wrapper {
    padding-left: 60px;
  }

  #sidebar-wrapper {
    width: 60px;
  }
  
#wrapper.toggled #navbar-wrapper {
    position: absolute;
    margin-right: -250px;
}
  
  #wrapper.toggled #content-wrapper {
    position: absolute;
    margin-right: -250px;
  }

  #navbar-wrapper {
    position: relative;
  }

  #wrapper.toggled {
    padding-left: 250px;
  }

  #content-wrapper {
    position: relative;
    top: 0;
  }

  #wrapper.toggled #navbar-wrapper,
  #wrapper.toggled #content-wrapper {
    position: relative;
    margin-right: 250px;
  }
}

@media (max-width: 767px) {
  #wrapper {
    padding-left: 0;
  }

  #sidebar-wrapper {
    width: 0;
  }

  #wrapper.toggled #sidebar-wrapper {
    width: 250px;
  }
  #wrapper.toggled #navbar-wrapper {
    position: absolute;
    margin-right: -250px;
  }

  #wrapper.toggled #content-wrapper {
    position: absolute;
    margin-right: -250px;
  }

  #navbar-wrapper {
    position: relative;
  }

  #wrapper.toggled {
    padding-left: 250px;
  }

  #content-wrapper {
    position: relative;
    top: 0;
  }

  #wrapper.toggled #navbar-wrapper,
  #wrapper.toggled #content-wrapper {
    position: relative;
    margin-right: 250px;
  }

}


</style>
<body>

<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
  <img src="../../t/images/zephy.png" alt="" height="38px" width="160px">
  </div>
  <ul class="sidebar-nav">
    <li class="nav-item">
        <a href="../dashboard/dashboard.php">
            <i class="fs-4 bi-speedometer2"></i> <span class="ms-3">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="../client_record/client_record.php" >
            <i class="fs-4 bi-people"></i> <span class="ms-3">Client Record</span></a>
    </li>
    <li>
        <a href="../appointment/appointment.php" >
            <i class="fs-4 bi-calendar-week"></i> <span class="ms-3">Appointment</span></a>
    </li>
  </ul>
</aside>
<div id="navbar-wrapper">
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="bi bi-list"></i></a>
      </div>
      <div>
      <nav class="navbar navbar-light">
        <div class="container-fluid d-flex justify-content-end">
          <div class="dropdown mx-4 width">
            <?php
            include "../../db_connect/config.php";
            $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment WHERE schedule_status IN ('Sched', 'Cancel');");
            $notificationCount = 0;
            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $notificationCount = mysqli_num_rows($result); // Count notifications
            }
            ?>

<a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownNotification" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fs-5 bi bi-bell"></i>
    <span id="notification-count" class="badge bg-danger"><?php echo $notificationCount; ?></span>
</a>
            <ul class="dropdown-menu text-small shadow dropdown-menu-end p-1" aria-labelledby="dropdownNotification">
              <?php
              include "../../db_connect/config.php";
              $stmt = mysqli_prepare($conn, "SELECT * FROM zp_appointment WHERE schedule_status IN ('Sched', 'Cancel');");
              $notificationCount = 0;

              if ($stmt) {
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);

                  while ($row = mysqli_fetch_assoc($result)) {
                      // Set data-read attribute to false initially
                      $dataRead = 'false';

                      // Check if the schedule_status is Sched or Cancel
                      if ($row['schedule_status'] == 'Sched') {
                          echo '<li data-read="' . $dataRead . '"><a class="dropdown-item" href="#">The client has rescheduled the appointment: ' . $row['firstname'] . ' ' . $row['lastname'] . '</a></li>';
                      } elseif ($row['schedule_status'] == 'Cancel') {
                          echo '<li data-read="' . $dataRead . '"><a class="dropdown-item" href="#">The client has canceled the appointment: ' . $row['firstname'] . ' ' . $row['lastname'] . '</a></li>';
                      }
                  }
                  // Close the database statement
                  mysqli_stmt_close($stmt);
              }
              ?>
              </ul>
          </div>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?php echo $userData['image']; ?>" class="rounded-circle" height="30px" width="30px">
              <span class="d-none d-sm-inline mx-1"><b> Hello!</b> <?php echo $userData['clinic_firstname']; ?></span>
            </a>
            <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1">
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