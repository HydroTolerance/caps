// Initialize Summernote on the textarea
$(document).ready(function() {
    $('#summernote').summernote({
        height: 200 // You can adjust the height as needed
    });
    $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },
        events: 'get_schedule.php',
        eventClick: function(event) {
            // Handle event click here
            alert('Event clicked: ' + event.title);
        }
    });
});
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

function updateTime() {
    var selectedDate = d.value;
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
    xmlhttp.open("GET", "get_slot.php?d=" + encodeURIComponent(selectedDate), true);
    xmlhttp.send();
}
        