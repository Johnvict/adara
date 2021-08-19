<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
    return "adara";
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get("states", 'Controller@states');
    $router->get("local_govt", 'Controller@local_govt');

    $router->group(["prefix" => "admins"], function () use ($router) {
        $router->post('login', 'AuthController@loginAdmin');
        $router->post("update/password", 'AuthController@changePassword');
    });

    $router->group(["prefix" => "view", 'middleware' => 'auth:api'], function () use ($router) {
        $router->get("beneficiaries", 'BeneficiaryController@viewBeneficiaries');
        $router->get("beneficiary/{id}", 'BeneficiaryController@singleBeneficiary');
        $router->get("admins", 'AuthController@viewAdmins');
        $router->get("admin/{id}", 'AuthController@viewAdmin');
    });

    $router->group(["prefix" => "create", 'middleware' => "auth:api"], function () use ($router) {
        $router->post('admin', ["middleware" => "superadmin", "uses" => 'AuthController@createAdmin']);
        $router->post('beneficiary', ["middleware" => "superadmin", "uses" => 'BeneficiaryController@createBeneficiary']);
        $router->post('guarantor/{id}', ["middleware" => "superadmin", "uses" => 'GuarantorController@createGuarantor']);
    });
});
