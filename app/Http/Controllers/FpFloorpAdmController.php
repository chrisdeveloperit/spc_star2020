<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Floorplan;
use App\Models\FloorplanMachines;
use App\Models\SchoolYear;
use DB;
use Carbon\Carbon;
class FpFloorpAdmController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
   $org_data = DB::table('organizations')
   ->select('org_id', 'org_name')
   ->where('organization_types_id', '<>', 7)
   ->where('client_status', '=', 'A')
   ->orderby('org_name')
   ->get();

   return view('fpfloorpadm.index', compact("org_data"));
}
public function create()
{
//
}
public function store(Request $request)
{
//
}
/**
* Display the specified data for the selected org with color defaulting to both
* and year, and timeline date defaulting to current year values.
* @param int $id
* @return \Illuminate\Http\Response
*/
public function show(Request $request)
    {
      # \Log::info(json_encode($request->all()));

      $org_data = DB::table('organizations')
      ->select('org_id', 'org_name')
      ->where('organization_types_id', '<>', 7)
      ->where('client_status', '=', 'A')
      ->orderby('org_name')
      ->get();

      $total_floors = DB::table('floorplans')
      ->select('floor_number')
      ->where('buildings_id', '=', $request->buildingsSel)
      ->get();

      $floor_num = $request->radioFloors ?? '1';

      $floorplans = DB::table('floorplans AS fp')
      ->join('buildings AS bldg', 'bldg.bldg_id', '=', 'fp.buildings_id')
      ->select('fp.id', 'fp.floorplan_image', 'fp.floor_number', 'bldg.bldg_name')
      ->where(array('fp.buildings_id' => $request->buildingsSel,
            'fp.floor_number' => $floor_num))
      ->orderBy('fp.floor_number')
      ->first();

      $buildings = Building::orderBy('bldg_name')
         ->where('buildings.organizations_id', '=', $request->sorg_id)
         ->get();

      $floorplan_machines = null;

      if($floorplans <> null) {
         $floorplan_machines = DB::table('floorplan_machines AS fm')
            ->join('machine_specs AS ms','ms.spec_id', '=', 'fm.model_id')
            ->leftjoin('machine_types AS mt','fm.type_id', '=', 'mt.id')
            ->select('fm.fpm_id', 'fm.model_id', 'fm.present_model_id', 'fm.x_position', 'fm.y_position', 'fm.floorplan_id', 'fm.room_number', 'fm.serial_number', 'fm.budgeted_blk', 'fm.cpc_black', 'fm.budgeted_color', 'fm.cpc_color', 'fm.5_year_id', 'fm.type_id', 'fm.present_type_id', 'fm.is_proposed', 'fm.under_contract', 'fm.local_connection', 'fm.commencement_date', 'fm.commencement_black_meter', 'fm.commencement_color_meter', 'fm.present_floorplan_id', 'fm.present_room_number', 'fm.present_x_position', 'fm.present_y_position', 'fm.present_local_connection', 'fm.mac_address', 'fm.IP_Address', 'fm.present_serial_number', 'fm.vendor_device_id', 'fm.savedname', 'fm.save_name_id', 'fm.date_created', 'fm.fp_mod_dts', 'fm.out_of_service', 'ms.make', 'ms.model', 'ms.model_id', 'ms.machine_types_id', 'ms.machine_image', 'ms.is_color', 'mt.type_name', 'mt.icon_type')
            ->where('fm.floorplan_id', '=', $floorplans->id)
            ->where('fm.under_contract', '=', 'Y')
            ->get();
            \Log::info(json_encode($floorplan_machines));
      }

      return view('fpfloorpadm.index', ['sbldg_id' => $request->buildingsSel, 'sorg_id' => $request->sorg_id, 'sfloornum' => $floor_num])
            ->with('buildings', $buildings)
            ->with('floorplans', $floorplans)
            ->with('org_data', $org_data)
            ->with('machines', $floorplan_machines)
            ->with('total_floors', $total_floors);
    }
/**
* Show the form for editing the specified resource.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
//
}
/**
* Update the specified resource in storage.
*
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
//
}
/**
* Remove the specified resource from storage.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
//
}

}
