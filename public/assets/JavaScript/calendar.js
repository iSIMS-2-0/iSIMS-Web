document.addEventListener('click', function(e) {
    if (e.target.closest('.prev a') || e.target.closest('.next a')) {
        e.preventDefault();
        const link = e.target.closest('a');
        const month = link.dataset.month;
        const year = link.dataset.year;

        // Redirect to the new calendar page with the correct routing
        window.location.href = `/public/index.php?page=home&month=${month}&year=${year}`;
    }
});