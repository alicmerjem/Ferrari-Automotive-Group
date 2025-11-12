<?php
// Get user by ID
Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::userService()->get_user_by_id($id));
});

// Get all users
Flight::route('GET /users', function(){
    Flight::json(Flight::userService()->get_users());
});

// Add new user
Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->add_user($data));
});

// Update user
Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update_user($id, $data));
});

// Delete user
Flight::route('DELETE /users/@id', function($id){
    Flight::json(Flight::userService()->delete_user($id));
});
?>