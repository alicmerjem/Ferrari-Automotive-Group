<?php
/**
 * @OA\Get(
 *     path="/testdrives/{id}",
 *     tags={"testdrives"},
 *     summary="Get a test drive by ID",
 *     description="Returns a single test drive matching the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Test drive ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Test drive returned successfully"
 *     )
 * )
 */
// Get testdrive by ID
Flight::route('GET /testdrives/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::testdriveService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/testdrives",
 *     tags={"testdrives"},
 *     summary="Get all test drives",
 *     description="Returns a list of all test drives in the database.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of test drives returned successfully"
 *     )
 * )
 */
// Get all testdrives
Flight::route('GET /testdrives', function(){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::testdriveService()->getAll());
});

/**
 * @OA\Post(
 *     path="/testdrives",
 *     tags={"testdrives"},
 *     summary="Create a new test drive",
 *     description="Adds a new test drive to the system.",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "car_id", "scheduled_date"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="car_id", type="integer", example=3),
 *             @OA\Property(property="scheduled_date", type="string", format="date-time", example="2025-11-20T14:30:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Test drive created successfully"
 *     )
 * )
 */
// Add new testdrive
Flight::route('POST /testdrives', function(){
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::testdriveService()->create($data));
});

/**
 * @OA\Put(
 *     path="/testdrives/{id}",
 *     tags={"testdrives"},
 *     summary="Update a test drive",
 *     description="Updates an existing test drive's information.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Test drive ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="car_id", type="integer", example=3),
 *             @OA\Property(property="scheduled_date", type="string", format="date-time", example="2025-11-21T10:00:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Test drive updated successfully"
 *     )
 * )
 */
// Update testdrive
Flight::route('PUT /testdrives/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::testdriveService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/testdrives/{id}",
 *     tags={"testdrives"},
 *     summary="Delete a test drive",
 *     description="Deletes a test drive with the given ID.",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Test drive ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Test drive deleted successfully"
 *     )
 * )
 */
// Delete testdrive
Flight::route('DELETE /testdrives/@id', function($id){
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::testdriveService()->delete($id));
});
?>