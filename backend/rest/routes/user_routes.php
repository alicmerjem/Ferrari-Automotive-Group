<?php
/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get a user by ID",
 *     description="Returns a single user matching the given ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User returned successfully"
 *     )
 * )
 */
// Get user by ID
Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::userService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     description="Returns a list of all users in the database.",
 *     @OA\Response(
 *         response=200,
 *         description="List of users returned successfully"
 *     )
 * )
 */
// Get all users
Flight::route('GET /users', function(){
    Flight::json(Flight::userService()->getAll());
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a new user",
 *     description="Adds a new user to the system.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password"},
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="securepassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully"
 *     )
 * )
 */
// Add new user
Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->create($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update a user",
 *     description="Updates an existing user's information.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="password", type="string", example="newsecurepassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     )
 * )
 */
// Update user
Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user",
 *     description="Deletes a user with the given ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     )
 * )
 */
// Delete user
Flight::route('DELETE /users/@id', function($id){
    Flight::json(Flight::userService()->delete($id));
});
?>