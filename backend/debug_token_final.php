<?php
// debug_token_final.php
require_once __DIR__ . '/vendor/autoload.php';

// Use your actual JWT secret from config.php
$JWT_SECRET = 'Ec2FISbLxDeIe9GrpuhjC03yzPvjRWvM';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

echo "=== JWT TOKEN DEBUG ===\n\n";

// PASTE YOUR TOKEN HERE (from Swagger login response)
$yourToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjp7InVzZXJfaWQiOjE2LCJmaXJzdF9uYW1lIjoiSm9obiIsImxhc3RfbmFtZSI6IkRvZSIsImVtYWlsIjoiY3VzdG9tZXJAZXhhbXBsZS5jb20iLCJjcmVhdGVkX2F0IjoiMjAyNS0xMi0xMiAyMTowMTozNCIsInJvbGUiOiJjdXN0b21lciJ9LCJpYXQiOjE3NjU1ODcyMDUsImV4cCI6MTc2NTY3MzYwNX0.on7ZuCnz_1u8nMkuFJD5mGSdSM1uyFZ4-uEz9R1iCaQ';

echo "Token: " . substr($yourToken, 0, 50) . "...\n\n";
echo "JWT Secret: " . $JWT_SECRET . "\n";
echo "Secret length: " . strlen($JWT_SECRET) . "\n\n";

try {
    $decoded = JWT::decode($yourToken, new Key($JWT_SECRET, 'HS256'));
    echo "✓ SUCCESS: Token decoded!\n\n";
    echo "Full decoded token:\n";
    print_r($decoded);
    
    echo "\n=== Checking user property ===\n";
    if (isset($decoded->user)) {
        echo "✓ Has 'user' property\n";
        echo "User role: " . ($decoded->user->role ?? 'NOT SET') . "\n";
    } else {
        echo "✗ NO 'user' property!\n";
    }
} catch (Exception $e) {
    echo "✗ FAILED: " . $e->getMessage() . "\n";
    
    // Show token parts
    echo "\n=== Token parts ===\n";
    $parts = explode('.', $yourToken);
    if (count($parts) === 3) {
        echo "Header: " . base64_decode($parts[0]) . "\n";
        echo "Payload: " . base64_decode($parts[1]) . "\n";
    }
}