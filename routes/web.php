<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteController;
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

Route::get('/', [AsistenciaController::class, 'index'])->name('inicio');
Route::get('asistencia', [AsistenciaController::class, 'create'])->name('registrar');
Route::get('departamento-{id}/empleados', [AsistenciaController::class, 'depto_empleados']);
Route::get('departamentos', [AsistenciaController::class, 'deptos']);
Route::get('busca-empleado/{id}', [AsistenciaController::class, 'busca_empleado'])->name('busca_empleado');
Route::get('consultar-asistencia', [AsistenciaController::class, 'show'])->name('consultar_asistencia');
Route::post('ejecutar-consulta', [AsistenciaController::class, 'ejecutarConsulta'])->name('ejecutar_consulta');
Route::post('asistencia/guardar', [AsistenciaController::class, 'store'])->name('guardar_asistencia');
Route::post('asistencia/editar/', [AsistenciaController::class, 'guardarEditarAsistencia'])->name('editar_asistencia');
Route::post('asistencia/actualizar/', [AsistenciaController::class, 'update'])->name('actualizar_asistencia');
Route::post('asistencia-manual/guardar/', [AsistenciaController::class, 'guardarRegistroManual'])->name('guardar_registro_manual');
Route::get('pdf-reporte', [ReporteController::class, 'impReporte'])->name('impReporte');
Route::get('/asistencia-manual', function () {
    return view('asistencia.registro-manual');
})->name('registro_manual');