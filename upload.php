<?php
if (isset($_POST['submit'])) {
    $uploadDir = 'uploads/';
    $webpDir = 'webp/';
    
    // Create directories if not exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    if (!is_dir($webpDir)) {
        mkdir($webpDir, 0755, true);
    }

    // Loop through each file
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['images']['name'][$key]);
        $uploadFile = $uploadDir . $fileName;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($tmpName, $uploadFile)) {
            // Get image dimensions
            list($width, $height) = getimagesize($uploadFile);
            $newWidth = $width / 2;  // Reducing the size by half
            $newHeight = $height / 2; // Reducing the size by half

            // Load the image
            $image = imagecreatefromjpeg($uploadFile);
            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            // Resize the image
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // Convert to WebP format
            $webpFile = $webpDir . pathinfo($fileName, PATHINFO_FILENAME) . '.webp';
            imagewebp($newImage, $webpFile);

            // Free up memory
            imagedestroy($image);
            imagedestroy($newImage);

            echo "Successfully uploaded and converted: " . $fileName . "<br>";
        } else {
            echo "Failed to upload: " . $fileName . "<br>";
        }
    }
}
?>
