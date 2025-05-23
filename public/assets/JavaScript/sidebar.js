function toggleDropdown(id) {

    const dropdown = document.getElementById(id);
    const sidebar = document.getElementById("navBar");
    const navItem = dropdown.previousElementSibling;  // the .navItem before dropdown

    if (dropdown.classList.contains("visible")) {
        dropdown.classList.remove("visible");
        sidebar.classList.remove("expanded");
        // Change arrow back to right
        const arrow = navItem.querySelector(".dropdown");
        arrow.classList.remove("fa-caret-down");
        arrow.classList.add("fa-caret-right");
    } else {
        // Hide any other open dropdowns and reset arrows
        document.querySelectorAll(".dropdown.visible").forEach(d => d.classList.remove("visible"));
        document.querySelectorAll(".navItem .dropdown.fa-caret-down").forEach(arrow => {
            arrow.classList.remove("fa-caret-down");
            arrow.classList.add("fa-caret-right");
        });

        dropdown.classList.add("visible");
        sidebar.classList.add("expanded");

        // Change arrow to down for current navItem
        const arrow = navItem.querySelector(".dropdown");
        arrow.classList.remove("fa-caret-right");
        arrow.classList.add("fa-caret-down");
    }
}
        