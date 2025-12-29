<?php

Flight::group('/api', function() {

    /**
     * @OA\Get(
     * path="/cars/{id}",
     * tags={"cars"},
     * summary="Get a car by ID",
     * description="Returns a single car matching the given ID.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Car ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\Response(
     * response=200,
     * description="Car returned successfully"
     * )
     * )
     */
    Flight::route('GET /cars/@id', function($id){
        Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
        Flight::json(Flight::carService()->getById($id));
    });

    /**
     * @OA\Get(
     * path="/cars",
     * tags={"cars"},
     * summary="Get all cars",
     * description="Returns a list of all cars in the database.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="List of cars returned successfully"
     * )
     * )
     */
    Flight::route('GET /cars', function(){
        Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);    
        Flight::json(Flight::carService()->getAll());
    });

    /**
     * @OA\Post(
     * path="/cars",
     * tags={"cars"},
     * summary="Create a new car",
     * description="Adds a new car to the system.",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"model", "year", "price"},
     * @OA\Property(property="model", type="string", example="F8 Tributo"),
     * @OA\Property(property="year", type="integer", example=2021),
     * @OA\Property(property="price", type="number", example=250000)
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Car created successfully"
     * )
     * )
     */
    Flight::route('POST /cars', function(){
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);    
        $data = Flight::request()->data->getData();
        Flight::json(Flight::carService()->create($data));
    });

    /**
     * @OA\Put(
     * path="/cars/{id}",
     * tags={"cars"},
     * summary="Update a car",
     * description="Updates an existing car's information.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Car ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="model", type="string", example="Updated Model"),
     * @OA\Property(property="year", type="integer", example=2023),
     * @OA\Property(property="price", type="number", example=300000)
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Car updated successfully"
     * )
     * )
     */
    Flight::route('PUT /cars/@id', function($id){
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);    
        $data = Flight::request()->data->getData();
        Flight::json(Flight::carService()->update($id, $data));
    });


    /**
     * @OA\Patch(
     * path="/cars/{id}",
     * tags={"cars"},
     * summary="Partially update a car",
     * description="Updates only the provided fields of the car.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Car ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="model", type="string", example="Partial Model Update"),
     * @OA\Property(property="year", type="integer", example=2022),
     * @OA\Property(property="price", type="number", example=275000)
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Car partially updated successfully"
     * )
     * )
     */
    Flight::route('PATCH /cars/@id', function($id){
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);    
        $data = Flight::request()->data->getData();
        Flight::json(Flight::carService()->update($id, $data));
    });

    /**
     * @OA\Delete(
     * path="/cars/{id}",
     * tags={"cars"},
     * summary="Delete a car",
     * description="Deletes a car with the given ID.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Car ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\Response(
     * response=200,
     * description="Car deleted successfully"
     * )
     * )
     */
    Flight::route('DELETE /cars/@id', function($id){
        Flight::auth_middleware()->authorizeRole(Roles::ADMIN);    
        Flight::json(Flight::carService()->delete($id));
    });

});