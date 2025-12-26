<?php
/**
 * @OA\Get(
 *     path="/staff/{id}",
 *     tags={"staff"},
 *     summary="Get a staff member by ID",
 *     description="Returns a single staff member matching the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Staff ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Staff member returned successfully"
 *     )
 * )
 */
// Get staff by ID
Flight::route('GET /staff/@id', function($id){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::staffService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/staff",
 *     tags={"staff"},
 *     summary="Get all staff members",
 *     description="Returns a list of all staff members in the database.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of staff members returned successfully"
 *     )
 * )
 */
// Get all staff
Flight::route('GET /staff', function(){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::staffService()->getAll());
});

/**
 * @OA\Post(
 *     path="/staff",
 *     tags={"staff"},
 *     summary="Create a new staff member",
 *     description="Adds a new staff member to the system.",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "role", "email"},
 *             @OA\Property(property="name", type="string", example="Jane Doe"),
 *             @OA\Property(property="role", type="string", example="Mechanic"),
 *             @OA\Property(property="email", type="string", example="jane@example.com"),
 *             @OA\Property(property="phone", type="string", example="+1234567890")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Staff member created successfully"
 *     )
 * )
 */
// Add new staff
Flight::route('POST /staff', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::staffService()->create($data));
});

/**
 * @OA\Put(
 *     path="/staff/{id}",
 *     tags={"staff"},
 *     summary="Update a staff member",
 *     description="Updates an existing staff member's information.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Staff ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="role", type="string", example="Updated Role"),
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="phone", type="string", example="+9876543210")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Staff member updated successfully"
 *     )
 * )
 */
// Update staff
Flight::route('PUT /staff/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::staffService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/staff/{id}",
 *     tags={"staff"},
 *     summary="Delete a staff member",
 *     description="Deletes a staff member with the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Staff ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Staff member deleted successfully"
 *     )
 * )
 */
// Delete staff
Flight::route('DELETE /staff/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::staffService()->delete($id));
});
?>