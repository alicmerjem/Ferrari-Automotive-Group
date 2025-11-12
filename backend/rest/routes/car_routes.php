<?php
// Get a specific car by ID
Flight::route('GET /cars/@id', function($id){
    Flight::json(Flight::carService()->get_car_by_id($id));
});

// Get cars with optional filter
Flight::route('GET /cars', function(){
    $filter = Flight::request()->query['filter'] ?? null;
    Flight::json(Flight::carService()->get_cars($filter));
});

// Add a new car
Flight::route('POST /cars', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->add_car($data));
});

// Update car by ID
Flight::route('PUT /cars/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->update_car($id, $data));
});

// Partially update car by ID  
Flight::route('PATCH /cars/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::carService()->partial_update_car($id, $data));
});

// Delete car by ID
Flight::route('DELETE /cars/@id', function($id){
    Flight::json(Flight::carService()->delete_car($id));
});
?>