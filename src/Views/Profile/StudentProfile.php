<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/src/Models/User.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/config.php";

$config = require $_SERVER["DOCUMENT_ROOT"] . "/config.php";
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userModel = new User($pdo);
$user = $userModel->findByStudentNumber($_SESSION['student_number']);
$family = $userModel->findFamilyInfoByID($user['family_info_id']);
$medical = $userModel->findMedicalHistoryByID($user['medical_historyid']);

$emergency = [
    'name' => $family['other_contact_name'] ?? '',
    'mobile' => $family['other_contact_mobilenum'] ?? '',
    'email' => $family['other_contact_email'] ?? ''
];
$isMother = (
    $emergency['name'] === ($family['mother_name'] ?? '') &&
    $emergency['mobile'] === ($family['mother_mobile_number'] ?? '') &&
    $emergency['email'] === ($family['mother_email'] ?? '')
);
$isFather = (
    $emergency['name'] === ($family['father_name'] ?? '') &&
    $emergency['mobile'] === ($family['father_mobile_number'] ?? '') &&
    $emergency['email'] === ($family['father_email'] ?? '')
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_email = $_POST['studentEmailAddress'] ?? '';
    $new_mother_email = $_POST['mothersEmailAddress'] ?? '';
    $new_father_email = $_POST['fathersEmailAddress'] ?? '';
    $new_other_email = $_POST['otherEmailAddress'] ?? '';
    $new_comorb = trim($_POST['comorbidities'] ?? '');
    $new_allergies = trim($_POST['allergy'] ?? '');
    $new_gender_disclosure = isset($_POST['studentGender']) ? 'yes' : 'no';
    $new_pronoun = $_POST['gender'] ?? '';
    // If comorbidities or allergies are empty, set to null for DB
    $new_comorb = ($new_comorb === '') ? null : $new_comorb;
    $new_allergies = ($new_allergies === '') ? null : $new_allergies;
    // Update student email
    $stmt = $pdo->prepare("UPDATE students SET email = ?, gender_disclosure = ?, pronouns = ? WHERE id = ?");
    $stmt->execute([$new_email, $new_gender_disclosure, $new_pronoun, $user['id']]);
    // Update family_info emails
    $stmt = $pdo->prepare("UPDATE family_info SET mother_email = ?, father_email = ?, other_contact_email = ? WHERE id = ?");
    $stmt->execute([$new_mother_email, $new_father_email, $new_other_email, $user['family_info_id']]);
    // Update medical history
    $stmt = $pdo->prepare("UPDATE medical_history SET comorb = ?, allergies = ? WHERE id = ?");
    $stmt->execute([$new_comorb, $new_allergies, $user['medical_historyid']]);
    // Refresh data after update
    $user = $userModel->findByStudentNumber($_SESSION['student_number']);
    $family = $userModel->findFamilyInfoByID($user['family_info_id']);
    $medical = $userModel->findMedicalHistoryByID($user['medical_historyid']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/CSS/main.css">
    <link rel="stylesheet" href="/public/assets/CSS/Components/Profile/student_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script defer src="/public/assets/JavaScript/sidebar.js"></script>
    <script defer src="/public/assets/JavaScript/studentProfile.js"></script>
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
                                <input type="text" id="studentNumber" name="studentNumber" readonly value="<?php echo htmlspecialchars($user['student_number'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="studentName">Name</label>
                                <input type="text" id="studentName" name="studentName" readonly value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="studentProgram">Program</label>
                                <input type="text" id="studentProgram" name="studentProgram" readonly value="<?php echo htmlspecialchars($user['program'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentSex">Sex</label>
                                <input type="text" id="studentSex" name="studentSex" readonly value="<?php echo htmlspecialchars($user['sex'] ?? ''); ?>">
                            </div>

                            <div class="genderField">
                                <input type="checkbox" id="studentGender" name="studentGender" <?php echo (!empty($user['gender_disclosure']) && strtolower($user['gender_disclosure']) === 'yes') ? 'checked' : ''; ?>>
                                <label for="studentGender">I hereby agree to disclose my gender</label>
                            </div>

                            <div class="genderInput" style="display:<?php echo (!empty($user['gender_disclosure']) && strtolower($user['gender_disclosure']) === 'yes') ? 'block' : 'none'; ?>;">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" data-pronoun="<?php echo htmlspecialchars($user['pronouns'] ?? ''); ?>">
                                    <option value="" hidden <?php echo (empty($user['pronouns'])) ? 'selected' : ''; ?>> Select Gender </option>
                                    <option value="male" <?php echo (isset($user['pronouns']) && $user['pronouns'] === 'male') ? 'selected' : ''; ?>>He/Him/His</option>
                                    <option value="female" <?php echo (isset($user['pronouns']) && $user['pronouns'] === 'female') ? 'selected' : ''; ?>>She/Her/Hers</option>
                                    <option value="they" <?php echo (isset($user['pronouns']) && $user['pronouns'] === 'they') ? 'selected' : ''; ?>>They/Them/Theirs</option>
                                    <option value="zie" <?php echo (isset($user['pronouns']) && $user['pronouns'] === 'zie') ? 'selected' : ''; ?>>Zie/Zir/Zirs</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentMobileNumber">Mobile Number</label>
                                <input type="text" id="studentMobileNumber" name="studentMobileNumber" readonly value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="studentLandline">Landline</label>
                                <input type="text" id="studentLandline" name="studentLandline" readonly value="<?php echo htmlspecialchars($user['landline'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="studentEmailAddress">Email Address</label>
                                <input type="text" id="studentEmailAddress" name="studentEmailAddress" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="lotBlkNo">Lot/Blk No.</label>
                                <input type="text" id="lotBlkNo" name="lotBlkNo" readonly value="<?php echo htmlspecialchars($user['lot_blk'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="street">Street</label>
                                <input type="text" id="street" name="street" readonly value="<?php echo htmlspecialchars($user['street'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="zipCode">Zip Code</label>
                                <input type="text" id="zipCode" name="zipCode" readonly value="<?php echo htmlspecialchars($user['zip_code'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="studentDetails">
                            <div class="field">
                                <label for="cityMuniciplaity">City/Municipality</label>
                                <input type="text" id="cityMuniciplaity" name="cityMuniciplaity" readonly value="<?php echo htmlspecialchars($user['city_municipality'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="country">Country</label>
                                <input type="text" id="country" name="country" readonly value="<?php echo htmlspecialchars($user['country'] ?? ''); ?>">
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
                                <input type="text" id="mothersName" name="mothersName" readonly value="<?php echo htmlspecialchars($family['mother_name'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="mothersMobileNumber">Mobile Number</label>
                               <input type="text" id="mothersMobileNumber" name="mothersMobileNumber" readonly value="<?php echo htmlspecialchars($family['mother_mobile_number'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="mothersEmailAddress">Email Address</label>
                                <input type="text" id="mothersEmailAddress" name="mothersEmailAddress" value="<?php echo htmlspecialchars($family['mother_email'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="parentsDetails">
                            <div class="field">
                                <label for="fathersName">Father's name</label>
                                <input type="text" id="fathersName" name="fathersName" readonly value="<?php echo htmlspecialchars($family['father_name'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="fathersMobileNumber">Mobile Number</label>
                                <input type="text" id="fathersMobileNumber" name="fathersMobileNumber" readonly value="<?php echo htmlspecialchars($family['father_mobile_number'] ?? ''); ?>">
                            </div>

                            <div class="field">
                                <label for="fathersEmailAddress">Email Address</label>
                               <input type="text" id="fathersEmailAddress" name="fathersEmailAddress" value="<?php echo htmlspecialchars($family['father_email'] ?? ''); ?>">
                            </div>
                        </div>

                        <h2>Emergency Contact</h2>
                        <div class="emergencyContactDetails">
                            <div class="emergencyContactField">
                                <input type="radio" id="mothersInformation" name="contactInformation" 
                                  <?php if ($isMother) {
                                        echo 'checked';
                                    } else {
                                        echo 'disabled';
                                    } ?>>
                                <label for="mothersInformation">Same as Mother's Information</label>
                            </div>

                            <div class="emergencyContactField">
                                <input type="radio" id="fathersInformation" name="contactInformation" 
                                    <?php if ($isFather) {
                                            echo 'checked';
                                        } else {
                                            echo 'disabled';
                                        } ?>>
                                <label for="fathersInformation">Same as Father's Information</label>
                            </div>

                            <div class="emergencyContactField">
                                <input type="radio" id="otherInformation" name="contactInformation"
                                     <?php if (!$isMother && !$isFather) {
                                            echo 'checked';
                                        } else {
                                            echo 'disabled';
                                        } ?>>
                               <label for="otherInformation">Other Information</label>
                            </div>
                        </div>

                        <div class="emergencyContactDetails">
                            <div class="field">
                                <label for="otherName">Name</label>
                                <input type="text" id="otherName" name="otherName" readonly value="<?php echo htmlspecialchars($emergency['name']); ?>">
                            </div>

                            <div class="field">
                                <label for="otherMobileNumber">Mobile Number</label>
                                <input type="text" id="otherMobileNumber" name="otherMobileNumber" readonly value="<?php echo htmlspecialchars($emergency['mobile']); ?>">
                            </div>

                            <div class="field">
                                <label for="otherEmailAddress">Email Address</label>
                                <input type="text" id="otherEmailAddress" name="otherEmailAddress" value="<?php echo htmlspecialchars($emergency['email']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="medicalHistoryContainer">
                    <div class="sectionTitle">
                        <h1>Medical History</h1>
                    </div>
                    <div class="informationSection">
                        <div class="field">
                            <label>Do you have any comorbidities/medical conditions?</label>
                            <div class="comorbidityOptions">
                                <div>
                                    <input type="radio" id="yes" name="comorbidity" <?php if(!empty($medical['comorb'])) echo 'checked'; ?>>
                                    <label for="yes">Yes</label>
                                </div>

                                <div>
                                    <input type="radio" id="no" name="comorbidity" <?php if(empty($medical['comorb'])) echo 'checked'; ?>>
                                    <label for="no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="comorbiditiesField">
                            <label>Comorbidities/Medical Conditions</label>
                            <textarea id="comorbidities" name="comorbidities" rows="4"><?php echo htmlspecialchars($medical['comorb'] ?? ''); ?></textarea>
                        </div>

                        <div class="field">
                            <label>Do you have any known allergies?</label>
                            <div class="allergyOptions">
                                <div>
                                    <input type="radio" id="have" name="allergy" <?php if(!empty($medical['allergies'])) echo 'checked'; ?>>
                                    <label for="have">Yes</label>
                                </div>

                                <div>
                                    <input type="radio" id="n/a" name="allergy" <?php if(empty($medical['allergies'])) echo 'checked'; ?>>
                                    <label for="n/a">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="allergiesField">
                            <label>List all of your allergies</label>
                            <textarea id="allergy" name="allergy" rows="4"><?php echo htmlspecialchars($medical['allergies'] ?? ''); ?></textarea>
                        </div>

                        <hr>
                        <div class="termsConditionsCheckbox">
                            <input type="checkbox" id="comorbidityDetails" name="studentDataCheckbox" required>
                            <label for="studentDataCheckbox">I hereby affirm that all information supplied in this Student Data Sheet is real and accurate</label>
                        </div>

                        <div class="termsConditionsCheckbox">
                            <input type="checkbox" id="comorbidityDetails" name="studentDataCheckbox1" required>
                            <label for="studentDataCheckbox1"> I hereby allow the University to collect, use and process the above mentioned information for 
                                legitimate purposes and allow authorized personnel to process such information pursuant to the Data Privacy Policy of the University.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="buttonContainer">
                    <button type="submit" class="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>