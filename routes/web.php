<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\MetersController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

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

Route::get('/', function () {
    return view('home');
});

/*To automatically register all the routes.*/
//Auth::routes();

/*To automatically register all the routes EXCEPT register. Disabling this route removes the
Register button so undesired users cannot create a user and visit the site.*/
Auth::routes(['register' => false]);

Route::resource('meters', 'MetersController')->middleware('auth');
//Route::resource('meters', 'App\Http\Controllers\MetersController')->middleware('auth');
//Route::get('meters', [MetersController::class, 'index']);
//Route::get('meters', 'App\Http\Controllers\MetersController@index'); //This one works
//Route::resource('meters', MetersController::class);

Route::resource('buildings', 'BuildingsController')->middleware('auth');
Route::resource('organizations', 'OrganizationsController')->middleware('auth');
Route::resource('org_types', 'OrganizationTypesController')->middleware('auth');
Route::resource('floorplans', 'FloorplansController')->middleware('auth');
Route::resource('floorplan_diagrams', 'FloorplanDiagramsController')->middleware('auth');
Route::resource('floorplan_machines', 'FloorplanMachinesController')->middleware('auth');
Route::resource('gauges', 'GaugesController')->middleware('auth');
Route::resource('buildings_cost', 'BuildingsCostController')->middleware('auth');
Route::resource('buildings_volume', 'BuildingsVolumeController')->middleware('auth');

Route::resource('departments', 'DepartmentsController')->middleware('auth');
Route::resource('departments_gauges', 'DepartmentsGaugesController')->middleware('auth');
Route::resource('departments_cost', 'DepartmentsCostController')->middleware('auth');
Route::resource('departments_volume', 'DepartmentsVolumeController')->middleware('auth');
//Route::resource('contacts', 'ContactsController')->middleware('auth');
Route::resource('org_contacts', 'OrgContactsController')->middleware('auth');
Route::resource('machine_types', 'MachineTypesController')->middleware('auth');
Route::resource('machine_specs', 'MachineSpecsController')->middleware('auth');

Route::resource('machine_statuses', 'MachineStatusesController')->middleware('auth');
Route::resource('current_devices', 'CurrentDevicesController')->middleware('auth');
Route::resource('device_summaries', 'Device_SummariesController')->middleware('auth');
Route::resource('spc_users', 'SPCUsersController')->middleware('auth');


/*This custom route will go back to the create page after the org has been selected. The difference is that
	now the buildings in the dropdown list will ONLY be buildings belonging to the selected org.*/
//Route::get('org_contacts/create_w_bldg/{selected_org}', 'OrgContactsController@create_w_bldg')->name('create_w_bldg')->middleware('auth');
Route::get('getBuildings/{org_id}', 'OrgContactsController@getBuildings');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('reset', 'HomeController@resetPW')->name('resetPW');
Route::get('showAllMeters/{year}', 'MetersController@showAllMeters')->name('showAllMeters');
Route::get('meters/{meter}/edit', 'MetersController@edit')->name('meters.edit');
Route::get('organizations/{organization}', 'OrganizationsController@show')->name('organizations.show')->middleware('auth');
Route::get('gauges.show_by_org_year/{org_id}/year/{year}', 'GaugesController@show_by_org_year')->name('gauges.show_by_org_year')->middleware('auth');
Route::get('gauges.show_by_org/{org_id}', 'GaugesController@show_by_org')->name('gauges.show_by_org')->middleware('auth');
Route::get('gauges.show_by_year/{year}', 'GaugesController@show_by_year')->name('gauges.show_by_year')->middleware('auth');
Route::get('gauges.show_by_color/{color}', 'GaugesController@show_by_color')->name('gauges.show_by_color')->middleware('auth');
Route::get('gauges', 'GaugesController@index')->name('gauges.index')->middleware('auth');
Route::get('gauges/{org_id}', 'GaugesController@show')->name('gauges.show')->middleware('auth');

//Route::get('device_summaries/{org_id}', 'Device_SummariesController@show')->name('device_summaries.show')->middleware('auth');
Route::get('show_toner_data/{device_data}', 'Device_SummariesController@show_toner_data')->name('show_toner_data')->middleware('auth');

//Route::get('show_device_data_vals/{ses_var_name}/{device_data}', 'Device_SummariesController@show_device_data')->name('show_device_data')->middleware('auth');
Route::get('show_toner_data/{summary}', 'Device_SummariesController@show_toner_data')->name('show_toner_data')->middleware('auth');
Route::get('show_service_data/{summary}', 'Device_SummariesController@show_service_data')->name('show_service_data')->middleware('auth');
Route::get('show_contract_devices/{summary}', 'Device_SummariesController@show_contract_devices')->name('show_contract_devices')->middleware('auth');
Route::get('show_non_contract_devices/{summary}', 'Device_SummariesController@show_non_contract_devices')->name('show_non_contract_devices')->middleware('auth');
Route::get('show_reporting_devices/{summary}', 'Device_SummariesController@show_reporting_devices')->name('show_reporting_devices')->middleware('auth');
Route::get('show_not_reporting_devices/{summary}', 'Device_SummariesController@show_not_reporting_devices')->name('show_not_reporting_devices')->middleware('auth');
//Route::post('show_device_data/{org_id}', 'Device_SummariesController@show_device_data')->name('show_device_data')->middleware('auth');
//Route::get('setSelectedSessionVariable({goToUrl}, {varName}, {thisVar})', 'Device_SummariesController@show_device_data')->name('show_device_data')->middleware('auth');

Route::get('/testPage', 'Device_SummariesController@index')->name('testPage')->middleware('auth');

//Route::get('ajax',function() { return view('GaugesController@show_by_org_year');});
//Route::post('/get_org_data','AjaxController@index');
