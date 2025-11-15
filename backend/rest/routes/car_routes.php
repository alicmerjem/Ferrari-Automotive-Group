<?php
// Get a specific car by ID
Flight::route('GET /cars/@id', function($id){
    Flight::json(Flight::carService()->getById($id));
});

// Get cars with optional filter
Flight::route('GET /cars', function(){
    Flight::json(Flight::carService()->getAll());
});

// Add a new car
Flight::route('POST /cars', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->create($data));
});

// Update car by ID
Flight::route('PUT /cars/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->update($id, $data));
});

// Partially update car by ID  
Flight::route('PATCH /cars/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->update($id, $data));
});

// Delete car by ID
Flight::route('DELETE /cars/@id', function($id){
    Flight::json(Flight::carService()->delete($id));
});
?>