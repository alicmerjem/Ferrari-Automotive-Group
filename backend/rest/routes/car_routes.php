<?php
/**
 * @OA\Get(
 *     path="/cars/{id}",
 *     tags={"cars"},
 *     summary="Get a car by ID",
 *     description="Returns a single car matching the given ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Car ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car returned successfully"
 *     )
 * )
 */
// Get a specific car by ID
Flight::route('GET /cars/@id', function($id){
    Flight::json(Flight::carService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/cars",
 *     tags={"cars"},
 *     summary="Get all cars",
 *     description="Returns a list of all cars in the database.",
 *     @OA\Response(
 *         response=200,
 *         description="List of cars returned successfully"
 *     )
 * )
 */
// Get cars with optional filter
Flight::route('GET /cars', function(){
    Flight::json(Flight::carService()->getAll());
});

/**
 * @OA\Post(
 *     path="/cars",
 *     tags={"cars"},
 *     summary="Create a new car",
 *     description="Adds a new car to the system.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"brand", "model", "year", "price"},
 *             @OA\Property(property="brand", type="string", example="Ferrari"),
 *             @OA\Property(property="model", type="string", example="F8 Tributo"),
 *             @OA\Property(property="year", type="integer", example=2021),
 *             @OA\Property(property="price", type="number", example=250000)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car created successfully"
 *     )
 * )
 */
// Add a new car
Flight::route('POST /cars', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->create($data));
});

/**
 * @OA\Put(
 *     path="/cars/{id}",
 *     tags={"cars"},
 *     summary="Update a car",
 *     description="Updates an existing car's information.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Car ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="brand", type="string", example="Updated Brand"),
 *             @OA\Property(property="model", type="string", example="Updated Model"),
 *             @OA\Property(property="year", type="integer", example=2023),
 *             @OA\Property(property="price", type="number", example=300000)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car updated successfully"
 *     )
 * )
 */
// Update car by ID
Flight::route('PUT /cars/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->update($id, $data));
});


/**
 * @OA\Patch(
 *     path="/cars/{id}",
 *     tags={"cars"},
 *     summary="Partially update a car",
 *     description="Updates only the provided fields of the car.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Car ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="brand", type="string", example="Partial Brand Update"),
 *             @OA\Property(property="model", type="string", example="Partial Model Update"),
 *             @OA\Property(property="year", type="integer", example=2022),
 *             @OA\Property(property="price", type="number", example=275000)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car partially updated successfully"
 *     )
 * )
 */
// Partially update car by ID  
Flight::route('PATCH /cars/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/cars/{id}",
 *     tags={"cars"},
 *     summary="Delete a car",
 *     description="Deletes a car with the given ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Car ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Car deleted successfully"
 *     )
 * )
 */
// Delete car by ID
Flight::route('DELETE /cars/@id', function($id){
    Flight::json(Flight::carService()->delete($id));
});
?>