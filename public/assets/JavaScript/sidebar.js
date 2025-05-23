        let clickedOpen = false;
        let activeDropdown = null;

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const sidebar = document.getElementById("sidebar");

            if (dropdown.classList.contains("visible")) {
                dropdown.classList.remove("visible");
                sidebar.classList.remove("expanded");
                clickedOpen = false;
                activeDropdown = null;
            } else {
                // Hide any other open dropdowns
                document.querySelectorAll(".dropdown.visible").forEach(d => d.classList.remove("visible"));

                dropdown.classList.add("visible");
                sidebar.classList.add("expanded");
                clickedOpen = true;
                activeDropdown = dropdown;
            }
        }

        // Hide dropdown when mouse leaves sidebar, only if not clicked
        const sidebar = document.getElementById("sidebar");
        sidebar.addEventListener("mouseleave", () => {
            if (!clickedOpen && activeDropdown) {
                activeDropdown.classList.remove("visible");
                activeDropdown = null;
            }
        });

        // Optional: collapse if clicked outside
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