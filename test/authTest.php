<?php
function loginUser($pdo, $id, $password) {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();

    echo "<h2>Debug: User fetched = " . htmlspecialchars(print_r($user, true)) . "</h2>";

    if ($user && $password === $user['password_hash']) {
        echo "<h2>Welcome, " . htmlspecialchars($user['name']) . " (ID: " . htmlspecialchars($user['id']) . ")!</h2>";
    } else {
        echo "<h2>Invalid ID or password UWU.</h2>";
    }
}
?>