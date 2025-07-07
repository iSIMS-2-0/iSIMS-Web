<?php
// Test script to verify dynamic school year selection
require_once '../config.php';
require_once '../src/Models/User.php';

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $userModel = new User($pdo);
    
    // Test with one of our test accounts
    $testStudentNumber = '202101001'; // 2nd year test student
    $student = $userModel->findByStudentNumber($testStudentNumber);
    
    if ($student) {
        echo "Testing with student: " . $student['name'] . " (ID: " . $student['id'] . ")\n";
        
        $creationYear = $userModel->getStudentCreationYear($student['id']);
        echo "Account creation year: " . $creationYear . "\n";
        
        // Generate available school years
        $availableSchoolYears = [];
        $currentYear = date('Y');
        for ($year = $creationYear; $year <= $currentYear; $year++) {
            $schoolYear = $year . '-' . ($year + 1);
            $availableSchoolYears[] = $schoolYear;
        }
        
        echo "Available school years:\n";
        foreach ($availableSchoolYears as $sy) {
            echo "- " . $sy . "\n";
        }
    } else {
        echo "Test student not found. Please run createBSSETestAccounts.php first.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
