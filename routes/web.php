<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Models\Previlegio;

Route::post('login','Auth\LoginController@login')->name('login');
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::resource('/','WelcomeController');
Route::resource('dashboard','DashBoardController');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('adm/servicio_metodo','ServicioMetodoController');
Route::resource('adm/nivel','NivelController');
Route::resource('adm/zona','ZonaController');
Route::resource('adm/previlegio','PrevilegioController');
Route::resource('adm/tipo_usuario','TipoUsuarioController');
Route::resource('adm/especialidad','EspecialidadController');
Route::resource('adm/red','RedController');
Route::resource('adm/servicio','TipoServicioController');
Route::resource('adm/medico','MedicoController');
Route::resource('adm/usuario','UsuarioController');
Route::resource('adm/centro','CentroMedicoController');
Route::get('adm/centro/{id_centro}/edit_especialidades',[
	'as' => 'edit-especialidades',
	'uses' => 'CentroMedicoController@edit_especialidades'
]);
Route::patch('adm/centro/update_especialidades/{id_centro}',[
	'as' => 'update-especialidades',
	'uses' => 'CentroMedicoController@update_especialidades'
]);
Route::get('adm/centro/{id_centro}/edit_medicos',[
	'as' => 'edit-medicos',
	'uses' => 'CentroMedicoController@edit_medicos'
]);
Route::patch('adm/centro/update_medicos/{id_centro}',[
	'as' => 'update-medicos',
	'uses' => 'CentroMedicoController@update_medicos'
]);
Route::get('adm/centro/{id_centro}/edit_areas',[
	'as' => 'edit-areas',
	'uses' => 'CentroMedicoController@edit_areas'
]);
Route::patch('adm/centro/update_areas/{id_centro}',[
	'as' => 'update-areas',
	'uses' => 'CentroMedicoController@update_areas'
]);

//Cartera de Servicio
Route::get('adm/centro/create_cartera_servicio/{id}',[
	'as' => 'create-cartera-servicio',
	'uses' => 'CarteraServicioController@create_cartera_servicio'
]);
Route::post('adm/centro/store_cartera_servicio/{id}',[
	'as' => 'store-cartera-servicio',
	'uses' => 'CarteraServicioController@store_cartera_servicio'
]);
Route::patch('adm/centro/update_cartera_servicio/{id_cartera_servicio}/{id_centro}',[
	'as' => 'update-cartera-servicio',
	'uses' => 'CarteraServicioController@update_cartera_servicio'
]);
Route::get('adm/centro/index_cartera_servicio/{id}',[
	'as' => 'index-cartera-servicio',
	'uses' => 'CarteraServicioController@index_cartera_servicio'
]);
Route::get('adm/centro/show_cartera_servicio/{id_cartera_servicio}/{id_centro}',[
	'as' => 'show-cartera-servicio',
	'uses' => 'CarteraServicioController@show_cartera_servicio'
]);
Route::get('adm/centro/edit_cartera_servicio/{id_cartera_servicio}/{id_centro}',[
	'as' => 'edit-cartera-servicio',
	'uses' => 'CarteraServicioController@edit_cartera_servicio'
]);
Route::get('adm/centro/renovate_cartera_servicio/{id_cartera_servicio}/{id_centro}',[
	'as' => 'renovate-cartera-servicio',
	'uses' => 'CarteraServicioController@renovate_cartera_servicio'
]);
Route::get('adm/centro/generar_excel_cartera_servicio/{id_cartera_servicio}/{id_centro}',[
	'as' => 'generar-excel-cartera-servicio',
	'uses' => 'CarteraServicioController@generar_excel_cartera_servicio'
]);
//Fin de Cartera de Servicio

//Rol de Turno
Route::get('adm/centro/create_rol_turno_emergencia/{id}',[
	'as' => 'create-rol-turno-emergencia',
	'uses' => 'RolTurnoController@create_rol_turno_emergencia'
]);
Route::get('adm/centro/create_rol_turno_consulta/{id_centro}/{id_rol_turno}',[
	'as' => 'create-rol-turno-consulta',
	'uses' => 'RolTurnoController@create_rol_turno_consulta'
]);
Route::get('adm/centro/create_rol_turno_hospitalizacion/{id_centro}/{id_rol_turno}',[
	'as' => 'create-rol-turno-hospitalizacion',
	'uses' => 'RolTurnoController@create_rol_turno_hospitalizacion'
]);
Route::get('adm/centro/create_rol_turno_personal_encargado/{id_centro}/{id_rol_turno}',[
	'as' => 'create-rol-turno-personal-encargado',
	'uses' => 'RolTurnoController@create_rol_turno_personal_encargado'
]);
Route::post('adm/centro/store_rol_turno_emergencia/{id_centro}',[
	'as' => 'store-rol-turno-emergencia',
	'uses' => 'RolTurnoController@store_rol_turno_emergencia'
]);
Route::post('adm/centro/store_rol_turno_consulta/{id_centro}/{id_rol_turno}',[
	'as' => 'store-rol-turno-consulta',
	'uses' => 'RolTurnoController@store_rol_turno_consulta'
]);
Route::post('adm/centro/store_rol_turno_hospitalizacion/{id_centro}/{id_rol_turno}',[
	'as' => 'store-rol-turno-hospitalizacion',
	'uses' => 'RolTurnoController@store_rol_turno_hospitalizacion'
]);
Route::post('adm/centro/store_rol_turno_personal_encargado/{id_centro}/{id_rol_turno}',[
	'as' => 'store-rol-turno-personal-encargado',
	'uses' => 'RolTurnoController@store_rol_turno_personal_encargado'
]);
Route::get('adm/centro/index_rol_turno/{id}',[
	'as' => 'index-rol-turno',
	'uses' => 'RolTurnoController@index_rol_turno'
]);
Route::get('adm/centro/show_rol_turno/{id}/{id_centro}',[
	'as' => 'show-rol-turno',
	'uses' => 'RolTurnoController@show_rol_turno'
]);
Route::get('adm/centro/show_rol_turno_emergencia/{id_rol_turno}/{id_centro}',[
	'as' => 'show-rol-turno-emergencia',
	'uses' => 'RolTurnoController@show_rol_turno_emergencia'
]);
Route::get('adm/centro/show_rol_turno_consulta/{id_rol_turno}/{id_centro}',[
	'as' => 'show-rol-turno-consulta',
	'uses' => 'RolTurnoController@show_rol_turno_consulta'
]);
Route::get('adm/centro/show_rol_turno_hospitalizacion/{id_rol_turno}/{id_centro}',[
	'as' => 'show-rol-turno-hospitalizacion',
	'uses' => 'RolTurnoController@show_rol_turno_hospitalizacion'
]);
Route::get('adm/centro/show_rol_turno_personal_encargado/{id_rol_turno}/{id_centro}',[
	'as' => 'show-rol-turno-personal-encargado',
	'uses' => 'RolTurnoController@show_rol_turno_personal_encargado'
]);
Route::get('adm/centro/edit_rol_turno/{id_rol_turno}/{id_centro}',[
	'as' => 'edit-rol-turno',
	'uses' => 'RolTurnoController@edit_rol_turno'
]);
Route::get('adm/centro/edit_rol_turno_emergencia/{id_rol_turno}/{id_centro}',[
	'as' => 'edit-rol-turno-emergencia',
	'uses' => 'RolTurnoController@edit_rol_turno_emergencia'
]);
Route::get('adm/centro/edit_rol_turno_consulta/{id_rol_turno}/{id_centro}',[
	'as' => 'edit-rol-turno-consulta',
	'uses' => 'RolTurnoController@edit_rol_turno_consulta'
]);
Route::get('adm/centro/edit_rol_turno_hospitalizacion/{id_rol_turno}/{id_centro}',[
	'as' => 'edit-rol-turno-hospitalizacion',
	'uses' => 'RolTurnoController@edit_rol_turno_hospitalizacion'
]);
Route::get('adm/centro/edit_rol_turno_personal_encargado/{id_rol_turno}/{id_centro}',[
	'as' => 'edit-rol-turno-personal-encargado',
	'uses' => 'RolTurnoController@edit_rol_turno_personal_encargado'
]);
Route::patch('adm/centro/update_rol_tuno/{id}',[
	'as' => 'update-rol-turno',
	'uses' => 'RolTurnoController@update_rol_tuno'
]);
Route::patch('adm/centro/update_rol_tuno_emergencia/{id_rol_turno}/{id_centro}',[
	'as' => 'update-rol-turno-emergencia',
	'uses' => 'RolTurnoController@update_rol_tuno_emergencia'
]);
Route::patch('adm/centro/update_rol_tuno_consulta/{id_rol_turno}/{id_centro}',[
	'as' => 'update-rol-turno-consulta',
	'uses' => 'RolTurnoController@update_rol_tuno_consulta'
]);
Route::patch('adm/centro/update_rol_tuno_hospitalizacion/{id_rol_turno}/{id_centro}',[
	'as' => 'update-rol-turno-hospitalizacion',
	'uses' => 'RolTurnoController@update_rol_tuno_hospitalizacion'
]);
Route::patch('adm/centro/update_rol_tuno_personal_encargado/{id_rol_turno}/{id_centro}',[
	'as' => 'update-rol-turno-personal-encargado',
	'uses' => 'RolTurnoController@update_rol_tuno_personal_encargado'
]);
Route::get('adm/centro/renovate_rol_turno/{id_rol_turno}/{id_centro}',[
	'as' => 'renovate-rol-turno',
	'uses' => 'RolTurnoController@renovate_rol_turno'
]);
Route::get('adm/centro/build_rol_turno/{id_rol_turno}/{id_centro}',[
	'as' => 'build-rol-turno',
	'uses' => 'RolTurnoController@build_rol_turno'
]);
Route::get('adm/centro/generar_excel_rol_turno/{id_rol_turno}/{id_centro}',[
	'as' => 'generar-excel-rol-turno',
	'uses' => 'RolTurnoController@generar_excel_rol_turno'
]);
//Fin ROL DE TURNO

//REPORTE CAMA
Route::get('adm/centro/index_reporte_cama/{id_centro}',[
	'as' => 'index-reporte-cama',
	'uses' => 'ReporteCamaController@index_reporte_cama'
]);
Route::get('adm/centro/create_reporte_cama/{id_centro}',[
	'as' => 'create-reporte-cama',
	'uses' => 'ReporteCamaController@create_reporte_cama'
]);
Route::post('adm/centro/store_reporte_cama/{id_centro}',[
	'as' => 'store-reporte-cama',
	'uses' => 'ReporteCamaController@store_reporte_cama'
]);
Route::get('adm/centro/edit_reporte_cama/{id_reporte_cama}/{id_centro}',[
	'as' => 'edit-reporte-cama',
	'uses' => 'ReporteCamaController@edit_reporte_cama'
]);
Route::patch('adm/centro/update_reporte_cama/{id_reporte_cama}/{id_centro}',[
	'as' => 'update-reporte-cama',
	'uses' => 'ReporteCamaController@update_reporte_cama'
]);
Route::get('adm/centro/show_reporte_cama/{id_reporte_cama}/{id_centro}',[
	'as' => 'show-reporte-cama',
	'uses' => 'ReporteCamaController@show_reporte_cama'
]);
Route::get('adm/centro/generar_excel_reporte_cama/{id_reporte_cama}/{id_centro}',[
	'as' => 'generar-excel-reporte-cama',
	'uses' => 'ReporteCamaController@generar_excel_reporte_cama'
]);
//FIN REPORTE CAMA

View::composer(['*'], function ($view) {
	$modulos = Previlegio::_getAllPrevilegioUsuario(1);
	// $opciones = Previlegio::_getAllPrevilegioUsuarioOpciones(1);
	// dd($modulos);
	// dd($modulos[0][0]->cant);
	//{{$modulos[0]->cant}} centro
	//{{$modulos[1]->cant}} segu
	//{{$modulos[2]->cant}} estr
	//{{$modulos[3]->cant}} serv
    $view->with('modulos', $modulos);
});