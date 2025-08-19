<?php
// Set CORS headers to allow requests from your frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Define a directory for uploaded files. Make sure this folder is writable.
$uploadDirectory = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400); 
        echo json_encode(['message' => 'No file was uploaded or there was an upload error.']);
        exit;
    }

    $file = $_FILES['image'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['message' => 'File type not allowed.']);
        exit;
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $uniqueFilename = uniqid() . '.' . $extension;
    $destination = $uploadDirectory . $uniqueFilename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        
        // The URL now correctly uses your domain.
        $imageUrl = 'https://ghostwhite-eel-836203.hostingersite.com/' . $uploadDirectory . $uniqueFilename;

        http_response_code(200); 
        echo json_encode([
            'message' => 'File uploaded successfully!',
            'url' => $imageUrl
        ]);
    } else {
        http_response_code(500); 
        echo json_encode(['message' => 'Failed to move the uploaded file.']);
    }

} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
?>