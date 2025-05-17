// Admin panel JavaScript

// Sidebar toggle for mobile
document.addEventListener('DOMContentLoaded', function() {
    // Add responsive behavior for sidebar on small screens
    const toggleSidebar = document.getElementById('sidebarToggle');
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    }
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.classList.add('fade');
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
    
    // Initialize any date pickers
    const datePickers = document.querySelectorAll('.datepicker');
    if (datePickers.length && typeof flatpickr !== 'undefined') {
        datePickers.forEach(function(el) {
            flatpickr(el, {
                dateFormat: "Y-m-d"
            });
        });
    }
    
    // Initialize any time pickers
    const timePickers = document.querySelectorAll('.timepicker');
    if (timePickers.length && typeof flatpickr !== 'undefined') {
        timePickers.forEach(function(el) {
            flatpickr(el, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i"
            });
        });
    }
    
    // Table search functionality
    const tableSearch = document.getElementById('tableSearch');
    if (tableSearch) {
        tableSearch.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.querySelector('table');
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                if (text.indexOf(searchValue) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});