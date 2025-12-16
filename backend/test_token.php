<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

// Test token extraction
$authHeader = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."; // Your actual token

if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
    echo "Token extracted successfully!\n";
    echo "Token: " . substr($matches[1], 0, 50) . "...\n";
} else {
    echo "Failed to extract token\n";
}