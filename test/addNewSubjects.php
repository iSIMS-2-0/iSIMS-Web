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
    FUNDPROG - Fundamentals of Programming (3)
    INTROICT - Introduction to ICT (3)
    PHYEDU01 - Physical Education 1 (2.0)
    STECHSOC - Science, Technology, and Society (3)
    CONWORLD - Contemporary World (3)
    UNDESELF - Understanding the Self (3)
    EUTENICS - Euthenics (1.0)
    ADVAPROG - Advanced Programming (3)
    LOGICDES - Digital Logic Design (3)
    ETHIPROF - Ethics and Professionalism (3)
    FILIPIN1 - Kontekstwalisadong Komunikasyon sa Filipino (3)
    MATHMODE - Mathematics in the Modern World (3)
    OPERSYST - Operating Systems (3)
    PHYEDU02 - Physical Education 2 (Rhythmic Activities and Dance) (2.0)
    ARTAPPRE - Art Appreciation (3)
    DATSTRUC - Data Structures and Algorithms (3)
    OBJECPRG - Object Oriented Programming (3)
    PHYEDU03 - Physical Education 3 (Individual/Dual Sports) (2.0)
    PURPCOMM - Purposive Communication (3)
    READHIST - Readings in Philippine History (3)
    NSTPT001 - National Service Training Program 1 (3)
    COMPARCH - Computer Architecture (3)
    CSELEC01 - Core Java Programming 1 (3)
    DISCMATH - Discrete Mathematics (3)
    INFORMAN - Information Management and Database Systems (3)
    PHYEDU04 - Physical Education 4 (Team Sports) (2.0)
    NSTPT002 - National Service Training Program 2 (3)
    CSELEC02 - Core Java Programming 2 (3)
    FILIPIN2 - Filipino sa Iba't Ibang Disiplina (3)
    CSELEC03 - Fundamentals of Web Programming (3)
    RIZALIFE - Rizal's Life, Works, and Writings (3)
    SOFTENG1 - Software Engineering 1 (3)
    CSELEC04 - Unified Modelling Language (3)
    CSELEC05 - Enterprise Java Programming 1 (3)
    CSELEC06 - Advanced Web Programming (3)
    CSELEC07 - Mobile Computing 1 (3)
    DATACOMM - Data Communications (3)
    SOFTENG2 - Software Engineering 2 (3)
    AUTOMATA - Automata Theory and Formal Languages (3)
    CSELEC09 - Enterprise Java Programming 2 (3)
    INFOSECU - Information Assurance and Security (3)
    CSELEC10 - Introduction to Artificial Intelligence (3)
    CSELEC08 - Mobile Computing 2 (3)
    ALGORTHM - Analysis of Algorithms (3)
    HUCOMINT - Human Computer Interaction (3)
    LITEFILM - Literature and Film (3)
    CSELEC11 - Software Design Patterns (3)
    CSELEC12 - Software Quality Assurance (3)
    APPDEVCS - Applications Development for Computer Science (3)
    CSELEC13 - C#.NET Programming (Windows Form) (3)
    CSTHES01 - Computer Science Thesis 1 (3)
    PROFPRAC - Social Issues and Professional Practice in Computing (3)
    PROGLANG - Structure of Programming Languages (3)
    INTERN-1 - Internship 1 (3)
    CSTHES02 - Computer Science Thesis 2 (3)
    INTERN-002 - Internship 2 (3)
    */

    

// Simple form to add a new subject
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject'])) {
    $code = $_POST['code'] ?? '';
    $name = $_POST['name'] ?? '';
    $units = $_POST['units'] ?? '';
    if ($code && $name && $units) {
        require_once __DIR__ . '/../config.php';
        $config = require __DIR__ . '/../config.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("INSERT INTO subjects (code, name, units) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$code, $name, $units]);
            echo "<span style='color:green'>Subject added: $code - $name ($units units)</span><br>";
        } catch (Exception $e) {
            echo "<span style='color:red'>Error: ".htmlspecialchars($e->getMessage())."</span><br>";
        }
    }
}
?>
<form method="post">
    <h2>Add New Subject</h2>
    Subject Code: <input name="code" maxlength="20" required><br>
    Subject Name: <input name="name" maxlength="100" required><br>
    Units: <input name="units" type="number" step="0.1" min="0" required><br>
    <button type="submit" name="add_subject">Add Subject</button>
</form>
