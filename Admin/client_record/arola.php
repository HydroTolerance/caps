<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../../db_connect/config.php";

    $id = $_POST['id'];
    $fname = $_POST['client_firstname'];
    $lname = $_POST['client_lastname'];
    $mname = $_POST['client_middle'];
    $sname = $_POST['client_suffix'];
    $dob = $_POST['client_birthday'];
    $gender = $_POST['client_gender'];
    $contact = $_POST['client_number'];
    $email = $_POST['client_email'];
    $econtact = $_POST['client_emergency_person'];
    $relation = $_POST['client_relation'];
    $econtactno = $_POST['client_emergency_contact_number'];
    $houseNumber = $_POST['client_house_number'];
    $streetName = $_POST['client_street_name'];
    $barangay = $_POST['client_barangay'];
    $city = $_POST['client_city'];
    $province = $_POST['client_province'];
    $postalCode = $_POST['client_postal_code'];

    // Perform the database update
    $sql_update = "UPDATE zp_client_record SET client_firstname = ?, client_lastname = ?, client_middle = ?, client_suffix = ?, client_birthday = ?, client_gender = ?, client_number = ?, client_email = ?, client_emergency_person = ?, client_relation = ?, client_emergency_contact_number = ?, client_house_number = ?, client_street_name = ?, client_barangay = ?, client_city = ?, client_province = ?, client_postal_code = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sssssssssssssssssi",
        $fname, $lname, $mname, $sname, $dob, $gender, $contact, $email, $econtact, $relation, $econtactno,
        $houseNumber, $streetName, $barangay, $city, $province, $postalCode, $id);

    if ($stmt_update->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
}
?>
