document.addEventListener("DOMContentLoaded", function() {
    const discloseGender = document.getElementById("studentGender");
    const genderInput = document.querySelector(".genderInput");

    function toggleGender(){
        if(discloseGender.checked){
            genderInput.style.display = "flex";
        } else {
            genderInput.style.display = "none";
        }
    }

    discloseGender.addEventListener("change", toggleGender);
});


document.addEventListener("DOMContentLoaded", function() {
    const yesRadio = document.getElementById("yes");
    const noRadio = document.getElementById("no");
    const comorbiditiesField = document.querySelector(".comorbiditiesField");

    function toggleComorbidities(){
        if(yesRadio.checked) {
            comorbiditiesField.style.display = "flex";

        } else {
            comorbiditiesField.style.display = "none";
        }
    }

    yesRadio.addEventListener("change", toggleComorbidities);
    noRadio.addEventListener("change", toggleComorbidities);
});