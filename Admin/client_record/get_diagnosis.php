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
<style>
    .fullscreen-modal {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 9999;
    }

    .fullscreen-image {
        max-width: 100%;
        max-height: 100%;
    }

    .close {
        color: white;
        font-size: 30px;
        position: absolute;
        top: 15px;
        right: 15px;
        cursor: pointer;
    }
</style>
<div class="modal-body">
    <form method="post"  enctype="multipart/form-data">
        <label for="edit_fname" class="form-label" style="color:#000; font-weight: 500; ">IMAGE</label><br>
        <div class="text-center">

            <?php
            $imagePath = "../../img/progress/{$rows['image']}";

            if (file_exists($imagePath) && is_file($imagePath)) {
                echo "<a href='#' onclick='openFullScreenImage(\"{$imagePath}\")'>
                        <img class='img-fluid' src='{$imagePath}' alt='' height='300px' width='300px'>
                      </a>";
            } else {
                echo "<p class='text-center'>No Image Inserted</p>";
            }
            ?>
        </div>

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="edit_fname" class="form-label" style="color:#000; font-weight: 500; ">DATE</label><br>
            <label ><?php echo date('M d, Y', strtotime($rows['date_diagnosis'])); ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label" style="color:#000; font-weight: 500; ">HISTORY</label><br>
            <label ><?php echo $rows['history']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_fname" class="form-label" style="color:#000; font-weight: 500; ">DIAGNOSIS</label><br>
            <label ><?php echo $rows['diagnosis']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label" style="color:#000; font-weight: 500; ">MANAGEMENT</label><br>
            <label ><?php echo $rows['management']; ?></label>
        </div>
        <div class="mb-3">
            <label for="edit_email" class="form-label" style="color:#000; font-weight: 500; ">NOTES</label><br>
            <label ><?php echo $rows['notes']; ?></label>
        </div>
    </form>
</div>
<script>
    function openFullScreenImage(imagePath) {
        var modal = document.createElement('div');
        modal.className = 'fullscreen-modal';
        modal.innerHTML = '<span class="close" onclick="closeFullScreenImage()">&times;</span>' +
            '<img class="fullscreen-image" src="' + imagePath + '" alt="">';
        document.body.appendChild(modal);
    }

    function closeFullScreenImage() {
        var modal = document.querySelector('.fullscreen-modal');
        if (modal) {
            document.body.removeChild(modal);
        }
    }
</script>
