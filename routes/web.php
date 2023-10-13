<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ControlProduccionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ReworkController;
use App\Http\Controllers\ReporteGraficoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportePdfController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//rutas de login y dashboard
Route::controller(LoginController::class)->group(function (){
    Route::get('/','acceso');    
});

Route::controller(HomeController::class)->group(function (){
    Route::get('/dashboard','index')->middleware('can:Ver Dashboard','auth')->name('dashboard');
});

//rutas usuarios
Route::get('/users', [UserController::class, 'index'])->middleware('can:Listar Usuarios')->name('users.index');
Route::get('/users/list', [UserController::class, 'listusers']);
Route::post('/user', [UserController::class, 'store'])->name('users.store');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->middleware('can:Actualizar Usuarios')->name('users.edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/user/password/{user}', [UserController::class, 'show_password'])->middleware('can:Cambiar Password');
Route::put('/user/password/{user}', [UserController::class, 'update_password']);

//Roles
Route::get('role', [RoleController::class, 'index'])->middleware('can:Listar Roles')->name('roles.index');
Route::get('role/create', [RoleController::class, 'create'])->middleware('can:Crear Roles')->name('roles.create');
Route::post('role', [RoleController::class, 'store'])->name('roles.store');
Route::get('role/{role}', [RoleController::class, 'edit'])->middleware('can:Actualizar Roles')->name('roles.edit');
Route::put('role/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('role/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

//Rutas de fases
Route::get('/stage', [StageController::class, 'index'])->middleware('can:Listar Etapas')->name('stages.index');
Route::get('/stage/list', [StageController::class, 'liststages']);
Route::post('/stage', [StageController::class, 'store'])->name('stages.store');
Route::get('/stage/{stage}', [StageController::class, 'edit'])->name('stages.edit');
Route::put('/stage/{stage}', [StageController::class, 'update'])->name('stages.update');
Route::delete('/stage/{stage}', [StageController::class, 'destroy'])->name('stages.destroy');

//Rutas de actividades
Route::get('/activity', [ActivityController::class, 'index'])->middleware('can:Listar Actividades')->name('activities.index');
Route::get('/activity/list', [ActivityController::class, 'listactivities']);
Route::post('/activity', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activity/{activity}', [ActivityController::class, 'edit'])->name('activities.edit');
Route::put('/activity/{activity}', [ActivityController::class, 'update'])->name('activities.update');
Route::delete('/activity/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

//Rutas de operarios
Route::get('/operator', [OperatorController::class, 'index'])->middleware('can:Listar Operarios')->name('operators.index');
Route::get('/operator/list', [OperatorController::class, 'listarOperators']);
Route::post('/operator', [OperatorController::class, 'store'])->name('operators.store');
Route::get('/operator/{operator}', [OperatorController::class, 'edit'])->middleware('can:Actualizar Operarios')->name('operators.edit');
Route::put('/operator/{operator}', [OperatorController::class, 'update'])->name('operators.update');
Route::delete('/operator/{operator}', [OperatorController::class, 'destroy'])->name('operators.destroy');

//rutas orden de fabricacion
Route::get('/orden', [OrderController::class, 'index'])->middleware('can:Listar Ordenes')->name('orders.index');
Route::get('/orden/list', [OrderController::class, 'listorders']);
Route::get('/orden/create', [OrderController::class, 'create'])->middleware('can:Crear Ordenes')->name('orders.create');
Route::post('/orden/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orden/show/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orden/{order}', [OrderController::class, 'edit'])->middleware('can:Actualizar Ordenes')->name('orders.edit');
Route::put('/orden/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orden/delete/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

//rutas proyectos
Route::post('/project', [ProjectController::class, 'showProject'])->name('projects.show');
Route::get('/project', [ProjectController::class, 'index'])->middleware('can:Listar Proyectos')->name('projects.index');
Route::get('/project/list', [ProjectController::class, 'listprojects']);
Route::get('/project/show/{id}', [ProjectController::class, 'showProjectPlannig']);
Route::get('/project/{id}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/project/update/{project}', [ProjectController::class, 'update'])->name('projects.update');

//rutas planificacion
Route::post('/planning', [PlanningController::class, 'showOneActivity']);
Route::post('/planning/store', [PlanningController::class, 'store'])->name('plannings.store');

//rutas control de la produccion
Route::get('/control', [ControlProduccionController::class, 'index'])->middleware('can:Listar Producción de Radiadores')->name('control.index');
Route::get('/control/listcontrol', [ControlProduccionController::class, 'listControlProduccion']);
Route::get('/control/{id}', [ControlProduccionController::class, 'controlProduccion'])->middleware('can:Realizar Control de Radiadores');
Route::put('/control/{id}', [ControlProduccionController::class, 'update'])->name('control.update');
Route::post('/upload', [ControlProduccionController::class, 'upload']);

//rutas comentarios
Route::get('/comment/{id}', [CommentController::class, 'index'])->name('comments.index');
Route::post('/comment', [CommentController::class, 'store'])->name('comments.store');
Route::get('/download/{file}', [CommentController::class, 'download']);
Route::get('/comment/edit/{id}', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comment/update/{comment}', [CommentController::class, 'update'])->name('comments.update');

//rutas de reprocesos
Route::get('/reproceso/{id}', [ReworkController::class, 'index'])->middleware('can:Ver Gráfico de Reprocesos de Radiadores');
Route::get('/reproceso/show/{id}', [ReworkController::class, 'showRework'])->middleware('can:Ver Detalle de Reprocesos de Radiadores');
Route::get('/rework/{id}', [ReworkController::class, 'listRework']);

//Rutas de reportes graficos
Route::get('/grafico/ordertime', [ReporteGraficoController::class, 'orderLate'])->name('graficos.orders_late');
Route::post('/grafico/retraso', [ReporteGraficoController::class, 'grafico_orden_retraso']);
Route::get('/grafico/orderlate', [ReporteGraficoController::class, 'orderTime'])->name('graficos.orders_time');
Route::post('/grafico/atiempo', [ReporteGraficoController::class, 'grafico_orden_tiempo']);

//Rutas de reportes pdf
Route::get('/reporte/order', [ReportePdfController::class, 'orderIndex'])->middleware('can:Ver reporte pdf de ordenes entregadas a tiempo')->name('pdf.orderIndex');
Route::post('/reporte/orderPDF', [ReportePdfController::class, 'reportOrderTime'])->name('pdf.report-order-time');
Route::get('/reporte/activity', [ReportePdfController::class, 'activityIndex'])->middleware('can:Ver reporte pdf de actividades con reproceso')->name('pdf.activityIndex');
Route::post('/reporte/activityPDF', [ReportePdfController::class, 'reportActivityRework'])->name('pdf.report-activity-rework');
Route::get('/reporte/operator', [ReportePdfController::class, 'operatorIndex'])->middleware('can:Ver reporte pdf de operario con reproceso')->name('pdf.operatorIndex');
Route::post('/reporte/operatorPDF', [ReportePdfController::class, 'reportOperatorRework'])->name('pdf.report-operator-rework');