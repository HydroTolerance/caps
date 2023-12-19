function showInsertModal(id) {
    verifyAdminPassword('create', () => {
    $.ajax ({
        url: 'clinic_insert.php',
        type: 'POST',
        data: {id: id},
        success: function(response){
            $('#insertAccount .modal-body').html(response);
            $('#insertAccount').modal('show');
        }

    });
});
}
function showData(id) {
    verifyAdminPassword('edit', () => {
$.ajax({
    url: 'clinic_edit.php',
    type: 'POST',
    data: { id: id },
    success: function (response) {
        $('#displayAccount .modal-body').html(response);
        $('#displayAccount').modal('show');
    }
});
});
}
function statusAccount(id, action) {
    verifyAdminPassword('create', () => {
    let statusText = action === 'deactivate' ? 'deactivated' : 'activated';
    let confirmationText = `Are you sure you want to ${statusText} this account?`;
    let confirmButtonColor = action === 'deactivate' ? '#d33' : '#28a745';

    Swal.fire({
        title: `Confirm ${statusText.charAt(0).toUpperCase() + statusText.slice(1)}`,
        text: confirmationText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: '#3085d6',
        confirmButtonText: `Yes, ${statusText} it!`,
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'deactivate_account.php',
                type: 'POST',
                data: { id: id, action: action },
                success: function (response) {
                    let successText = `The account has been ${statusText} successfully.`;
                    Swal.fire({
                        title: `${statusText.charAt(0).toUpperCase() + statusText.slice(1)}!`,
                        text: successText,
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: true
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    // Show an error message using SweetAlert2
                    Swal.fire({
                        title: 'Error',
                        text: `An error occurred while ${statusText}ing the account. Please try again later.`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
});
}
