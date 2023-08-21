<!DOCTYPE html>
<html>
<head>
  <title>Disable Specific Days in Flatpickr</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
  </style>
</head>
<body>
  <form id="myForm">
    <label>
      <input type="checkbox" id="disableMonday"> Monday
    </label>
    <label>
      <input type="checkbox" id="disableSunday"> Sunday
    </label>

    <input type="text" id="myDate">

    <button type="submit">Submit</button>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    const disableMondayCheckbox = document.getElementById('disableMonday');
    const disableSundayCheckbox = document.getElementById('disableSunday');
    const dateInput = document.getElementById('myDate');
    const form = document.getElementById('myForm');
    let flatpickrInstance;

    flatpickrInstance = flatpickr(dateInput, {
      dateFormat: 'Y-m-d',
      allowInput: true,
      onChange: (selectedDates, dateStr, instance) => {
        const selectedDate = new Date(dateStr);
        const selectedDay = selectedDate.getDay();

        if (
          (selectedDay === 1 && disableMondayCheckbox.checked) ||
          (selectedDay === 0 && disableSundayCheckbox.checked)
        ) {
          instance.clear();
          alert('This date is disabled. Please choose another date.');
        }
      }
    });

    disableMondayCheckbox.addEventListener('change', () => {
      toggleDayAvailability(1, disableMondayCheckbox.checked);
    });

    disableSundayCheckbox.addEventListener('change', () => {
      toggleDayAvailability(0, disableSundayCheckbox.checked);
    });

    function toggleDayAvailability(dayIndex, disabled) {
      const disabledDates = flatpickrInstance.config.disabled || [];

      if (disabled) {
        const currentDate = new Date();
        const offset = currentDate.getDay() <= dayIndex ? dayIndex - currentDate.getDay() : 7 - currentDate.getDay() + dayIndex;
        currentDate.setDate(currentDate.getDate() + offset);
        const formattedDate = currentDate.toISOString().split('T')[0];
        disabledDates.push(formattedDate);
      } else {
        const currentDate = new Date();
        const offset = currentDate.getDay() <= dayIndex ? dayIndex - currentDate.getDay() : 7 - currentDate.getDay() + dayIndex;
        currentDate.setDate(currentDate.getDate() + offset);
        const formattedDate = currentDate.toISOString().split('T')[0];
        const index = disabledDates.indexOf(formattedDate);
        if (index !== -1) {
          disabledDates.splice(index, 1);
        }
      }

      flatpickrInstance.set('disable', disabledDates);
    }
  </script>
</body>
</html>
