
    const diagnosisContainer = document.getElementById('diagnosisContainer');
const appointmentContainer = document.getElementById('appointmentContainer');

function showDiagnosis() {
    diagnosisContainer.style.display = 'block';
    appointmentContainer.style.display = 'none';
}   

function showAppointment() {
    diagnosisContainer.style.display = 'none';
    appointmentContainer.style.display = 'block';
}
var configuration = {
    dateFormat: "Y-m-d",
    minDate: new Date().fp_incr(1),
    maxDate: new Date().fp_incr(60),
    disable: [
        function(date) {
            return (date.getDay() === 2 || date.getDay() === 4 || date.getDay() === 0);
        }
    ]
};

flatpickr("#d", configuration);
var d = document.getElementById("d");
var time = document.getElementById("time");

d.addEventListener("change", updateTime);

document.getElementById("d").addEventListener("change", updateTime);

// Initial time slots update when the page loads
updateTime();

function updateTime() {
    var d = document.getElementById("d").value;
    var timeSelect = document.getElementById("time");
    timeSelect.innerHTML = "";

    // Send an AJAX request to get available time slots
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            var slots = response.slots;
            var slotsLeft = response.slots_left;

            for (var slot in slots) {
                var option = document.createElement("option");
                option.value = slot;
                var num_bookings = slots[slot];
                var slotsLeftForOption = slotsLeft - num_bookings;
                if (slotsLeftForOption <= 0) {
                    option.disabled = true;
                    slotsLeftForOption = 0;
                }
                option.text = slot + " (" + slotsLeftForOption + " slot(s) left)";
                timeSelect.appendChild(option);
            }
        }
    };
    xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(d), true);
    xmlhttp.send();
}
