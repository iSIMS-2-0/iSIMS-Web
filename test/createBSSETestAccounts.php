<?php
require_once __DIR__ . '/../config.php';

$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = '';

try {
    $pdo->beginTransaction();
    
    // First, ensure the BSSE program exists
    $stmt = $pdo->prepare("SELECT id FROM program WHERE course_code = 'BSSE'");
    $stmt->execute();
    $bsseProgram = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$bsseProgram) {
        // Create BSSE program
        $stmt = $pdo->prepare("INSERT INTO program (program_name, course_code) VALUES (?, ?)");
        $stmt->execute(['Bachelor of Science in Computer Science with Specialization in Software Engineering', 'BSSE']);
        $bsseProgramId = $pdo->lastInsertId();
    } else {
        $bsseProgramId = $bsseProgram['id'];
    }
    
    // Create sections if they don't exist
    $sectionsData = ['SE-A', 'SE-B', 'SE-C'];
    foreach ($sectionsData as $section) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO sections (name) VALUES (?)");
        $stmt->execute([$section]);
    }
    
    // Predefined subjects for Software Engineering
    $predefinedSubjects = [
         // 1st Year, 1st Term
            ['FUNDPROG', 'Fundamentals of Programming', 3, 1, 1, 1],
            ['INTROICT', 'Introduction to ICT', 3, 1, 1, 0],
            ['PHYEDU01', 'Physical Education 1', 2.0, 1, 1, 0],
            ['STECHSOC', 'Science, Technology, and Society', 3, 1, 1, 0],
            ['CONWORLD', 'Contemporary World', 3, 1, 1, 0],
            ['UNDESELF', 'Understanding the Self', 3, 1, 1, 0],
            ['EUTENICS', 'Euthenics', 1.0, 1, 1, 0],
            // 1st Year, 2nd Term
            ['ADVAPROG', 'Advanced Programming', 3, 1, 2, 1],
            ['LOGICDES', 'Digital Logic Design', 3, 1, 2, 1],
            ['ETHIPROF', 'Ethics and Professionalism', 3, 1, 2, 0],
            ['FILIPIN1', 'Kontekstwalisadong Komunikasyon sa Filipino', 3, 1, 2, 0],
            ['MATHMODE', 'Mathematics in the Modern World', 3, 1, 2, 0],
            ['OPERSYST', 'Operating Systems', 3, 1, 2, 1],
            ['PHYEDU02', 'Physical Education 2 (Rhythmic Activities and Dance)', 2.0, 1, 2, 0],
            // 1st Year, 3rd Term
            ['ARTAPPRE', 'Art Appreciation', 3, 1, 3, 0],
            ['DATSTRUC', 'Data Structures and Algorithms', 3, 1, 3, 1],
            ['OBJECPRG', 'Object Oriented Programming', 3, 1, 3, 1],
            ['PHYEDU03', 'Physical Education 3 (Individual/Dual Sports)', 2.0, 1, 3, 0],
            ['PURPCOMM', 'Purposive Communication', 3, 1, 3, 0],
            ['READHIST', 'Readings in Philippine History', 3, 1, 3, 0],
            ['NSTPT001', 'National Service Training Program 1', 3, 1, 3, 0],
            ['COMPARCH', 'Computer Architecture', 3, 1, 3, 1],
            // 2nd Year, 1st Term
            ['CSELEC01', 'Core Java Programming 1', 3, 2, 1, 1],
            ['DISCMATH', 'Discrete Mathematics', 3, 2, 1, 0],
            ['INFORMAN', 'Information Management and Database Systems', 3, 2, 1, 1],
            ['PHYEDU04', 'Physical Education 4 (Team Sports)', 2.0, 2, 1, 0],
            ['NSTPT002', 'National Service Training Program 2', 3, 2, 1, 0],
            // 2nd Year, 2nd Term
            ['CSELEC02', 'Core Java Programming 2', 3, 2, 2, 1],
            ['FILIPIN2', 'Filipino sa Iba\'t Ibang Disiplina', 3, 2, 2, 0],
            ['CSELEC03', 'Fundamentals of Web Programming', 3, 2, 2, 1],
            ['RIZALIFE', 'Rizal\'s Life, Works, and Writings', 3, 2, 2, 0],
            ['SOFTENG1', 'Software Engineering 1', 3, 2, 2, 1],
            ['CSELEC04', 'Unified Modelling Language', 3, 2, 2, 1],
            // 2nd Year, 3rd Term
            ['CSELEC05', 'Enterprise Java Programming 1', 3, 2, 3, 1],
            ['CSELEC06', 'Advanced Web Programming', 3, 2, 3, 1],
            ['CSELEC07', 'Mobile Computing 1', 3, 2, 3, 1],
            ['DATACOMM', 'Data Communications', 3, 2, 3, 1],
            ['SOFTENG2', 'Software Engineering 2', 3, 2, 3, 1],
            // 3rd Year, 1st Term
            ['AUTOMATA', 'Automata Theory and Formal Languages', 3, 3, 1, 0],
            ['CSELEC09', 'Enterprise Java Programming 2', 3, 3, 1, 1],
            ['INFOSECU', 'Information Assurance and Security', 3, 3, 1, 1],
            ['CSELEC10', 'Introduction to Artificial Intelligence', 3, 3, 1, 1],
            ['CSELEC08', 'Mobile Computing 2', 3, 3, 1, 1],
            // 3rd Year, 2nd Term
            ['ALGORTHM', 'Analysis of Algorithms', 3, 3, 2, 1],
            ['HUCOMINT', 'Human Computer Interaction', 3, 3, 2, 0],
            ['LITEFILM', 'Literature and Film', 3, 3, 2, 0],
            ['CSELEC11', 'Software Design Patterns', 3, 3, 2, 1],
            ['CSELEC12', 'Software Quality Assurance', 3, 3, 2, 1],
            // 3rd Year, 3rd Term
            ['APPDEVCS', 'Applications Development for Computer Science', 3, 3, 3, 1],
            ['CSELEC13', 'C#.NET Programming (Windows Form)', 3, 3, 3, 1],
            ['CSTHES01', 'Computer Science Thesis 1', 3, 3, 3, 0],
            ['PROFPRAC', 'Social Issues and Professional Practice in Computing', 3, 3, 3, 0],
            ['PROGLANG', 'Structure of Programming Languages', 3, 3, 3, 0],
            // 4th Year, 1st Term
            ['INTERN-1', 'Internship 1', 3, 4, 1, 0],
            // 4th Year, 2nd Term
            ['CSTHES02', 'Computer Science Thesis 2', 3, 4, 2, 0],
            ['INTERN-002', 'Internship 2', 3, 4, 2, 0]
    ];
    
    // Create subjects and curriculum
    foreach ($predefinedSubjects as $subject) {
        list($code, $name, $units, $year_level, $term_number) = $subject;
        
        // Insert subject if it doesn't exist
        $stmt = $pdo->prepare("INSERT IGNORE INTO subjects (code, name, units) VALUES (?, ?, ?)");
        $stmt->execute([$code, $name, $units]);
        
        // Get subject ID
        $stmt = $pdo->prepare("SELECT id FROM subjects WHERE code = ?");
        $stmt->execute([$code]);
        $subjectId = $stmt->fetchColumn();
        
        // Insert into curriculum
        $stmt = $pdo->prepare("INSERT IGNORE INTO curriculum (programid, subjectid, year_level, term_number) VALUES (?, ?, ?, ?)");
        $stmt->execute([$bsseProgramId, $subjectId, $year_level, $term_number]);
    }
    
    // Create test student accounts
    $studentsData = [
        // 2nd Year Student (Account created in 2024, currently in 2nd year final sem)
        [
            'student_number' => '202401501',
            'name' => 'John Michael Santos',
            'program_id' => $bsseProgramId,
            'sex' => 'Male',
            'gender_disclosure' => 1,
            'pronouns' => 'He/Him',
            'mobile' => '09171234567',
            'landline' => '025551234',
            'email' => 'john.santos@student.iacademy.edu.ph',
            'lot_blk' => '123',
            'street' => 'Taft Avenue',
            'zip_code' => 1000,
            'city_municipality' => 'Manila',
            'country' => 'Philippines',
            'created_at' => '2024-06-15 10:30:00', // Created in 2024, now in 2nd year
            'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
            'current_year' => 2,
            'current_term' => 2, // Final semester
            'section' => 'SE-A'
        ],
        
        // 3rd Year Student (Account created in 2023, currently in 3rd year final sem)
        [
            'student_number' => '202301502',
            'name' => 'Maria Elena Rodriguez',
            'program_id' => $bsseProgramId,
            'sex' => 'Female',
            'gender_disclosure' => 1,
            'pronouns' => 'She/Her',
            'mobile' => '09289876543',
            'landline' => '025559876',
            'email' => 'maria.rodriguez@student.iacademy.edu.ph',
            'lot_blk' => '456',
            'street' => 'Ayala Avenue',
            'zip_code' => 1200,
            'city_municipality' => 'Makati',
            'country' => 'Philippines',
            'created_at' => '2023-06-10 14:15:00', // Created in 2023, now in 3rd year
            'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
            'current_year' => 3,
            'current_term' => 2, // Final semester
            'section' => 'SE-B'
        ],
        
        // 4th Year Student (Account created in 2022, currently in 4th year final sem)
        [
            'student_number' => '202201503',
            'name' => 'Alexander James Torres',
            'program_id' => $bsseProgramId,
            'sex' => 'Male',
            'gender_disclosure' => 0,
            'pronouns' => null,
            'mobile' => '09171112233',
            'landline' => '025554455',
            'email' => 'alex.torres@student.iacademy.edu.ph',
            'lot_blk' => '789',
            'street' => 'Ortigas Avenue',
            'zip_code' => 1550,
            'city_municipality' => 'Pasig',
            'country' => 'Philippines',
            'created_at' => '2022-06-20 09:45:00', // Created in 2022, now in 4th year
            'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
            'current_year' => 4,
            'current_term' => 2, // Final semester
            'section' => 'SE-A'
        ]
    ];
    
    foreach ($studentsData as $studentData) {
        // Create family info
        $familyData = [
            'mother_name' => 'Mother of ' . explode(' ', $studentData['name'])[0],
            'father_name' => 'Father of ' . explode(' ', $studentData['name'])[0],
            'mother_mobile_number' => '09' . rand(100000000, 999999999),
            'father_mobile_number' => '09' . rand(100000000, 999999999),
            'mother_email' => strtolower(str_replace(' ', '.', 'mother.' . explode(' ', $studentData['name'])[0])) . '@email.com',
            'father_email' => strtolower(str_replace(' ', '.', 'father.' . explode(' ', $studentData['name'])[0])) . '@email.com',
            'other_contact_name' => 'Emergency Contact for ' . explode(' ', $studentData['name'])[0],
            'other_contact_mobilenum' => '09' . rand(100000000, 999999999),
            'other_contact_email' => strtolower(str_replace(' ', '.', 'emergency.' . explode(' ', $studentData['name'])[0])) . '@email.com'
        ];
        
        $stmt = $pdo->prepare("INSERT INTO family_info (mother_name, father_name, mother_mobile_number, father_mobile_number, mother_email, father_email, other_contact_name, other_contact_mobilenum, other_contact_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array_values($familyData));
        $familyId = $pdo->lastInsertId();
        
        // Create medical history
        $medicalData = [
            'comorb' => 'None',
            'allergies' => 'No known allergies'
        ];
        
        $stmt = $pdo->prepare("INSERT INTO medical_history (comorb, allergies) VALUES (?, ?)");
        $stmt->execute(array_values($medicalData));
        $medicalId = $pdo->lastInsertId();
        
        // Create student
        $stmt = $pdo->prepare("INSERT INTO students (student_number, name, program_id, sex, gender_disclosure, pronouns, mobile, landline, email, lot_blk, street, zip_code, city_municipality, country, created_at, password_hash, family_info_id, medical_historyid) VALUES (?, ?, ?, ?, CAST(? AS UNSIGNED), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $studentData['student_number'],
            $studentData['name'],
            $studentData['program_id'],
            $studentData['sex'],
            $studentData['gender_disclosure'],
            $studentData['pronouns'],
            $studentData['mobile'],
            $studentData['landline'],
            $studentData['email'],
            $studentData['lot_blk'],
            $studentData['street'],
            $studentData['zip_code'],
            $studentData['city_municipality'],
            $studentData['country'],
            $studentData['created_at'],
            $studentData['password_hash'],
            $familyId,
            $medicalId
        ]);
        $studentId = $pdo->lastInsertId();
        
        // Get section ID
        $sectionId = $pdo->prepare("SELECT id FROM sections WHERE name = ?");
        $sectionId->execute([$studentData['section']]);
        $sectionId = $sectionId->fetchColumn();
        
        // Create enrollment history and current enrollment based on year level
        $currentYear = $studentData['current_year'];
        $currentTerm = $studentData['current_term'];
        
        // Calculate school years based on account creation year
        $accountCreationYear = (int)date('Y', strtotime($studentData['created_at']));
        
        // Create enrollment history for all completed years/terms
        for ($year = 1; $year <= $currentYear; $year++) {
            $maxTerm = ($year == $currentYear) ? $currentTerm : 3; // 3 terms per year, except current year
            
            for ($term = 1; $term <= $maxTerm; $term++) {
                // Calculate school year based on when student started
                $schoolYearStart = $accountCreationYear + ($year - 1);
                $schoolYear = $schoolYearStart . '-' . ($schoolYearStart + 1);
                
                // Get subjects for this year and term from curriculum
                $stmt = $pdo->prepare("
                    SELECT s.id as subject_id, s.code, s.units
                    FROM curriculum c
                    JOIN subjects s ON c.subjectid = s.id
                    WHERE c.programid = ? AND c.year_level = ? AND c.term_number = ?
                ");
                $stmt->execute([$bsseProgramId, $year, $term]);
                $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($subjects as $subject) {
                    // Enroll student in class
                    $stmt = $pdo->prepare("INSERT INTO students_class (student_id, subject_id, section_id, term, school_year) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $studentId,
                        $subject['subject_id'],
                        $sectionId,
                        $term,
                        $schoolYear
                    ]);
                    $studentClassId = $pdo->lastInsertId();
                    
                    // Add grades for completed terms (not current term)
                    if (!($year == $currentYear && $term == $currentTerm)) {
                        // Generate realistic grades (1.00 to 3.00, with most being passing grades)
                        $gradeOptions = [1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00];
                        $weights = [15, 20, 25, 20, 10, 5, 3, 1, 1]; // Higher probability for better grades
                        
                        $rand = rand(1, 100);
                        $cumulative = 0;
                        $grade = 3.00; // Default failing grade
                        
                        for ($i = 0; $i < count($gradeOptions); $i++) {
                            $cumulative += $weights[$i];
                            if ($rand <= $cumulative) {
                                $grade = $gradeOptions[$i];
                                break;
                            }
                        }
                        
                        $stmt = $pdo->prepare("INSERT INTO grades (students_class_id, grade) VALUES (?, ?)");
                        $stmt->execute([$studentClassId, $grade]);
                    }
                }
            }
        }
    }
    
    $pdo->commit();
    $message = "<div style='color: green; font-weight: bold; margin: 20px 0;'>✅ Successfully created 3 BSSE test student accounts with complete data!</div>";
    
} catch (Exception $e) {
    $pdo->rollBack();
    $message = "<div style='color: red; font-weight: bold; margin: 20px 0;'>❌ Error: " . $e->getMessage() . "</div>";
}

// Display created accounts info
$accountsInfo = [
    [
        'student_number' => '202401501',
        'name' => 'John Michael Santos',
        'year_level' => '2nd Year (Final Semester)',
        'program' => 'BSSE',
        'password' => 'password123',
        'email' => 'john.santos@student.iacademy.edu.ph',
        'section' => 'SE-A',
        'account_created' => '2024-06-15'
    ],
    [
        'student_number' => '202301502',
        'name' => 'Maria Elena Rodriguez',
        'year_level' => '3rd Year (Final Semester)',
        'program' => 'BSSE',
        'password' => 'password123',
        'email' => 'maria.rodriguez@student.iacademy.edu.ph',
        'section' => 'SE-B',
        'account_created' => '2023-06-10'
    ],
    [
        'student_number' => '202201503',
        'name' => 'Alexander James Torres',
        'year_level' => '4th Year (Final Semester)',
        'program' => 'BSSE',
        'password' => 'password123',
        'email' => 'alex.torres@student.iacademy.edu.ph',
        'section' => 'SE-A',
        'account_created' => '2022-06-20'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSSE Test Accounts Creation</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 20px; 
            background-color: #f8f9fa;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }
        .account-card { 
            border: 1px solid #dee2e6; 
            padding: 25px; 
            margin: 20px 0; 
            border-radius: 8px; 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 5px solid #3498db;
        }
        .account-card h3 { 
            color: #2c3e50; 
            margin-top: 0; 
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .year-badge {
            background: #3498db;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: normal;
        }
        .info-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
            gap: 15px; 
            margin-top: 15px;
        }
        .info-item { 
            padding: 8px 0; 
            border-bottom: 1px solid #eee;
        }
        .info-label { 
            font-weight: bold; 
            color: #495057; 
            margin-right: 10px;
        }
        .info-value { 
            color: #212529; 
        }
        .password { 
            background: #fff3cd; 
            padding: 8px 12px; 
            border-radius: 5px; 
            font-family: 'Courier New', monospace;
            border: 1px solid #ffeaa7;
            display: inline-block;
        }
        .note { 
            background: #d1ecf1; 
            padding: 20px; 
            border-radius: 8px; 
            margin: 25px 0; 
            border-left: 5px solid #17a2b8;
        }
        .note h4 {
            color: #0c5460;
            margin-top: 0;
        }
        .subjects-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 5px solid #28a745;
        }
        .subjects-info h4 {
            color: #155724;
            margin-top: 0;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background: #2980b9;
            text-decoration: none;
            color: white;
        }
        .btn-danger {
            background: #e74c3c;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .success-icon {
            color: #28a745;
            font-size: 1.5em;
        }
        .program-badge {
            background: #17a2b8;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.9em;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧪 BSSE Test Student Accounts Creation</h1>
            <p>Software Engineering Test Accounts with Complete Database Integration</p>
        </div>
        
        <?= $message ?>
        
        <div class="note">
            <h4>📋 Account Creation Logic</h4>
            <p><strong>Year Level Calculation:</strong> Based on account creation date. Students progress one year level for each year since account creation.</p>
            <ul>
                <li><strong>2nd Year Student:</strong> Account created in 2024 → Currently in 2nd year, final semester</li>
                <li><strong>3rd Year Student:</strong> Account created in 2023 → Currently in 3rd year, final semester</li>
                <li><strong>4th Year Student:</strong> Account created in 2022 → Currently in 4th year, final semester</li>
            </ul>
        </div>

        <div class="subjects-info">
            <h4>📚 Curriculum Integration</h4>
            <p>All accounts include complete <strong>Software Engineering curriculum</strong> with:</p>
            <ul>
                <li>✅ 60+ subjects across 4 years (3 terms per year)</li>
                <li>✅ Realistic grade distribution (1.00-3.00)</li>
                <li>✅ Proper enrollment history</li>
                <li>✅ Current semester enrollment</li>
                <li>✅ Family and medical information</li>
            </ul>
        </div>
        
        <h2>👥 Created Test Accounts</h2>
        
        <?php foreach ($accountsInfo as $account): ?>
            <div class="account-card">
                <h3>
                    <span class="success-icon">✅</span>
                    <?= htmlspecialchars($account['name']) ?>
                    <span class="year-badge"><?= htmlspecialchars($account['year_level']) ?></span>
                    <span class="program-badge"><?= htmlspecialchars($account['program']) ?></span>
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Student Number:</span>
                        <span class="info-value"><?= htmlspecialchars($account['student_number']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?= htmlspecialchars($account['email']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Section:</span>
                        <span class="info-value"><?= htmlspecialchars($account['section']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Account Created:</span>
                        <span class="info-value"><?= htmlspecialchars($account['account_created']) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Password:</span>
                        <span class="password"><?= htmlspecialchars($account['password']) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="note">
            <h4>🔐 Login Instructions</h4>
            <p>Use any of the student numbers above with password: <strong>password123</strong></p>
            <p>All accounts have complete data for testing curriculum, grades, schedules, and profile management.</p>
        </div>
        
        <div class="button-container">
            <a href="../public/index.php?page=login" class="btn">🚀 Go to Login</a>
            <a href="deleteTestAccounts.php" class="btn btn-danger">🗑️ Delete Test Accounts</a>
            <a href="createAccountTest.php" class="btn">➕ Create Individual Account</a>
        </div>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; font-size: 14px;">
            <h4>📊 Database Integration Details:</h4>
            <ul>
                <li><strong>Program:</strong> Bachelor of Science in Computer Science with Specialization in Software Engineering (BSSE)</li>
                <li><strong>Sections:</strong> SE-A, SE-B, SE-C</li>
                <li><strong>Subjects:</strong> Complete 4-year curriculum with 60+ subjects</li>
                <li><strong>Grades:</strong> Realistic grade distribution for completed subjects</li>
                <li><strong>Enrollment:</strong> Full enrollment history based on account creation year</li>
            </ul>
        </div>
    </div>
</body>
</html>
