<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * @OA\Post(
 *     path="/auth/register",
 *     tags={"auth"},
 *     summary="Register new user",
 *     description="Adds a new user to the system.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password", "first_name", "last_name"},
 *             @OA\Property(property="email", type="string", example="customer@example.com"),
 *             @OA\Property(property="password", type="string", example="secure_password"),
 *             @OA\Property(property="first_name", type="string", example="John"),
 *             @OA\Property(property="last_name", type="string", example="Doe")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully"
 *     )
 * )
 */
// Register new user
Flight::route('POST /auth/register', function(){
    try {
        $data = Flight::request()->data->getData();
        $result = Flight::auth_service()->register($data);
        Flight::json($result);
    } catch (Exception $e) {
        Flight::halt(500, $e->getMessage());
    }
});

/**
 * @OA\Post(
 *     path="/auth/login", 
 *     tags={"auth"},
 *     summary="Login user",
 *     description="Authenticates user and returns JWT token.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="customer@example.com"),
 *             @OA\Property(property="password", type="string", example="secure_password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User logged in successfully"
 *     )
 * )
 */
// Login user
Flight::route('POST /auth/login', function(){
    try {
        $data = Flight::request()->data->getData();
        $result = Flight::auth_service()->login($data);
        Flight::json($result);
    } catch (Exception $e) {
        Flight::halt(500, $e->getMessage());
    }
});