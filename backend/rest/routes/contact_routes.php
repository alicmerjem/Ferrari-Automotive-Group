<?php
// Get contact by ID
Flight::route('GET /contacts/@id', function($id){
    Flight::json(Flight::contactService()->getById($id));
});

// Get all contacts
Flight::route('GET /contacts', function(){
    Flight::json(Flight::contactService()->getAll());
});

// Add new contact
Flight::route('POST /contacts', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactService()->create($data));
});

// Update contact
Flight::route('PUT /contacts/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactService()->update($id, $data));
});

// Delete contact
Flight::route('DELETE /contacts/@id', function($id){
    Flight::json(Flight::contactService()->delete($id));
});
?>