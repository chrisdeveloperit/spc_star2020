<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Building;
use App\Models\Floorplan;
use App\Models\FloorplanMachine;
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

   $arry_floors = [];
   $floor_num = NULL;

   $total_floors = DB::table('floorplans')
   ->select('floor_number')
   ->where('buildings_id', '=', $request->buildingsSel)
   ->orderby('floor_number')
   ->get();

   if($request->buildingsSel !== NULL && $total_floors !== NULL) {
      $arry_floors = json_decode($total_floors, true);
      $floor_num = $request->radioFloors ?? $arry_floors[0];
   }

   $floorplans = DB::table('floorplans AS fp')
   ->join('buildings AS bldg', 'bldg.bldg_id', '=', 'fp.buildings_id')
   ->select('fp.fp_id', 'fp.floorplan_image', 'fp.floor_number', 'bldg.bldg_name')
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
         ->join('machine_specs AS ms','ms.spec_id', '=', 'fm.present_spec_id')
         ->leftjoin('machine_types AS mt','fm.present_type_id', '=', 'mt.mach_type_id')
         ->select('fm.fpm_id', 'fm.present_spec_id', 'fm.present_floorplans_id', 'fm.room_name', 'fm.present_serial_number', 'fm.present_type_id', 'fm.is_proposed', 'fm.under_contract', 'fm.present_x_position', 'fm.present_y_position', 'fm.mac_address', 'fm.ip_address', 'fm.present_serial_number', 'fm.present_vendor_mach_id', 'ms.mach_make', 'ms.model', 'ms.spec_id','ms.machine_types_id', 'ms.machine_image', 'ms.is_color', 'mt.type_name', 'mt.icon_type')
         ->where('fm.present_floorplans_id', '=', $floorplans->fp_id)
         ->where('fm.under_contract', '=', 'Y')
         ->get();
   }

   return view('fpfloorpadm.index', ['sbldg_id' => $request->buildingsSel, 'sorg_id' => $request->sorg_id, 'sfloornum' => $floor_num])
         ->with('buildings', $buildings)
         ->with('floorplans', $floorplans)
         ->with('org_data', $org_data)
         ->with('machines', $floorplan_machines)
         ->with('total_floors', $total_floors);
   }


public function edit($id)
   {
   //
   }

public function update(Request $request, $id)
   {
   //
   }

public function destroy($id)
   {
   //
   }

public function update_xy(Request $request, $fpm_id) 
{  
   $machine = FloorplanMachine::find($fpm_id);    

   if( $machine ) {
      try {
         $machine->present_x_position = $request->input('present_x_position');
         $machine->present_y_position = $request->input('present_y_position');
         $machine->room_name = $request->input('roomName');
         #$machine->modified_date = Carbon::now();
         $machine->modified_by = 1272;
         $machine->update();

         return 'Machine location was updated';
      }
      catch (Throwable $e) {
         \Log::info('update_xy ERROR: '. $e.getMessage());
        return false; 
      }
   }
}
}
