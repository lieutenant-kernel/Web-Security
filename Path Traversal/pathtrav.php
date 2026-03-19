<?php
// vulnerable_page.php
// Simple PHP page with path traversal vulnerability for authorized testing

// Get the pic parameter from the URL
$picture = $_GET['pic'] ?? '';

if (!empty($picture)) {
    // Vulnerable: Directly concatenating user input into file path
    $file_path = "images/" . $picture;
    
    // Check if file exists
    if (file_exists($file_path)) {
        // Serve the image
        header('Content-Type: ' . mime_content_type($file_path));
        readfile($file_path);
    } else {
        echo "File not found: " . htmlspecialchars($file_path);
    }
} else {
    echo "Usage: ?picture=filename.jpg (Vulnerable to path traversal!)";
}
?>
