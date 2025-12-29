<?php
/**
 * @OA\Get(
 *     path="/services/{id}",
 *     tags={"services"},
 *     summary="Get a service by ID",
 *     description="Returns a single service matching the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Service ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Service returned successfully"
 *     )
 * )
 */
// Get service by ID
Flight::route('GET /services/@id', function($id){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::serviceService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/services",
 *     tags={"services"},
 *     summary="Get all services",
 *     description="Returns a list of all services in the database.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of services returned successfully"
 *     )
 * )
 */
// Get all services
Flight::route('GET /services', function(){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::serviceService()->getAll());
});

/**
 * @OA\Post(
 *     path="/services",
 *     tags={"services"},
 *     summary="Create a new service",
 *     description="Adds a new service to the system.",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"car_id" ,"service_type", "notes"},
 *             @OA\Property(property="car_id", type="integer", example=2),
 *             @OA\Property(property="service_type", type="string", example="Oil Change"),
 *             @OA\Property(property="notes", type="string", example="Full synthetic oil change")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Service created successfully"
 *     )
 * )
 */
// Add new service
Flight::route('POST /services', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    $user = Flight::get('user');
    $data['user_id'] = $user->user_id;
    Flight::json(Flight::serviceService()->create($data));
});

/**
 * @OA\Put(
 *     path="/services/{id}",
 *     tags={"services"},
 *     summary="Update a service",
 *     description="Updates an existing service's information.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Service ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="service_type", type="string", example="Updated Service Name"),
 *             @OA\Property(property="notes", type="string", example="Updated description")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Service updated successfully"
 *     )
 * )
 */
// Update service
Flight::route('PUT /services/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/services/{id}",
 *     tags={"services"},
 *     summary="Delete a service",
 *     description="Deletes a service with the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Service ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Service deleted successfully"
 *     )
 * )
 */
// Delete service
Flight::route('DELETE /services/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::serviceService()->delete($id));
});
?>