document.addEventListener("DOMContentLoaded", function() {
    // Gender Disclosure
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


    //Comorbidities
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

    //Allergies
    const haveAllergies = document.getElementById("have");
    const noAllergies = document.getElementById("n/a");
    const allergiesField = document.querySelector(".allergiesField");

    function toggleAllergies(){
        if(haveAllergies.checked) {
            allergiesField.style.display = "flex";

        } else {
            allergiesField.style.display = "none";
        }
    }

    haveAllergies.addEventListener("change", toggleAllergies);
    noAllergies.addEventListener("change", toggleAllergies);
});
