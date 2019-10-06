<?php
use Illuminate\Support\Str;
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

//  การจัดการ routing ดูได้จาก doc https://lumen.laravel.com/docs/6.x/routing

$router->get( '/', function () use ( $router )
{
    return $router->app->version();
} );
$router->get( '/key', function () use ( $router )
{
    return Str::random( 32 );
} );

$router->group( ['prefix' => 'api/'], function ( $router )
{
    $router->get( 'login/', 'UsersController@authenticate' );
    $router->post( 'todo/', 'TodoController@store' );
    $router->get( 'todo/', 'TodoController@index' );
    $router->get( 'todo/{id}/', 'TodoController@show' );
    $router->put( 'todo/{id}/', 'TodoController@update' );
    $router->delete( 'todo/{id}/', 'TodoController@destroy' );
} );
