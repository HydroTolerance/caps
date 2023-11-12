$queryDidnotshow= "SELECT COUNT(*) as total_Didnotshow FROM zp_appointment WHERE appointment_status = 'Did not show' AND MONTH(date) = $currentYear";
        $resultDidnotshow= mysqli_query($conn, $queryDidnotshow);
        $rowDidnotshow= mysqli_fetch_assoc($resultDidnotshow);
        $totalDidnotshow= $rowDidnotshow['total_Didnotshow'];