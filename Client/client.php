
<?php
function checklogin($requiredRole = null) {
    session_start();

    // Check if the user is trying to access a restricted page
    $restrictedPages = array("Client/client_record/view.php"); // Add other restricted pages here

    $currentPage = $_SERVER['PHP_SELF'];

    if (in_array($currentPage, $restrictedPages)) {
        if (!isset($_SESSION['client_email'])) {
            header("Location: ../../login.php");
            exit();
        }
        if ($requiredRole !== null && $_SESSION['client_role'] !== $requiredRole) {
            header("Location: unauthorized.php");
            exit();
        }
    }
}

?>