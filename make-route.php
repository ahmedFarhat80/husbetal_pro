<?php

// Create a new route file named doctor.php in the routes directory
$file = __DIR__ . '/routes/doctor.php';

if (!file_exists($file)) {
    $contents = "<?php\n\n";
    file_put_contents($file, $contents);
    echo "Doctor route file created successfully!\n";
} else {
    echo "Doctor route file already exists!\n";
}
