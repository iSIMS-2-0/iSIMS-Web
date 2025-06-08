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
    toggleComorbidities(); 

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
    toggleAllergies();

    const motherRadio = document.getElementById("mothersInformation");
    const fatherRadio = document.getElementById("fathersInformation");
    const otherRadio = document.getElementById("otherInformation");

    const otherName = document.getElementById("otherName");
    const otherMobile = document.getElementById("otherMobileNumber");
    const otherEmail = document.getElementById("otherEmailAddress");

    const mothersName = document.getElementById("mothersName");
    const mothersMobile = document.getElementById("mothersMobileNumber");
    const mothersEmail = document.getElementById("mothersEmailAddress");

    const fathersName = document.getElementById("fathersName");
    const fathersMobile = document.getElementById("fathersMobileNumber");
    const fathersEmail = document.getElementById("fathersEmailAddress");

    function setEmergencyContactRadio() {
        if (
            otherName.value === mothersName.value &&
            otherMobile.value === mothersMobile.value &&
            otherEmail.value === mothersEmail.value
        ) {
            motherRadio.checked = true;
        } else if (
            otherName.value === fathersName.value &&
            otherMobile.value === fathersMobile.value &&
            otherEmail.value === fathersEmail.value
        ) {
            fatherRadio.checked = true;
        } else {
            otherRadio.checked = true;
        }
    }

    setEmergencyContactRadio();
});
