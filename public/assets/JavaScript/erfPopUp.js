document.addEventListener("DOMContentLoaded", function () {
    const openPopupBtn = document.getElementById("openBankPopup");
    const popupContainer = document.querySelector(".popUpContainer");
    const closeBtn = document.querySelector(".closeBttn");

    openPopupBtn.addEventListener("click", function (e) {
        popupContainer.classList.add("active");
    });

    closeBtn.addEventListener("click", function () {
        popupContainer.classList.remove("active");
    });
});

