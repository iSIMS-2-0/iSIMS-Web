<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $students = [
//     [
//         'student' => [
//             'name' => 'Juan Dela Cruz',
//             'program' => 'BSCS',
//             'sex' => 'Male',
//             'gender_disclosure' => 'Yes',
//             'mobile' => '09171234567',
//             'landline' => '1234567',
//             'email' => 'juan.delacruz@example.com',
//             'lot_blk' => '12A',
//             'street' => 'Rizal Ave',
//             'zip_code' => 1000,
//             'city_municipality' => 'Manila',
//             'country' => 'Philippines',
//             'password_hash' => 'password1'
//         ],
//         'family' => [
//             'mother_name' => 'Maria Dela Cruz',
//             'father_name' => 'Jose Dela Cruz',
//             'mother_mobile_number' => '09180000001',
//             'father_mobile_number' => '09180000002',
//             'mother_email' => 'maria.dc@example.com',
//             'father_email' => 'jose.dc@example.com',
//             'emergency_contact' => 'Maria Dela Cruz',
//             'other_contact_name' => 'Tita Ana',
//             'other_contact_mobilenum' => '09180000003',
//             'other_contact_email' => 'ana.tita@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'None',
//             'allergies' => 'Peanuts'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Maria Santos',
//             'program' => 'BSIT',
//             'sex' => 'Female',
//             'gender_disclosure' => 'Yes',
//             'mobile' => '09181234567',
//             'landline' => '2345678',
//             'email' => 'maria.santos@example.com',
//             'lot_blk' => '34B',
//             'street' => 'Bonifacio St',
//             'zip_code' => 1100,
//             'city_municipality' => 'Quezon City',
//             'country' => 'Philippines',
//             'password_hash' => 'password2'
//         ],
//         'family' => [
//             'mother_name' => 'Luz Santos',
//             'father_name' => 'Pedro Santos',
//             'mother_mobile_number' => '09180000004',
//             'father_mobile_number' => '09180000005',
//             'mother_email' => 'luz.santos@example.com',
//             'father_email' => 'pedro.santos@example.com',
//             'emergency_contact' => 'Pedro Santos',
//             'other_contact_name' => 'Tito Ben',
//             'other_contact_mobilenum' => '09180000006',
//             'other_contact_email' => 'ben.tito@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'Asthma',
//             'allergies' => 'None'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Jose Rizal',
//             'program' => 'BSIS',
//             'sex' => 'Male',
//             'gender_disclosure' => 'No',
//             'mobile' => '09192223333',
//             'landline' => '3456789',
//             'email' => 'jose.rizal@example.com',
//             'lot_blk' => '56C',
//             'street' => 'Mabini St',
//             'zip_code' => 1200,
//             'city_municipality' => 'Pasay',
//             'country' => 'Philippines',
//             'password_hash' => 'password3'
//         ],
//         'family' => [
//             'mother_name' => 'Teodora Rizal',
//             'father_name' => 'Francisco Rizal',
//             'mother_mobile_number' => '09180000007',
//             'father_mobile_number' => '09180000008',
//             'mother_email' => 'teodora.rizal@example.com',
//             'father_email' => 'francisco.rizal@example.com',
//             'emergency_contact' => 'Teodora Rizal',
//             'other_contact_name' => 'Kuya Pepe',
//             'other_contact_mobilenum' => '09180000009',
//             'other_contact_email' => 'pepe.kuya@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'Diabetes',
//             'allergies' => 'Dust'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Ana Lopez',
//             'program' => 'BSCS',
//             'sex' => 'Female',
//             'gender_disclosure' => 'Yes',
//             'mobile' => '09221234567',
//             'landline' => '4567890',
//             'email' => 'ana.lopez@example.com',
//             'lot_blk' => '78D',
//             'street' => 'Taft Ave',
//             'zip_code' => 1300,
//             'city_municipality' => 'Pasay',
//             'country' => 'Philippines',
//             'password_hash' => 'password4'
//         ],
//         'family' => [
//             'mother_name' => 'Carmen Lopez',
//             'father_name' => 'Luis Lopez',
//             'mother_mobile_number' => '09180000010',
//             'father_mobile_number' => '09180000011',
//             'mother_email' => 'carmen.lopez@example.com',
//             'father_email' => 'luis.lopez@example.com',
//             'emergency_contact' => 'Luis Lopez',
//             'other_contact_name' => 'Auntie May',
//             'other_contact_mobilenum' => '09180000012',
//             'other_contact_email' => 'may.auntie@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'None',
//             'allergies' => 'Seafood'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Pedro Pascual',
//             'program' => 'BSIT',
//             'sex' => 'Male',
//             'gender_disclosure' => 'No',
//             'mobile' => '09331234567',
//             'landline' => '5678901',
//             'email' => 'pedro.pascual@example.com',
//             'lot_blk' => '90E',
//             'street' => 'España Blvd',
//             'zip_code' => 1400,
//             'city_municipality' => 'Manila',
//             'country' => 'Philippines',
//             'password_hash' => 'password5'
//         ],
//         'family' => [
//             'mother_name' => 'Elena Pascual',
//             'father_name' => 'Ramon Pascual',
//             'mother_mobile_number' => '09180000013',
//             'father_mobile_number' => '09180000014',
//             'mother_email' => 'elena.pascual@example.com',
//             'father_email' => 'ramon.pascual@example.com',
//             'emergency_contact' => 'Elena Pascual',
//             'other_contact_name' => 'Uncle Bob',
//             'other_contact_mobilenum' => '09180000015',
//             'other_contact_email' => 'bob.uncle@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'Hypertension',
//             'allergies' => 'Eggs'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Liza Reyes',
//             'program' => 'BSIS',
//             'sex' => 'Female',
//             'gender_disclosure' => 'Yes',
//             'mobile' => '09441234567',
//             'landline' => '6789012',
//             'email' => 'liza.reyes@example.com',
//             'lot_blk' => '12F',
//             'street' => 'Aurora Blvd',
//             'zip_code' => 1500,
//             'city_municipality' => 'San Juan',
//             'country' => 'Philippines',
//             'password_hash' => 'password6'
//         ],
//         'family' => [
//             'mother_name' => 'Nena Reyes',
//             'father_name' => 'Mario Reyes',
//             'mother_mobile_number' => '09180000016',
//             'father_mobile_number' => '09180000017',
//             'mother_email' => 'nena.reyes@example.com',
//             'father_email' => 'mario.reyes@example.com',
//             'emergency_contact' => 'Mario Reyes',
//             'other_contact_name' => 'Tita Rose',
//             'other_contact_mobilenum' => '09180000018',
//             'other_contact_email' => 'rose.tita@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'None',
//             'allergies' => 'None'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Carlos Garcia',
//             'program' => 'BSCS',
//             'sex' => 'Male',
//             'gender_disclosure' => 'Yes',
//             'mobile' => '09551234567',
//             'landline' => '7890123',
//             'email' => 'carlos.garcia@example.com',
//             'lot_blk' => '34G',
//             'street' => 'Katipunan Ave',
//             'zip_code' => 1600,
//             'city_municipality' => 'Quezon City',
//             'country' => 'Philippines',
//             'password_hash' => 'password7'
//         ],
//         'family' => [
//             'mother_name' => 'Gloria Garcia',
//             'father_name' => 'Juan Garcia',
//             'mother_mobile_number' => '09180000019',
//             'father_mobile_number' => '09180000020',
//             'mother_email' => 'gloria.garcia@example.com',
//             'father_email' => 'juan.garcia@example.com',
//             'emergency_contact' => 'Gloria Garcia',
//             'other_contact_name' => 'Tito Mike',
//             'other_contact_mobilenum' => '09180000021',
//             'other_contact_email' => 'mike.tito@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'None',
//             'allergies' => 'Shellfish'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Grace Lim',
//             'program' => 'BSIT',
//             'sex' => 'Female',
//             'gender_disclosure' => 'No',
//             'mobile' => '09661234567',
//             'landline' => '8901234',
//             'email' => 'grace.lim@example.com',
//             'lot_blk' => '56H',
//             'street' => 'Ortigas Ave',
//             'zip_code' => 1700,
//             'city_municipality' => 'Pasig',
//             'country' => 'Philippines',
//             'password_hash' => 'password8'
//         ],
//         'family' => [
//             'mother_name' => 'Susan Lim',
//             'father_name' => 'Henry Lim',
//             'mother_mobile_number' => '09180000022',
//             'father_mobile_number' => '09180000023',
//             'mother_email' => 'susan.lim@example.com',
//             'father_email' => 'henry.lim@example.com',
//             'emergency_contact' => 'Henry Lim',
//             'other_contact_name' => 'Auntie Beth',
//             'other_contact_mobilenum' => '09180000024',
//             'other_contact_email' => 'beth.auntie@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'None',
//             'allergies' => 'Pollen'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Miguel Torres',
//             'program' => 'BSIS',
//             'sex' => 'Male',
//             'gender_disclosure' => 'Yes',
//             'mobile' => '09771234567',
//             'landline' => '9012345',
//             'email' => 'miguel.torres@example.com',
//             'lot_blk' => '78I',
//             'street' => 'Shaw Blvd',
//             'zip_code' => 1800,
//             'city_municipality' => 'Mandaluyong',
//             'country' => 'Philippines',
//             'password_hash' => 'password9'
//         ],
//         'family' => [
//             'mother_name' => 'Teresa Torres',
//             'father_name' => 'Roberto Torres',
//             'mother_mobile_number' => '09180000025',
//             'father_mobile_number' => '09180000026',
//             'mother_email' => 'teresa.torres@example.com',
//             'father_email' => 'roberto.torres@example.com',
//             'emergency_contact' => 'Teresa Torres',
//             'other_contact_name' => 'Tito Vic',
//             'other_contact_mobilenum' => '09180000027',
//             'other_contact_email' => 'vic.tito@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'Heart Disease',
//             'allergies' => 'None'
//         ]
//     ],
//     [
//         'student' => [
//             'name' => 'Sofia Cruz',
//             'program' => 'BSCS',
//             'sex' => 'Female',
//             'gender_disclosure' => 'No',
//             'mobile' => '09881234567',
//             'landline' => '1234568',
//             'email' => 'sofia.cruz@example.com',
//             'lot_blk' => '90J',
//             'street' => 'Pioneer St',
//             'zip_code' => 1900,
//             'city_municipality' => 'Mandaluyong',
//             'country' => 'Philippines',
//             'password_hash' => 'password10'
//         ],
//         'family' => [
//             'mother_name' => 'Patricia Cruz',
//             'father_name' => 'Antonio Cruz',
//             'mother_mobile_number' => '09180000028',
//             'father_mobile_number' => '09180000029',
//             'mother_email' => 'patricia.cruz@example.com',
//             'father_email' => 'antonio.cruz@example.com',
//             'emergency_contact' => 'Patricia Cruz',
//             'other_contact_name' => 'Auntie Joy',
//             'other_contact_mobilenum' => '09180000030',
//             'other_contact_email' => 'joy.auntie@example.com'
//         ],
//         'medical' => [
//             'comorb' => 'None',
//             'allergies' => 'Chocolate'
//         ]
//     ]
// ];

// // Usage example:
// $userModel = new User($pdo);
// foreach ($students as $data) {
//     $userModel->createCompleteUser($data['student'], $data['family'], $data['medical']);
// }

<<<<<<< Updated upstream
=======
// Simple router
// $uri = $_SERVER['REQUEST_URI'];
// echo "<h2>Debug: URI = " . htmlspecialchars($uri) . "</h2>";
// $user = new User($pdo);
// $user->createUser(
//     '202301042',
//     'John Doe',
//     'BS Computer Science',
//     'Male',
//     'prefer not to say',
//     '09123456789',
//     '0123456789',
//     'johndoeuwu123@gmail.com',
//     '123 Main St, City, Country',
//     'johndoe123' // Password should be hashed in the model
// );

>>>>>>> Stashed changes
$controller = new AuthController($pdo);
$controller->login();
?>