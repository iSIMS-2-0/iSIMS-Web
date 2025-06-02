<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/student_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <title>Document</title>
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/templates/sideBar.php"; ?>  

    <div class="mainContainer">
        <div class="contents">
            <div class="title">
                <h1>Student Profile</h1>
            </div>

            <div class="studentDetails">
                <div class="studentNumberField">
                    <label for="studentNumber">Student Number</label>
                    <input type="text" id="studentNumber" name="studentNumber" placeholder="student number" >
                </div>

                <div class="studentNameField">
                    <label for="studentName">Name</label>
                    <input type="text" id="studentName" name="studentName" placeholder="name" >
                </div>

                <div class="studentProgramField">
                    <label for="studentProgram">Program</label>
                    <input type="text" id="studentProgram" name="studentProgram" placeholder="program " >
                </div>
            </div>

            <div class="sexGender">
                <div class="sexField">
                    <label for="sex">Sex</label>
                    <input type="text" id="sex" name="sex" placeholder="sex " >
                </div>

                <div class="genderField">
                    <input type="checkbox" id="gender" name="gender" >
                    <label for="gender">I hereby agree to disclose my gender</label>
                </div>
            </div>

            <div class="contactDetails">
                <div class="mobileNumberField">
                    <label for="mobileNumber">Mobile Number</label>
                    <input type="text" id="mobileNumber" name="mobileNumber" placeholder="mobile number" >
                </div>

                <div class="landlineField">
                    <label for="landline">Landline</label>
                    <input type="text" id="landline" name="landline" placeholder="landline" >
                </div>
            </div>

            <div class="emailAddress">
                <div class="emailAddressField">
                    <label for="emailAd">Email Address</label>
                    <input type="text" id="emailAd" name="emailAd" placeholder="email address" >
                </div>
            </div>

            <div class="mailingAddress">
                <div class="lotBlkField">
                    <label for="lotBlk">Lot/Blk No.</label>
                    <input type="text" id="lotBlk" name="lotBlk" placeholder="lot/blk no." >
                </div>

                <div class="streetField">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" placeholder="street" >
                </div>

                <div class="zipCodeField">
                    <label for="zipCode">Zip Code</label>
                    <input type="text" id="zipcode" name="zipcode" placeholder="zipcode" >
                </div>
            </div>

            <div class="mailingAddress">
                <div class="cityMunicipalityField">
                    <label for="cityMunicipality">City/Municipality</label>
                    <input type="text" id="cityMunicipality" name="cityMunicipality" placeholder="city/municipality" >
                </div>

                <div class="countryField">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" placeholder="country" >
                </div>
            </div>

            <h1 class="familyInformationHeading">Family Information</h1>

            <div class="parentsInformationTitle">
                <h2>Parent's Information</h2>
            </div>


            <div class="mothersInformation">
                <div class="mothersNameField">
                    <label for="motherName">Mother's Name</label>
                    <input type="text" id="motherName" name="motherName" placeholder="mother's name" >
                </div>

                <div class="mobileNumberField">
                    <label for="motherMobileNumber">Mobile Number</label>
                    <input type="text" id="motherMobileNumber" name="motherMobileNumber" placeholder="mobile number" >
                </div>

                    <div class="emailAddressField">
                    <label for="emailAd">Email Address</label>
                    <input type="text" id="motherEmailAddress" name="motherEmailAddress" placeholder="email address" >
                </div>
            </div>

            <div class="mothersInformation">
                <div class="mothersNameField">
                    <label for="motherName">Father's Name</label>
                    <input type="text" id="motherName" name="motherName" placeholder="mother's name" >
                </div>

                <div class="mobileNumberField">
                    <label for="motherMobileNumber">Mobile Number</label>
                    <input type="text" id="motherMobileNumber" name="motherMobileNumber" placeholder="mobile number" >
                </div>

                    <div class="emailAddressField">
                    <label for="emailAd">Email Address</label>
                    <input type="text" id="motherEmailAddress" name="motherEmailAddress" placeholder="email address" >
                </div>
            </div>

            <div class="emergencyContactTitle">
                <h2>Emergency Contact</h2>
            </div>

            <div class="emergencyContact">
                <div class="motherCheckboxField">
                    <input type="checkbox" id="motherCheckbox" name="motherCheckbox" >
                    <label for="gender">Same as Mother's Information</label>
                </div>

                <div class="fatherCheckboxField">
                    <input type="checkbox" id="fatherCheckbox" name="fatherCheckbox" >
                    <label for="gender">Same as Father's Information</label>
                </div>

                <div class="otherCheckboxField">
                    <input type="checkbox" id="otherCheckbox" name="otherCheckbox" >
                    <label for="gender">Other Information</label>
                </div>
            </div>

            <div class="otherContactInformation">
                <div class="otherNameField">
                    <label for="otherName">Name</label>
                    <input type="text" id="otherName" name="otherName" placeholder="name" >
                </div>

                <div class="otherMobileNumberField">
                    <label for="otherNumber">Mobile Number</label>
                    <input type="text" id="otherNumber" name="otherNumber" placeholder="mobile number" >
                </div>

                    <div class="otherEmailAddressField">
                    <label for="otherEmailAd">Email Address</label>
                    <input type="text" id="otherEmailAddress" name="otherEmailAddress" placeholder="email address" >
                </div>
            </div>

        </div>
    </div>
</body>
</html>