<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/student_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Student Profile</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <form method="post" id="studentInformationForm">
                <div class="studentProfileContainer" >
                    <div class="sectionTitle">
                        <h1>Student Profile</h1>
                    </div>

                    <div class="informationSection">
                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentNumber">Student Number</label>
                                <input type="text" id="studentNumber" name="studentNumber" readonly>
                            </div>

                            <div class="field">
                                <label for="studentName">Name</label>
                                <input type="text" id="studentName" name="studentName" readonly>
                            </div>

                            <div class="field">
                                <label for="studentProgram">Program</label>
                                <input type="text" id="studentProgram" name="studentProgram" readonly>
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentNumber">Sex</label>
                                <input type="text" id="studentSex" name="studentSex" readonly>
                            </div>

                            <div class="genderField">
                                <input type="checkbox" id="studentGender" name="studentGender" >
                                <label for="studentGender">I hereby agree to disclose my gender</label>
                            </div>
                        </div>

                        
                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentMobileNumber">Mobile Number</label>
                                <input type="text" id="studentMobileNumber" name="studentMobileNumber" readonly>
                            </div>

                            <div class="field">
                                <label for="studentLandline">Landline</label>
                                <input type="text" id="studentLandline" name="studentLandline" readonly>
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentEmailAddress">Email Address</label>
                                <input type="text" id="studentEmailAddress" name="studentEmailAddress" readonly>
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="lotBlkNo">Lot/Blk No.</label>
                                <input type="text" id="lotBlkNo" name="lotBlkNo" readonly>
                            </div>

                            <div class="field">
                                <label for="street">Street</label>
                                <input type="text" id="street" name="street" readonly>
                            </div>

                            <div class="field">
                                <label for="zipCode">Zip Code</label>
                                <input type="text" id="zipCode" name="zipCode" readonly>
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="cityMuniciplaity">City/Municipality</label>
                                <input type="text" id="cityMuniciplaity" name="cityMuniciplaity" readonly>
                            </div>

                            <div class="field">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="familyInformationContainer">
                    <div class="sectionTitle">
                        <h1>Family Information</h1>
                    </div>

                    <div class="informationSection">
                        <h2>Parent's Information</h2>

                        <div class="parentsDetails">
                            <div class="field">
                                <label for="mothersName">Mother's name</label>
                                <input type="text" id="mothersName" name="mothersName" readonly>
                            </div>

                            <div class="field">
                                <label for="mothersMobileNumber">Mobile Number</label>
                                <input type="text" id="mothersMobileNumber" name="mothersMobileNumber" readonly>
                            </div>

                            <div class="field">
                                <label for="mothersEmailAddress">Email Address</label>
                                <input type="text" id="mothersEmailAddress" name="mothersEmailAddress" readonly>
                            </div>
                        </div>

                        <div class="parentsDetails">
                            <div class="field">
                                <label for="fathersName">Father's name</label>
                                <input type="text" id="fathersName" name="fathersName" readonly>
                            </div>

                            <div class="field">
                                <label for="fathersMobileNumber">Mobile Number</label>
                                <input type="text" id="fathersMobileNumber" name="fathersMobileNumber" readonly>
                            </div>

                            <div class="field">
                                <label for="fathersEmailAddress">Email Address</label>
                                <input type="text" id="fathersEmailAddress" name="fathersEmailAddress" readonly>
                            </div>
                        </div>

                        <h2>Emergency Contact</h2>
                        <div class="emergencyContactDetails">
                            <div class="emergencyContactField">
                                <input type="checkbox" id="mothersInformation" name="mothersInformation" >
                                <label for="mothersInformation">Same as Mother's Information</label>
                            </div>

                            <div class="emergencyContactField">
                                <input type="checkbox" id="fathersInformation" name="fathersInformation" >
                                <label for="fathersInformation">Same as Fathers's Information</label>
                            </div>

                            <div class="emergencyContactField">
                                <input type="checkbox" id="otherInformation" name="otherInformation" >
                                <label for="otherInformation">Other Information</label>
                            </div>
                        </div>

                        <div class="emergencyContactDetails">
                            <div class="field">
                                <label for="otherName">Name</label>
                                <input type="text" id="otherName" name="otherName" readonly>
                            </div>

                            <div class="field">
                                <label for="otherMobileNumber">Mobile Number</label>
                                <input type="text" id="otherMobileNumber" name="otherMobileNumber" readonly>
                            </div>

                            <div class="field">
                                <label for="otherEmailAddress">Email Address</label>
                                <input type="text" id="otherEmailAddress" name="otherEmailAddress" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="medicalHistoryContainer">
                    <div class="sectionTitle">
                        <h1>Medical History</h1>
                    </div>

                    <div class="informationSection">
                        <div class="hospitalizationContainer">
                            <label>Have you been hospitalized before?</label>
                            <div class="hospitalizationAnswer">
                                <label><input type="radio" name="hospitalized" value="yes">Yes</label>
                                <label><input type="radio" name="hospitalized" value="no">No</label>
                            </div>
                        </div>

                        <div class="hospitalizationReasonContainer">
                                <label for="hospitalReason">Reason(s)</label>
                                <input type="text" name="hospitalReason" placeholder="reason">
                        </div>

                        <div class="illnessContainer">
                            <label>Do you have any of the following? (Check all that apply)</label>
                            <div class="applicableIllnesses">
                                <div class="illnessField">
                                    <input type="checkbox" name="diabetes" value="diabetes">
                                    <label for="diabetes">Diabetes</label>
                                </div>

                                <div class="illnessField">
                                    <input type="checkbox" name="highBlood" value="highBlood">
                                    <label for="highBlood">High Blood</label>
                                </div>

                                <div class="illnessField">
                                    <input type="checkbox" name="allergies" value="allergies">
                                    <label for="allergies">Allergies</label>
                                </div>

                                <div class="illnessField">
                                    <input type="checkbox" name="anemia" value="anemia">
                                    <label for="anemia">Anemia</label>
                                </div>

                                <div class="illnessField">
                                        <input type="checkbox" name="otherIllness" value="otherIllness">
                                        <label for="otherIllness">Others</label>
                                    <div class="otherIllnessInput">
                                        <input type="text" id="otherIllnessText" name="otherIllnessText" placeholder="Please specify other illness">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="otherHealthConcern">
                            <label>Other health concerns/conditions the school should know about:</label>
                            <textarea id="otherConcerns" name="otherConcerns" rows="4"></textarea>
                        </div>
                    </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>