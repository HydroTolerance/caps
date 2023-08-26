function handleInsertResponse(success) {
    if (success) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Data Updated successfully.'
        }).then(function() {
            window.location.href = '.edit_client_record.php?id=' + id;
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to add data.'
        });
    }
};




/* window.addEventListener('DOMContentLoaded', (event) => {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Data Updated successfully.'
    }).then(function() {
        window.location.href = 'edit_client_record.php?id=" . $id . "';
    });
});

window.addEventListener('DOMContentLoaded', (event) => {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Failed to add data.'
    });
});

window.addEventListener('DOMContentLoaded', (event) => {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Data Updated successfully.'
    }).then(function() {
        window.location.href = 'client_record.php';
    });
});

window.addEventListener('DOMContentLoaded', (event) => {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Failed to add data.'
    });
}); */