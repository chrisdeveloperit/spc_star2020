<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AjaxController extends Controller {
   public function index() {
      $orgSel = 2;
      return response()->json(array('org_id'=> $orgSel, 'year_id'=> $yearSel), 200);
   }
}
