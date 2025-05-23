let clickedOpen = false;
let activeDropdown = null;
let activeArrow = null; // Track the currently active arrow

function toggleDropdown(id, navItemElement) {
    const dropdown = document.getElementById(id);
    const sidebar = document.getElementById("sidebar");
    const arrow = navItemElement.querySelector(".arrowIcon i"); // Corrected selector

    const isAlreadyOpen = dropdown.classList.contains("visible");

    // Close all dropdowns and reset arrows
    document.querySelectorAll(".dropdown.visible").forEach(d => d.classList.remove("visible"));
    document.querySelectorAll(".arrowIcon i").forEach(a => {
        a.classList.remove("fa-caret-down");
        a.classList.add("fa-caret-right");
    });
    sidebar.classList.remove("expanded");
    sidebar.classList.remove("dropdown-open");

    if (!isAlreadyOpen) {
        dropdown.classList.add("visible");
        arrow.classList.remove("fa-caret-right");
        arrow.classList.add("fa-caret-down");
        sidebar.classList.add("expanded");
        sidebar.classList.add("dropdown-open");

        clickedOpen = true;
        activeDropdown = dropdown;
        activeArrow = arrow;
    } else {
        clickedOpen = false;
        activeDropdown = null;
        activeArrow = null;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");

    sidebar.addEventListener("mouseleave", () => {
        if (!clickedOpen && activeDropdown) {
            activeDropdown.classList.remove("visible");
            sidebar.classList.remove("expanded");
            sidebar.classList.remove("dropdown-open");
            activeDropdown = null;
        }
    });

    document.addEventListener("click", function (e) {
        if (!sidebar.contains(e.target)) {
            if (clickedOpen && activeDropdown) {
                activeDropdown.classList.remove("visible");
                if (activeArrow) {
                    activeArrow.classList.remove("fa-caret-down");
                    activeArrow.classList.add("fa-caret-right");
                }
                sidebar.classList.remove("expanded");
                sidebar.classList.remove("dropdown-open");
                clickedOpen = false;
                activeDropdown = null;
                activeArrow = null;
            }
        }
    });
});
