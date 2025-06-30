document.addEventListener("DOMContentLoaded", function() {
    // Gender Disclosure
    const discloseGender = document.getElementById("studentGender");
    const genderInput = document.querySelector(".genderInput");
    const genderSelect = document.getElementById("gender");
    const dbPronoun = genderSelect ? genderSelect.getAttribute("data-pronoun") : "";

    function toggleGender(){
        if(discloseGender.checked){
            genderInput.style.display = "block";
            // Auto-select pronoun if present in DB
            if (dbPronoun && genderSelect) {
                let found = false;
                for (let i = 0; i < genderSelect.options.length; i++) {
                    if (genderSelect.options[i].value === dbPronoun) {
                        genderSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    genderSelect.selectedIndex = 0; // placeholder
                }
            } else if (genderSelect) {
                genderSelect.selectedIndex = 0; // placeholder
            }
        } else {
            genderInput.style.display = "none";
            if (genderSelect) {
                genderSelect.selectedIndex = 0; // reset to placeholder
            }
        }
    }

    discloseGender.addEventListener("change", toggleGender);
    toggleGender();

    // Comorbidities radio logic
    const yesRadio = document.getElementById("yes");
    const noRadio = document.getElementById("no");
    const comorbiditiesField = document.querySelector(".comorbiditiesField");
    const comorbiditiesTextarea = document.getElementById("comorbidities");
    function toggleComorbidities() {
        if (yesRadio.checked) {
            comorbiditiesField.style.display = "flex";
        } else {
            comorbiditiesField.style.display = "none";
            comorbiditiesTextarea.value = "";
        }
    }
    yesRadio.addEventListener("change", toggleComorbidities);
    noRadio.addEventListener("change", toggleComorbidities);
    toggleComorbidities();

    // Allergies radio logic
    const haveAllergies = document.getElementById("have");
    const noAllergies = document.getElementById("n/a");
    const allergiesField = document.querySelector(".allergiesField");
    const allergiesTextarea = document.getElementById("allergy");
    function toggleAllergies() {
        if (haveAllergies.checked) {
            allergiesField.style.display = "flex";
        } else {
            allergiesField.style.display = "none";
            allergiesTextarea.value = "";
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