document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login_form");
    const loadingOverlay = document.getElementById("loadingOverlay");
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    // Show/hide password functionality
    togglePassword.addEventListener("click", () => {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        // Toggle the icon
        togglePassword.innerHTML = type === "password"
            ? '<i class="fa-solid fa-eye"></i>'
            : '<i class="fa-solid fa-eye-slash"></i>';
    });

    // Show loading overlay on form submission
    loginForm.addEventListener("submit", (e) => {
        loadingOverlay.classList.add("active");

        // Add a delay before submitting the form
        setTimeout(() => {
            loginForm.submit(); // Submit the form after the delay
        }, 2000); // 2-second delay
    });
});