<?php
/**
 * @OA\Get(
 *     path="/contacts/{id}",
 *     tags={"contacts"},
 *     summary="Get a contact by ID",
 *     description="Returns a single contact matching the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Contact ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact returned successfully"
 *     )
 * )
 */
// Get contact by ID
Flight::route('GET /contacts/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);    
    Flight::json(Flight::contactService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/contacts",
 *     tags={"contacts"},
 *     summary="Get all contacts",
 *     description="Returns a list of all contacts in the database.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of contacts returned successfully"
 *     )
 * )
 */
// Get all contacts
Flight::route('GET /contacts', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::contactService()->getAll());
});

/**
 * @OA\Post(
 *     path="/contacts",
 *     tags={"contacts"},
 *     summary="Create a new contact",
 *     description="Adds a new contact to the system.",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "phone"},
 *             @OA\Property(property="first_name", type="string", example="John"),
 *             @OA\Property(property="last_name", type="string", example="Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="phone", type="string", example="+1234567890"),
 *             @OA\Property(property="message", type="string", example="I am interested in your services")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact created successfully"
 *     )
 * )
 */
// Add new contact
Flight::route('POST /contacts', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactService()->create($data));
});

/**
 * @OA\Put(
 *     path="/contacts/{id}",
 *     tags={"contacts"},
 *     summary="Update a contact",
 *     description="Updates an existing contact's information.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Contact ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string", example="Updated"),
 *             @OA\Property(property="last_name", type="string", example="Name"),
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="phone", type="string", example="+9876543210"),
 *             @OA\Property(property="message", type="string", example="Updated message content")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact updated successfully"
 *     )
 * )
 */
// Update contact
Flight::route('PUT /contacts/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/contacts/{id}",
 *     tags={"contacts"},
 *     summary="Delete a contact",
 *     description="Deletes a contact with the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Contact ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Contact deleted successfully"
 *     )
 * )
 */
// Delete contact
Flight::route('DELETE /contacts/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::contactService()->delete($id));
});
?>