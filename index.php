<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $site_url = $_POST['site_url'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_image = $_POST['meta_image'];

    // Create a unique filename based on the current timestamp
    $unique_id = time(); // You can also use other methods like uniqid() or random bytes
    $filename = "idmd_" . $unique_id . '.php';

    // Metadata content to be written into the PHP file
    $metadata = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . htmlspecialchars($meta_title) . '</title>
        <meta name="description" content="' . htmlspecialchars($meta_description) . '">
        <meta property="og:title" content="' . htmlspecialchars($meta_title) . '">
        <meta property="og:description" content="' . htmlspecialchars($meta_description) . '">
        <meta property="og:image" content="' . htmlspecialchars($meta_image) . '">
        <?php header("location: ' . $site_url . '"); ?>
    </head>
    <body>
    </body>
    </html>';

    // Save the file with the unique name
    file_put_contents($filename, $metadata);
    echo "Your metadata at " . $filename;
    // Redirect to the specified URL
    
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metadata Form</title>
</head>
<body>
    <h1>Create Metadata and Redirect</h1>
    <form action="" method="post">
        <label for="site_url">Site URL:</label><br>
        <input type="text" id="site_url" name="site_url" required><br><br>

        <label for="meta_title">Metadata Title:</label><br>
        <input type="text" id="meta_title" name="meta_title" required><br><br>

        <label for="meta_description">Metadata Description:</label><br>
        <textarea id="meta_description" name="meta_description" required></textarea><br><br>

        <label for="meta_image">Metadata Image URL:</label><br>
        <input type="text" id="meta_image" name="meta_image" required><br><br>

        <input type="submit" value="Generate Metadata">
    </form>
</body>
</html>