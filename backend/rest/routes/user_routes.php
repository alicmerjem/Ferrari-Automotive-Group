<?php
// Get user by ID
Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::userService()->getById($id));
});

// Get all users
Flight::route('GET /users', function(){
    Flight::json(Flight::userService()->getAll());
});

// Add new user
Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->create($data));
});

// Update user
Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

// Delete user
Flight::route('DELETE /users/@id', function($id){
    Flight::json(Flight::userService()->delete($id));
});
?>