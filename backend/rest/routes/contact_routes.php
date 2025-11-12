<?php
// Get contact by ID
Flight::route('GET /contacts/@id', function($id){
    Flight::json(Flight::contactService()->get_contact_by_id($id));
});

// Get all contacts
Flight::route('GET /contacts', function(){
    Flight::json(Flight::contactService()->get_contacts());
});

// Add new contact
Flight::route('POST /contacts', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactService()->add_contact($data));
});

// Update contact
Flight::route('PUT /contacts/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::contactService()->update_contact($id, $data));
});

// Delete contact
Flight::route('DELETE /contacts/@id', function($id){
    Flight::json(Flight::contactService()->delete_contact($id));
});
?>