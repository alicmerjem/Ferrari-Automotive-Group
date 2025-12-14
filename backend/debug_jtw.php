<?php
// debug_jwt.php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

echo "=== JWT DEBUG ===\n";

// 1. First, let's create a test token
$testPayload = [
    'user' => [
        'user_id' => 1,
        'email' => 'test@example.com',
        'role' => 'customer',
        'first_name' => 'Test',
        'last_name' => 'User'
    ],
    'iat' => time(),
    'exp' => time() + 3600 // 1 hour
];

$secret = Database::JWT_SECRET();
echo "JWT Secret: " . $secret . "\n";
echo "Secret length: " . strlen($secret) . "\n";

$testToken = JWT::encode($testPayload, $secret, 'HS256');
echo "Test token created: " . substr($testToken, 0, 50) . "...\n";

// 2. Now decode it back
try {
    $decoded = JWT::decode($testToken, new Key($secret, 'HS256'));
    echo "✓ Test token decoded successfully!\n";
    echo "Decoded structure:\n";
    print_r($decoded);
} catch (Exception $e) {
    echo "✗ Test token decode failed: " . $e->getMessage() . "\n";
}

echo "\n=== Now test your actual token ===\n";

// 3. Test your actual token from login
// PASTE YOUR ACTUAL TOKEN HERE (the one from /auth/login response)
$yourToken = 'PASTE_YOUR_ACTUAL_TOKEN_HERE';

if ($yourToken && $yourToken !== 'PASTE_YOUR_ACTUAL_TOKEN_HERE') {
    echo "Your token: " . substr($yourToken, 0, 50) . "...\n";
    
    try {
        $decodedYour = JWT::decode($yourToken, new Key($secret, 'HS256'));
        echo "✓ Your token decoded successfully!\n";
        echo "Your token structure:\n";
        print_r($decodedYour);
        
        // Check if it has 'user' property
        if (isset($decodedYour->user)) {
            echo "✓ Has 'user' property\n";
            echo "User role: " . ($decodedYour->user->role ?? 'NOT SET') . "\n";
        } else {
            echo "✗ NO 'user' property in token!\n";
            echo "Available properties:\n";
            foreach ($decodedYour as $key => $value) {
                echo "  $key: " . (is_object($value) || is_array($value) ? print_r($value, true) : $value) . "\n";
            }
        }
    } catch (Exception $e) {
        echo "✗ Your token decode failed: " . $e->getMessage() . "\n";
    }
} else {
    echo "Please paste your actual token in the code.\n";
}

echo "\n=== Check AuthService token creation ===\n";
// Check what AuthService is doing
require_once __DIR__ . '/rest/services/AuthService.php';
$authService = new AuthService();

// Create a test user array like AuthService would
$testUser = [
    'user_id' => 1,
    'email' => 'test@example.com',
    'first_name' => 'Test',
    'last_name' => 'User',
    'role' => 'customer',
    'created_at' => date('Y-m-d H:i:s')
];

$testPayload2 = [
    'user' => $testUser,
    'iat' => time(),
    'exp' => time() + (60 * 60 * 24)
];

echo "Test payload AuthService would create:\n";
print_r($testPayload2);

$testToken2 = JWT::encode($testPayload2, $secret, 'HS256');
echo "\nToken AuthService would create: " . substr($testToken2, 0, 50) . "...\n";