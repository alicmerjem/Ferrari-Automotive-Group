<?php
// Get testdrive by ID
Flight::route('GET /testdrives/@id', function($id){
    Flight::json(Flight::testdriveService()->getById($id));
});

// Get all testdrives
Flight::route('GET /testdrives', function(){
    Flight::json(Flight::testdriveService()->getAll());
});

// Add new testdrive
Flight::route('POST /testdrives', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::testdriveService()->create($data));
});

// Update testdrive
Flight::route('PUT /testdrives/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::testdriveService()->update($id, $data));
});

// Delete testdrive
Flight::route('DELETE /testdrives/@id', function($id){
    Flight::json(Flight::testdriveService()->delete($id));
});
?>