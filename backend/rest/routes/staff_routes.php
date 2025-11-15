<?php
// Get staff by ID
Flight::route('GET /staff/@id', function($id){
    Flight::json(Flight::staffService()->getById($id));
});

// Get all staff
Flight::route('GET /staff', function(){
    Flight::json(Flight::staffService()->getAll());
});

// Add new staff
Flight::route('POST /staff', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::staffService()->create($data));
});

// Update staff
Flight::route('PUT /staff/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::staffService()->update($id, $data));
});

// Delete staff
Flight::route('DELETE /staff/@id', function($id){
    Flight::json(Flight::staffService()->delete($id));
});
?>