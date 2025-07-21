<?php

 /*
    subjects:
    id: primary_key
    code: varchar(20)
    name: varchar(100)
    units: int
    */

    /*
    Subject Codes:
    === 1st Year ===
    FUNDPROG - Fundamentals of Programming (3)
    INTROICT - Introduction to ICT (3)
    PHYEDU01 - Physical Education 1 (2.0)
    STECHSOC - Science, Technology, and Society (3)
    CONWORLD - Contemporary World (3)
    UNDESELF - Understanding the Self (3)
    EUTENICS - Euthenics (1.0)
    === 1st Year 2nd term ===
    ADVAPROG - Advanced Programming (3)
    LOGICDES - Digital Logic Design (3)
    ETHIPROF - Ethics and Professionalism (3)
    FILIPIN1 - Kontekstwalisadong Komunikasyon sa Filipino (3)
    MATHMODE - Mathematics in the Modern World (3)
    OPERSYST - Operating Systems (3)
    PHYEDU02 - Physical Education 2 (Rhythmic Activities and Dance) (2.0)
    === 1st Year 3rd term ===
    ARTAPPRE - Art Appreciation (3)
    DATSTRUC - Data Structures and Algorithms (3)
    OBJECPRG - Object Oriented Programming (3)
    PHYEDU03 - Physical Education 3 (Individual/Dual Sports) (2.0)
    PURPCOMM - Purposive Communication (3)
    READHIST - Readings in Philippine History (3)
    NSTPT001 - National Service Training Program 1 (3)
    COMPARCH - Computer Architecture (3)
    === 2nd Year ==
    CSELEC01 - Core Java Programming 1 (3)
    DISCMATH - Discrete Mathematics (3)
    INFORMAN - Information Management and Database Systems (3)
    PHYEDU04 - Physical Education 4 (Team Sports) (2.0)
    NSTPT002 - National Service Training Program 2 (3)
    === 2nd Year 2nd term ==
    CSELEC02 - Core Java Programming 2 (3)
    FILIPIN2 - Filipino sa Iba't Ibang Disiplina (3)
    CSELEC03 - Fundamentals of Web Programming (3)
    RIZALIFE - Rizal's Life, Works, and Writings (3)
    SOFTENG1 - Software Engineering 1 (3)
    CSELEC04 - Unified Modelling Language (3)
    === 2nd Year 3rd term ==
    CSELEC05 - Enterprise Java Programming 1 (3)
    CSELEC06 - Advanced Web Programming (3)
    CSELEC07 - Mobile Computing 1 (3)
    DATACOMM - Data Communications (3)
    SOFTENG2 - Software Engineering 2 (3)
    === 3rd Year ==
    AUTOMATA - Automata Theory and Formal Languages (3)
    CSELEC09 - Enterprise Java Programming 2 (3)
    INFOSECU - Information Assurance and Security (3)
    CSELEC10 - Introduction to Artificial Intelligence (3)
    CSELEC08 - Mobile Computing 2 (3)
    === 3rd Year 2nd term ==
    ALGORTHM - Analysis of Algorithms (3)
    HUCOMINT - Human Computer Interaction (3)
    LITEFILM - Literature and Film (3)
    CSELEC11 - Software Design Patterns (3)
    CSELEC12 - Software Quality Assurance (3)
    === 3rd Year 3rd term ==
    APPDEVCS - Applications Development for Computer Science (3)
    CSELEC13 - C#.NET Programming (Windows Form) (3)
    CSTHES01 - Computer Science Thesis 1 (3)
    PROFPRAC - Social Issues and Professional Practice in Computing (3)
    PROGLANG - Structure of Programming Languages (3)
    === 4th Year ==
    INTERN-1 - Internship 1 (3)
    === 4th Year 2nd term ==
    CSTHES02 - Computer Science Thesis 2 (3)
    INTERN-002 - Internship 2 (3)
    */

    

// Database connection
require_once __DIR__ . '/../config.php';
$config = require __DIR__ . '/../config.php';
$dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['user'], $config['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch available programs
$programs = $pdo->query("SELECT id, program_name, course_code FROM program ORDER BY program_name")->fetchAll(PDO::FETCH_ASSOC);

// Simple form to add a new subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject'])) {
    $code = $_POST['code'] ?? '';
    $name = $_POST['name'] ?? '';
    $units = $_POST['units'] ?? '';
    $program_id = $_POST['program_id'] ?? '';
    $year_level = $_POST['year_level'] ?? '';
    $term_number = $_POST['term_number'] ?? '';
    $is_laboratory = isset($_POST['is_laboratory']) ? 1 : 0;

    if ($code && $name && $units && $program_id && $year_level && $term_number) {
        $pdo->beginTransaction();
        try {
            // Insert into subjects table
            $stmt = $pdo->prepare("INSERT INTO subjects (code, name, units, is_laboratory) VALUES (?, ?, ?, ?)");
            $stmt->execute([$code, $name, $units, $is_laboratory]);
            $subject_id = $pdo->lastInsertId();
            // Insert into curriculum table with year and term
            $curriculumStmt = $pdo->prepare("INSERT INTO curriculum (programid, subjectid, year_level, term_number) VALUES (?, ?, ?, ?)");
            $curriculumStmt->execute([$program_id, $subject_id, $year_level, $term_number]);
            $pdo->commit();
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span><br>";
        }
    } else {
        echo "<span style='color:red'>All fields are required.</span><br>";
    }
}

// Bulk generation functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_all_subjects'])) {
    $program_id_bulk = $_POST['program_id_bulk'] ?? '';
    
    if (!$program_id_bulk) {
        echo "<span style='color:red'>Please select a program for bulk generation.</span><br>";
    } else {
        // Predefined subjects array with year and term organization
        // [code, name, units, year_level, term_number, is_laboratory]
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
        try {
            $pdo->beginTransaction();
            foreach ($predefinedSubjects as $subj) {
                $stmt = $pdo->prepare("INSERT INTO subjects (code, name, units, is_laboratory) VALUES (?, ?, ?, ?)");
                $stmt->execute([$subj[0], $subj[1], $subj[2], $subj[5]]);
                $subject_id = $pdo->lastInsertId();
                $curriculumStmt = $pdo->prepare("INSERT INTO curriculum (programid, subjectid, year_level, term_number) VALUES (?, ?, ?, ?)");
                $curriculumStmt->execute([$program_id_bulk, $subject_id, $subj[3], $subj[4]]);
            }
            $pdo->commit();
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span><br>";
        }
                $checkStmt->execute([$code]);
                
                if ($checkStmt->rowCount() > 0) {
                    $subject_id = $checkStmt->fetchColumn();
                    $skippedCount++;
                    echo "<span style='color:orange'>⚠ Skipped (already exists): $code - $name</span><br>";
                    
                    // Check if curriculum entry exists
                    $curriculumCheckStmt = $pdo->prepare("SELECT * FROM curriculum WHERE programid = ? AND subjectid = ?");
                    $curriculumCheckStmt->execute([$program_id_bulk, $subject_id]);
                    
                    if ($curriculumCheckStmt->rowCount() == 0) {
                        // Add to curriculum if not already linked
                        $curriculumStmt = $pdo->prepare("INSERT INTO curriculum (programid, subjectid, year_level, term_number) VALUES (?, ?, ?, ?)");
                        $curriculumStmt->execute([$program_id_bulk, $subject_id, $year_level, $term_number]);
                        echo "<span style='color:blue'>  ➤ Added to curriculum (Year $year_level, Term $term_number)</span><br>";
                    } else {
                        // Update existing curriculum entry with year/term if missing
                        $existingCurriculum = $curriculumCheckStmt->fetch(PDO::FETCH_ASSOC);
                        if (!$existingCurriculum['year_level'] || !$existingCurriculum['term_number']) {
                            $updateStmt = $pdo->prepare("UPDATE curriculum SET year_level = ?, term_number = ? WHERE programid = ? AND subjectid = ?");
                            $updateStmt->execute([$year_level, $term_number, $program_id_bulk, $subject_id]);
                            echo "<span style='color:blue'>  ➤ Updated curriculum with year/term info</span><br>";
                        }
                    }
                } else {
                    // Insert new subject
                    $stmt = $pdo->prepare("INSERT INTO subjects (code, name, units, is_laboratory) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$code, $name, $units, $is_laboratory]);
                    $subject_id = $pdo->lastInsertId();
                    
                    // Insert into curriculum with year and term
                    $curriculumStmt = $pdo->prepare("INSERT INTO curriculum (programid, subjectid, year_level, term_number) VALUES (?, ?, ?, ?)");
                    $curriculumStmt->execute([$program_id_bulk, $subject_id, $year_level, $term_number]);
                    
                    $successCount++;
                    echo "<span style='color:green'>✓ Added: $code - $name ($units units) + curriculum link (Year $year_level, Term $term_number)</span><br>";
                }
                
                $pdo->commit();
            } catch (Exception $e) {
                $pdo->rollBack();
                $errorCount++;
                echo "<span style='color:red'>✗ Error with $code: " . htmlspecialchars($e->getMessage()) . "</span><br>";
            }
        }
        
        echo "<br><strong>Summary:</strong><br>";
        echo "<span style='color:green'>Successfully added: $successCount subjects</span><br>";
        echo "<span style='color:orange'>Skipped (already exist): $skippedCount subjects</span><br>";
        if ($errorCount > 0) {
            echo "<span style='color:red'>Errors: $errorCount subjects</span><br>";
        }
    }
}

?>

<form method="post">
    <h2>Add New Subject</h2>
    
    <label for="program_id">Program:</label><br>
    <select name="program_id" id="program_id" required>
        <option value="">Select Program</option>
        <?php foreach ($programs as $program): ?>
            <option value="<?= htmlspecialchars($program['id']) ?>">
                <?= htmlspecialchars($program['course_code']) ?> - <?= htmlspecialchars($program['program_name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    
    <label for="code">Subject Code:</label><br>
    <input name="code" id="code" maxlength="20" required><br><br>
    
    <label for="name">Subject Name:</label><br>
    <input name="name" id="name" maxlength="100" required><br><br>
    
    <label for="units">Units:</label><br>
    <input name="units" id="units" type="number" step="0.1" min="0" required><br><br>
    
    <label for="year_level">Year Level:</label><br>
    <select name="year_level" id="year_level" required>
        <option value="">Select Year</option>
        <option value="1">1st Year</option>
        <option value="2">2nd Year</option>
        <option value="3">3rd Year</option>
        <option value="4">4th Year</option>
    </select><br><br>

    <label for="term_number">Term:</label><br>
    <select name="term_number" id="term_number" required>
        <option value="">Select Term</option>
        <option value="1">1st Term</option>
        <option value="2">2nd Term</option>
        <option value="3">3rd Term</option>
    </select><br><br>

    <label for="is_laboratory">
        <input type="checkbox" name="is_laboratory" id="is_laboratory" value="1">
        Laboratory Subject (requires computers/lab)
    </label><br><br>

    <button type="submit" name="add_subject">Add Subject & Link to Curriculum</button>
</form>

<hr>

<form method="post" style="margin-top: 20px;">
    <h2>🚀 Bulk Generate All CS Subjects</h2>
    <p>Generate all 54 Computer Science subjects and link them to the selected program's curriculum.</p>
    
    <label for="program_id_bulk">Program:</label><br>
    <select name="program_id_bulk" id="program_id_bulk" required>
        <option value="">Select Program for Bulk Generation</option>
        <?php foreach ($programs as $program): ?>
            <option value="<?= htmlspecialchars($program['id']) ?>">
                <?= htmlspecialchars($program['course_code']) ?> - <?= htmlspecialchars($program['program_name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>
    
    <button type="submit" name="generate_all_subjects" onclick="return confirm('Are you sure you want to generate all 54 CS subjects for the selected program? This will also link them to the curriculum.');" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
        📚 Generate All 54 CS Subjects + Curriculum Links
    </button>
</form>

<hr>
