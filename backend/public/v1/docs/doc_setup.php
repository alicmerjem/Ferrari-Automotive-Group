<?php
/**
 * @OA\OpenApi(openapi="3.0.0")
 */
/**
* @OA\Info(
*     title="Ferrari Automotive Group API",
*     description="API for managing Ferrari cars, users, staff, contacts, services, and test drives",
*     version="1.0.0",
*     @OA\Contact(
*         email="your-email@example.com",
*         name="Your Name"
*     )
* )
*/
/**
* @OA\Server(
*     url= "https://hammerhead-app-jwr47.ondigitalocean.app",
*     description="API server"
* )
*/
/**
* @OA\SecurityScheme(
*     securityScheme="bearerAuth",
*     type="http",
*     scheme="bearer",
*     bearerFormat="JWT",
*     description="Enter JWT Bearer token"
* )
*/
?>