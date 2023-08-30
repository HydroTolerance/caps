<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .sidebar-no-scroll {
            position: sticky;
            top: 0;
            height: 100%;
            overflow-y: auto;
            background-color: #6537AE;
            color: #fff;
        }
        .bg-purple {
            background-color: #6537AE;
        }
        .btn-purple:hover{
            background-color: purple;
            color: white;
        }
    </style>
</head>
<body>
    
<div class="col-auto  col-xl-2 col-md-3 px-sm-1 px-0 bg-purple sidebar-no-scroll">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline ms-5 mt-3  ">ZEPHYDERM</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu" >
                    <li class="nav-item">
                        <a href="../dashboard/dashboard.php" class="nav-link align-middle px-0 text-white">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../client_record/client_record.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Client Record</span></a>
                    </li>
                    <li>
                        <a href="../appointment/appointment.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-calendar-week"></i> <span class="ms-1 d-none d-sm-inline">Appointment</span></a>
                    </li>
                </ul>
                <hr>
                
            </div>
        </div>
        <script>
        $(window).on("load",function(){
          $(".loader-wrapper").fadeOut("slow");
        });
    </script>
</body>
</html>