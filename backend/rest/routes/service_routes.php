<?php
// Get service by ID
Flight::route('GET /services/@id', function($id){
    Flight::json(Flight::serviceService()->get_service_by_id($id));
});

// Get all services
Flight::route('GET /services', function(){
    Flight::json(Flight::serviceService()->get_services());
});

// Add new service
Flight::route('POST /services', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->add_service($data));
});

// Update service
Flight::route('PUT /services/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::serviceService()->update_service($id, $data));
});

// Delete service
Flight::route('DELETE /services/@id', function($id){
    Flight::json(Flight::serviceService()->delete_service($id));
});
?>