document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login_form");
    const loadingOverlay = document.getElementById("loadingOverlay");

    loginForm.addEventListener("submit", (e) => {
        // Show the loading overlay
        loadingOverlay.classList.add("active");

        // Add a delay before submitting the form
        setTimeout(() => {
            loginForm.submit(); // Submit the form after the delay
        }, 2000); // 2-second delay
    });
});