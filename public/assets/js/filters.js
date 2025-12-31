let timer;
function autoSubmit(formId) {
    clearTimeout(timer);
    timer = setTimeout(() => {
        document.getElementById(formId).submit();
    }, 500);
}
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
        onClose: function (selectedDates, dateStr, instance) {
            if (dateStr) {
                // Find and submit the parent form dynamically
                const form = instance.element.closest('form');
                if (form) form.submit();
            }
        }
    });
});