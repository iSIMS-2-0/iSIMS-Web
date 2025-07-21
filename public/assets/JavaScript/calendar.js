document.addEventListener('click', function(e) {
    if (e.target.closest('.prev a') || e.target.closest('.next a')) {
        e.preventDefault();
        const link = e.target.closest('a');
        const month = link.dataset.month;
        const year = link.dataset.year;

        fetch(`calendar.php?month=${month}&year=${year}`)
            .then(response => response.text())
            .then(html => { 
                document.getElementById('calendarContainer').innerHTML = html;
            })
            .catch(err => console.error('Error loading calendar:', err));
    }
});