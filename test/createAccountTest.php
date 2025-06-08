<?php
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../config.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userModel = new User($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = [
        'name' => $_POST['name'] ?? '',
        'program' => $_POST['program'] ?? '',
        'sex' => $_POST['sex'] ?? '',
        'gender_disclosure' => $_POST['gender_disclosure'] ?? 'No',
        'mobile' => $_POST['mobile'] ?? '',
        'landline' => $_POST['landline'] ?? '',
        'email' => $_POST['email'] ?? '',
        'lot_blk' => $_POST['lot_blk'] ?? '',
        'street' => $_POST['street'] ?? '',
        'zip_code' => $_POST['zip_code'] ?? '',
        'city_municipality' => $_POST['city_municipality'] ?? '',
        'country' => $_POST['country'] ?? '',
        'password_hash' => $_POST['password'] ?? ''
    ];
    $family = [
        'mother_name' => $_POST['mother_name'] ?? '',
        'father_name' => $_POST['father_name'] ?? '',
        'mother_mobile_number' => $_POST['mother_mobile_number'] ?? '',
        'father_mobile_number' => $_POST['father_mobile_number'] ?? '',
        'mother_email' => $_POST['mother_email'] ?? '',
        'father_email' => $_POST['father_email'] ?? '',
        'emergency_contact' => $_POST['emergency_contact'] ?? '',
        'other_contact_name' => $_POST['other_contact_name'] ?? '',
        'other_contact_mobilenum' => $_POST['other_contact_mobilenum'] ?? '',
        'other_contact_email' => $_POST['other_contact_email'] ?? ''
    ];
    $medical = [
        'comorb' => $_POST['comorb'] ?? '',
        'allergies' => $_POST['allergies'] ?? ''
    ];
    try {
        $student_number = $userModel->createCompleteUser($student, $family, $medical);
        $message = "<span style='color:green'>Account created! Student Number: $student_number</span>";
    } catch (Exception $e) {
        $message = "<span style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account Test</title>
</head>
<body>
    <h1>Create Student Account (Test)</h1>
    <?php if ($message) echo $message; ?>
    <form method="post">
        <h2>Student Info</h2>
        Name: <input name="name" required><br>
        Program: <input name="program" required><br>
        Sex: <select name="sex"><option>Male</option><option>Female</option></select><br>
        Gender Disclosure: <select name="gender_disclosure"><option value="Yes">Yes</option><option value="No">No</option></select><br>
        Mobile: <input name="mobile"><br>
        Landline: <input name="landline"><br>
        Email: <input name="email"><br>
        Lot/Blk: <input name="lot_blk"><br>
        Street: <input name="street"><br>
        Zip Code: <input name="zip_code"><br>
        City/Municipality: <input name="city_municipality"><br>
        Country: <input name="country"><br>
        Password: <input name="password" type="password" required><br>
        <h2>Family Info</h2>
        Mother's Name: <input name="mother_name"><br>
        Father's Name: <input name="father_name"><br>
        Mother's Mobile: <input name="mother_mobile_number"><br>
        Father's Mobile: <input name="father_mobile_number"><br>
        Mother's Email: <input name="mother_email"><br>
        Father's Email: <input name="father_email"><br>
        <b>Emergency Contact:</b><br>
        <input type="radio" name="emergency_radio" id="emergency_mother" value="mother"> <label for="emergency_mother">Same as Mother's Information</label><br>
        <input type="radio" name="emergency_radio" id="emergency_father" value="father"> <label for="emergency_father">Same as Father's Information</label><br>
        <input type="radio" name="emergency_radio" id="emergency_other" value="other" checked> <label for="emergency_other">Other Information</label><br>
        <div id="other_emergency_fields">
            Other Contact Name: <input name="other_contact_name" id="other_contact_name"><br>
            Other Contact Mobile: <input name="other_contact_mobilenum" id="other_contact_mobilenum"><br>
            Other Contact Email: <input name="other_contact_email" id="other_contact_email"><br>
        </div>
        <script>
        // Emergency contact autofill logic
        document.addEventListener('DOMContentLoaded', function() {
            function byId(id) { return document.getElementById(id); }
            const motherRadio = byId('emergency_mother');
            const fatherRadio = byId('emergency_father');
            const otherRadio = byId('emergency_other');
            const otherFields = document.getElementById('other_emergency_fields');
            const otherName = byId('other_contact_name');
            const otherMobile = byId('other_contact_mobilenum');
            const otherEmail = byId('other_contact_email');
            const motherName = document.querySelector('input[name="mother_name"]');
            const motherMobile = document.querySelector('input[name="mother_mobile_number"]');
            const motherEmail = document.querySelector('input[name="mother_email"]');
            const fatherName = document.querySelector('input[name="father_name"]');
            const fatherMobile = document.querySelector('input[name="father_mobile_number"]');
            const fatherEmail = document.querySelector('input[name="father_email"]');

            function updateEmergencyFields() {
                if (motherRadio.checked) {
                    otherFields.style.display = 'block';
                    otherName.value = motherName.value;
                    otherMobile.value = motherMobile.value;
                    otherEmail.value = motherEmail.value;
                    otherName.readOnly = true;
                    otherMobile.readOnly = true;
                    otherEmail.readOnly = true;
                } else if (fatherRadio.checked) {
                    otherFields.style.display = 'block';
                    otherName.value = fatherName.value;
                    otherMobile.value = fatherMobile.value;
                    otherEmail.value = fatherEmail.value;
                    otherName.readOnly = true;
                    otherMobile.readOnly = true;
                    otherEmail.readOnly = true;
                } else {
                    otherFields.style.display = 'block';
                    otherName.value = '';
                    otherMobile.value = '';
                    otherEmail.value = '';
                    otherName.readOnly = false;
                    otherMobile.readOnly = false;
                    otherEmail.readOnly = false;
                }
            }
            // Update if parent info changes and radio is selected
            [motherName, motherMobile, motherEmail].forEach(function(input) {
                input.addEventListener('input', function() {
                    if (motherRadio.checked) updateEmergencyFields();
                });
            });
            [fatherName, fatherMobile, fatherEmail].forEach(function(input) {
                input.addEventListener('input', function() {
                    if (fatherRadio.checked) updateEmergencyFields();
                });
            });
            motherRadio.addEventListener('change', updateEmergencyFields);
            fatherRadio.addEventListener('change', updateEmergencyFields);
            otherRadio.addEventListener('change', updateEmergencyFields);
            updateEmergencyFields(); // initial
        });
        </script>
        <h2>Medical Info</h2>
        Comorbidities: <input name="comorb"><br>
        Allergies: <input name="allergies"><br>
        <br><button type="submit">Create Account</button>
    </form>
</body>
</html>
