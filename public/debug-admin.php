<?php
session_start();
echo "<h2>Session Debug</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

if (isset($_SESSION['user'])) {
    echo "<p>✅ Logged in as: " . ($_SESSION['user']['name'] ?? 'no name') . "</p>";
    echo "<p>Role: <strong>" . ($_SESSION['user']['role'] ?? 'no role') . "</strong></p>";

    $role = strtolower($_SESSION['user']['role'] ?? '');
    if ($role === 'admin') {
        echo "<p style='color:green;'>✅ Role 'admin' TERDETEKSI!</p>";
    } else {
        echo "<p style='color:red;'>❌ Role bukan 'admin' (case-sensitive!)</p>";
    }
} else {
    echo "<p style='color:red;'>❌ Tidak login!</p>";
}
?>