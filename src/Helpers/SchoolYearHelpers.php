<?php
// src/Helpers/SchoolYearHelpers.php
// Helper to fetch the current school year and term

function getCurrentSchoolYearAndTerm(PDO $pdo) {
    $stmt = $pdo->query("SELECT school_year, term FROM school_years WHERE is_current = 1 LIMIT 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return $row;
    } else {
        // Fallback: get the latest if none is marked current
        $stmt = $pdo->query("SELECT school_year, term FROM school_years ORDER BY school_year DESC, term DESC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: ['school_year' => null, 'term' => null];
    }
}
?>