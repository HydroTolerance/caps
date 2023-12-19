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
  color: #6537AE;
}

#content-wrapper {
  width: 100%;
  position: absolute;
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
    <img src="../../t/images/zephy.png" height="38px" width="160px" style="margin-bottom: 20px;">
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
    <li>
        <a href="../clinic_account/clinic_account.php" >
            <i class="fs-4 bi-person-add"></i> <span class="ms-3">Clinic Account</span></a>
    </li>
    <li>
        <a href="#submenu4" data-bs-toggle="collapse" data-bs-target="#website-settings-submenu">
            <i class="fs-4 bi-grid"></i> <span class="ms-3">Website Settings</span>
        </a>
        <ul class="collapse nav flex-column ms-1" id="website-settings-submenu" data-bs-parent="#sidebar-wrapper">
            <li class="w-100">
                <a href="../faq/faq.php">
                    <span class="ms-3"> - <i class="bi-question-circle"></i> Frequently Ask</span>
                </a>
            </li>
            <li>
                <a href="../service/service.php">
                    <span class="ms-3"> - <i class="bi-collection"></i> Services</span>
                </a>
            </li>
            <li>
                <a href="../announcement/announcement.php">
                    <span class="ms-3"> - <i class="bi-megaphone"></i> Announcement</span>
                </a>
            </li>
            <li class="w-100">
                <a href="../slot/settings.php">
                    <span class="ms-3"> - <i class="bi-gear"></i> Settings</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="../activity/activity.php" >
        <i class="fs-4 bi-clipboard"></i> <span class="ms-3">Activity Log</span></a>
    </li>
    <li>
        <a href="../report/report.php" >
            <i class="fs-4 bi-folder"></i></i> <span class="ms-3">Generate Report </span> </a>
    </li>
  </ul>
</aside>


<?php
date_default_timezone_set('Asia/Manila');
include "../../db_connect/config.php";

function getAllNotifications($conn) {
    // Select notifications created within the last 7 days and not read
    $query = "SELECT * FROM notifications WHERE is_read = 0 AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $notifications = [];

    while ($notification = mysqli_fetch_assoc($result)) {
        $notifications[] = $notification;
    }

    return $notifications;
}

function getAllNotificationsForAllAppointments($conn) {
    // Select all notifications created within the last 7 days
    $query = "SELECT * FROM notifications WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $notifications = [];

    while ($notification = mysqli_fetch_assoc($result)) {
        $notifications[] = $notification;
    }

    return $notifications;
}

$allNotifications = getAllNotifications($conn);
$allNotificationsForAllAppointments = getAllNotificationsForAllAppointments($conn);
?>

<div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="bi bi-list"></i></a>
            </div>
            <div>
                <nav class="navbar navbar-light">
                    <div class="container-fluid d-flex justify-content-end">
                        <div class="dropdown mx-3">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none mx-auto" id="dropdownNotification" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5 "></i>
                                <span class="badge bg-danger" id="notificationCount"><?php echo count($allNotifications); ?></span>
                            </a>
                            <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownNotification" style="max-height: 200px; overflow-y: auto;">
                                <li class="position-sticky">
                                    <h1 class="dropdown-header text-center" style="color: #6537AE;">NOTIFICATIONS</h1>
                                </li>
                                <?php
                                function time_elapsed_string($datetime, $full = false) {
                                    $now = new DateTime;
                                    $ago = new DateTime($datetime);
                                    $diff = $now->diff($ago);

                                    $diff_in_seconds = $now->getTimestamp() - $ago->getTimestamp();

                                    $intervals = array(
                                        'year' => 31536000,
                                        'month' => 2592000,
                                        'week' => 604800,
                                        'day' => 86400,
                                        'hour' => 3600,
                                        'minute' => 60,
                                        'second' => 1,
                                    );

                                    $result = '';
                                    $count = 0;

                                    foreach ($intervals as $interval => $seconds) {
                                        $quotient = floor($diff_in_seconds / $seconds);

                                        if ($quotient > 0) {
                                            $count = $quotient;
                                            $result .= "$count $interval" . ($quotient > 1 ? 's' : '') . ' ago';
                                            break;
                                        }
                                    }
                                    if (empty($result)) {
                                        return 'just now';
                                    }

                                    return $result;
                                }
                                foreach ($allNotificationsForAllAppointments as $notification) :
                                  $timeElapsed = time_elapsed_string($notification['created_at']);
                              ?>
                                  <li>
                                      <a class="dropdown-item" href="../appointment/appointment.php?appointment_id=<?php echo $notification['appointment_id']; ?>">
                                          <span style="font-size: 16px;"><?php echo $notification['message']; ?> </span><br>
                                          <span style="color:#6537AE"><?php echo $timeElapsed; ?></span>
                                      </a>
                                  </li>
                              <?php endforeach; ?>
                          </ul>
                      </div>
                      <div class="dropdown">
                          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                              <img src="<?php echo $userData['image']; ?>" class="rounded-circle" height="30px" width="30px">
                              <span class="d-none d-sm-inline mx-1"><b> Hello!</b> <?php echo $userData['clinic_firstname']; ?></span>
                          </a>
                          <ul class="dropdown-menu text-small shadow dropdown-menu-end" aria-labelledby="dropdownUser1" style="color: #F8BE12;">
                                <li><a class="dropdown-item" href="../profile/account.php">Manage Account</a></li>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var notificationCount = document.getElementById('notificationCount');
        var notificationDropdown = document.getElementById('dropdownNotification');
        notificationDropdown.addEventListener('click', function () {
            notificationCount.textContent = '0';
        });
    });
</script>
<script>
    function markNotificationsAsRead() {
        // Make an AJAX request to update is_read to 1
        $.ajax({
            type: "POST",
            url: "../notification.php", // Create a separate PHP file to handle the update logic
            data: { mark_as_read: true },
            success: function(response) {
                // Optionally, you can handle the response from the server if needed
                console.log(response);
            },
            error: function(error) {
                // Handle errors if any
                console.error(error);
            }
        });
    }
    $('#dropdownNotification').on('click', function() {
        markNotificationsAsRead();
    });
</script>
<script>
  const $button  = document.querySelector('#sidebar-toggle');
const $wrapper = document.querySelector('#wrapper');

$button.addEventListener('click', (e) => {
  e.preventDefault();
  $wrapper.classList.toggle('toggled');
});
</script>
</body>
</html>