let clickedOpen = false;
let activeDropdown = null;

function toggleDropdown(id, navItemElement) {
    const dropdown = document.getElementById(id);
    const sidebar = document.getElementById("sidebar");
    const arrow = navItemElement.querySelector(".arrowIcon .dropdown");

    const isAlreadyOpen = dropdown.classList.contains("visible");

    // Close all dropdowns
    document.querySelectorAll(".dropdown.visible").forEach(d => d.classList.remove("visible"));
    document.querySelectorAll(".navItem .dropdown.fa-caret-down").forEach(a => {
        a.classList.remove("fa-caret-down");
        a.classList.add("fa-caret-right");
    });
    sidebar.classList.remove("expanded");

    if (!isAlreadyOpen) {
        dropdown.classList.add("visible");
        arrow.classList.remove("fa-caret-right");
        arrow.classList.add("fa-caret-down");
        sidebar.classList.add("expanded");
        clickedOpen = true;
        activeDropdown = dropdown;
    } else {
        clickedOpen = false;
        activeDropdown = null;
    }
}

// Sidebar collapse on mouse leave if not clicked
document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");

    sidebar.addEventListener("mouseleave", () => {
        if (!clickedOpen && activeDropdown) {
            activeDropdown.classList.remove("visible");
            activeDropdown = null;
            sidebar.classList.remove("expanded");
        }
    });

    // Collapse if clicked outside
    document.addEventListener("click", function (e) {
        if (!sidebar.contains(e.target)) {
            if (clickedOpen && activeDropdown) {
                activeDropdown.classList.remove("visible");
                sidebar.classList.remove("expanded");
                clickedOpen = false;
                activeDropdown = null;
            }
        }
    });
});
