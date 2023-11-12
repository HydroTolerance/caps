<?php
include "../../db_connect/config.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "SELECT * FROM zp_derma_record WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

?>

<div class="modal-body">
    <form method="post"  enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="edit_fname" class="form-label fw-bold">History</label>
            <input type="text" class="form-control" id="edit_fname" name="edit_history" value="<?php echo $rows['history']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label fw-bold">Diagnosis</label>
            <textarea type="text" class="form-control" id="edit_fname" name="edit_diagnosis" rows="5"  required><?php echo $rows['diagnosis']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label fw-bold">Management</label>
            <select class="select2 form-select" name="edit_management" style="width: 100%" required>
                <option value=""></option>
                <optgroup label="HAIR">
                    <option value="Face-to-face Hair Consultation" <?php if ($rows['management'] == 'Face-to-face Hair Consultation') echo 'selected'; ?>>Face-to-face Hair Consultation</option>
                    <option value="Laser Hair Removal" <?php if ($rows['management'] == 'Laser Hair Removal') echo 'selected'; ?>>Laser Hair Removal</option>
                    <option value="Platelet Rich Plasma" <?php if ($rows['management'] == 'Platelet Rich Plasma') echo 'selected'; ?>>Platelet Rich Plasma</option>
                </optgroup>
                <optgroup label="NAIL">
                    <option value="Face-to-face Nail Consultation" <?php if ($rows['management'] == 'Face-to-face Nail Consultation') echo 'selected'; ?>>Face-to-face Nail Consultation</option>
                </optgroup>
                <optgroup label="SKIN">
                    <option value="Face-to-face Skin Consultation" <?php if ($rows['management'] == 'Face-to-face Skin Consultation') echo 'selected'; ?>>Face-to-face Skin Consultation</option>
                </optgroup>
                <optgroup label="OTHER SERVICES">
                    <option value="HIFU" <?php if ($rows['management'] == 'HIFU') echo 'selected'; ?>>HIFU</option>
                    <option value="Skin biopsy" <?php if ($rows['management'] == 'Skin biopsy') echo 'selected'; ?>>Skin biopsy</option>
                    <option value="Cryolipolysis" <?php if ($rows['management'] == 'Cryolipolysis') echo 'selected'; ?>>Cryolipolysis</option>
                    <option value="Mohs Micrographic Surgery" <?php if ($rows['management'] == 'Mohs Micrographic Surgery') echo 'selected'; ?>>Mohs Micrographic Surgery</option>
                    <option value="Platelet Rich Plasma" <?php if ($rows['management'] == 'Platelet Rich Plasma') echo 'selected'; ?>>Platelet Rich Plasma</option>
                    <option value="Warts, Milia Removal" <?php if ($rows['management'] == 'Warts, Milia Removal') echo 'selected'; ?>>Warts, Milia Removal</option>
                    <option value="Chemical Peel" <?php if ($rows['management'] == 'Chemical Peel') echo 'selected'; ?>>Chemical Peel</option>
                    <option value="Syringoma Removal" <?php if ($rows['management'] == 'Syringoma Removal') echo 'selected'; ?>>Syringoma Removal</option>
                    <option value="Tattoo Removal" <?php if ($rows['management'] == 'Tattoo Removal') echo 'selected'; ?>>Tattoo Removal</option>
                    <option value="Dermalux - LED Phototherapy" <?php if ($rows['management'] == 'Dermalux - LED Phototherapy') echo 'selected'; ?>>Dermalux - LED Phototherapy</option>
                    <option value="Acne Treatment" <?php if ($rows['management'] == 'Acne Treatment') echo 'selected'; ?>>Acne Treatment</option>
                    <option value="Double Chin treatment" <?php if ($rows['management'] == 'Double Chin treatment') echo 'selected'; ?>>Double Chin treatment</option>
                    <option value="Botulinum toxin injection" <?php if ($rows['management'] == 'Botulinum toxin injection') echo 'selected'; ?>>Botulinum toxin injection</option>
                    <option value="Ear Keloid Removal" <?php if ($rows['management'] == 'Ear Keloid Removal') echo 'selected'; ?>>Ear Keloid Removal</option>
                    <option value="Excision of ear keloid" <?php if ($rows['management'] == 'Excision of ear keloid') echo 'selected'; ?>>Excision of ear keloid</option>
                    <option value="Treatment for Excessive Sweating" <?php if ($rows['management'] == 'Treatment for Excessive Sweating') echo 'selected'; ?>>Treatment for Excessive Sweating</option>
                    <option value="Sclerotherapy" <?php if ($rows['management'] == 'Sclerotherapy') echo 'selected'; ?>>Sclerotherapy</option>
                    <option value="Mole Removal" <?php if ($rows['management'] == 'Mole Removal') echo 'selected'; ?>>Mole Removal</option>
                    <option value="Melasma treatment" <?php if ($rows['management'] == 'Melasma treatment') echo 'selected'; ?>>Melasma treatment</option>
                    <option value="Fractional CO2 laser" <?php if ($rows['management'] == 'Fractional CO2 laser') echo 'selected'; ?>>Fractional CO2 laser</option>
                    <option value="Easy TCA Peel" <?php if ($rows['management'] == 'Easy TCA Peel') echo 'selected'; ?>>Easy TCA Peel</option>
                    <option value="Cyst / Tumor Excision" <?php if ($rows['management'] == 'Cyst / Tumor Excision') echo 'selected'; ?>>Cyst / Tumor Excision</option>
                    <option value="Electrocautery, Laser" <?php if ($rows['management'] == 'Electrocautery, Laser') echo 'selected'; ?>>Electrocautery, Laser</option>
                    <option value="Power Peel" <?php if ($rows['management'] == 'Power Peel') echo 'selected'; ?>>Power Peel</option>
                </optgroup>
            </select>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label fw-bold">Notes</label>
            <textarea type="text" class="form-control" id="edit_notes" name="edit_notes" rows="5"  required><?php echo $rows['notes']; ?></textarea>
        </div>
        <div class="modal-footer">
            <button type="submit" name="update_diagnosis" class="btn bg-purple text-white">Save</button>
        </div>
        
    </form>
</div>
