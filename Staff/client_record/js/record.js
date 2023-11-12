
function showDiagnosisSection() {
        document.getElementById('diagnosisContainer').style.display = 'block';
        document.getElementById('appointmentContainer').style.display = 'none';
        document.getElementById('sessionContainer').style.display = 'none';
        document.getElementById('diagnosisTab').classList.add('active');
        document.getElementById('appointmentTab').classList.remove('active');
        document.getElementById('sessionTab').classList.remove('active');
    }

    function showAppointmentSection() {
        document.getElementById('diagnosisContainer').style.display = 'none';
        document.getElementById('appointmentContainer').style.display = 'block';
        document.getElementById('sessionContainer').style.display = 'none';
        document.getElementById('appointmentTab').classList.add('active');
        document.getElementById('diagnosisTab').classList.remove('active');
        document.getElementById('sessionTab').classList.remove('active');
    }

    function showSessionSection() {
        document.getElementById('diagnosisContainer').style.display = 'none';
        document.getElementById('appointmentContainer').style.display = 'none';
        document.getElementById('sessionContainer').style.display = 'block';
        document.getElementById('sessionTab').classList.add('active');
        document.getElementById('diagnosisTab').classList.remove('active');
        document.getElementById('appointmentTab').classList.remove('active');

        
    }
    

    document.getElementById('diagnosisTab').addEventListener('click', showDiagnosisSection);
    document.getElementById('sessionTab').addEventListener('click', showSessionSection);
    document.getElementById('appointmentTab').addEventListener('click', showAppointmentSection);
    

    
var configuration = {
    dateFormat: "Y-m-d",
    allowInput:true,
    minDate: new Date().fp_incr(1),
    maxDate: new Date().fp_incr(60),
    disable: [
        function(date) {
            return (date.getDay() === 2 || date.getDay() === 4 || date.getDay() === 0);
        }
    ]
};

flatpickr("#d", configuration);

d.addEventListener("change", updateTime);
function updateTime() {
    var d = document.getElementById("d").value;
    var time = document.getElementById("time");
    time.innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            var slots = response.slots;
            var slotsLeft = response.slots_left;

            for (var slot in slots) {
                var option = document.createElement("option");
                option.value = slot;
                option.text = slot;
                var num_bookings = slots[slot];
                var slotsLeftForOption = slotsLeft - num_bookings;
                if (slotsLeftForOption <= 0) {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                time.add(option);
                var slotText = option.text + " (" + slotsLeftForOption + " slot(s) left)";
                option.text = slotText;
            }

            var num_slots = Object.keys(slots).length;
            document.getElementById("num_slots").innerHTML = " (" + num_slots + " slots available)";
        }
    };
    xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(d), true);
    xmlhttp.send();
}

function showSuccessMessage(message, redirectUrl = null) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
    }).then(function(result) {
        if (result.isConfirmed && redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

// Function to show error message
function showErrorMessage(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: message,
    });
}
