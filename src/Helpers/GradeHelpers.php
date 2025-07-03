<?php
function gradeDisplay($studentGrades) {
    foreach ($studentGrades as $grade) {
        echo "<tr>
            <td>{$grade['subject_code']}</td>
            <td>{$grade['subject_name']}</td>
            <td>{$grade['section_name']}</td>
            <td>{$grade['units']}</td>
            <td>" . (isset($grade['grade']) && $grade['grade'] !== null ? number_format($grade['grade'], 2) : 'NGS') . "</td>
        </tr>";
    }
}

function calculateGwa($studentGrades) {
    $totalUnits = 0;
    $totalGrade = 0;
    foreach ($studentGrades as $subject) {
        if (!isset($subject['grade']) || $subject['grade'] === null) continue;
        $units = $subject['units'];
        $grade = $subject['grade'];
        $totalUnits += $units;
        $totalGrade += $units * $grade;
    }
    if ($totalUnits > 0) {
        $gwa = $totalGrade / $totalUnits;
        echo number_format($gwa, 2);
    } else {
        echo 'N/A';
    }
}
?>