<?php
// Get testdrive by ID
Flight::route('GET /testdrives/@id', function($id){
    Flight::json(Flight::testdriveService()->get_testdrive_by_id($id));
});

// Get all testdrives
Flight::route('GET /testdrives', function(){
    Flight::json(Flight::testdriveService()->get_testdrives());
});

// Add new testdrive
Flight::route('POST /testdrives', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::testdriveService()->add_testdrive($data));
});

// Update testdrive
Flight::route('PUT /testdrives/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::testdriveService()->update_testdrive($id, $data));
});

// Delete testdrive
Flight::route('DELETE /testdrives/@id', function($id){
    Flight::json(Flight::testdriveService()->delete_testdrive($id));
});
?>