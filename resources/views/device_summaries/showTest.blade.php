@extends('layouts.app')

@section('content')

	<div class="container-fluid">
        
        <form action="{{isset($org_id) ? route('show_device_data', $org_id) : route('gauges.index')}}" method="post" name="showDeviceData" enctype="multipart/form-data"> <!--enctype needed for image upload-->
		@csrf
        
        	<div class="panel panel-default">
				<div class="panel-heading m-2">Select the Criteria</div>
            	<div class="panel-body">
					<div class="d-flex my-3">
            	
						<div class="form-group mx-2">
							<label for="orgSel">Organization</label>					

							<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="">

								@foreach($orgs as $org)						

									<!--Display all orgs from the resultset. If org.id = the id that was passed in the compact args, make that org the selected one in the dropdown.-->
									<option value="{{$org->id}}"
										@if(isset($org->id))
											@if($org->id == 37)
												selected
											@endif
										@endif

									>{{$org->org_name}}</option>
								@endforeach

							</select>
						</div><!--end form-group-->
    	
						<div class="form-group mx-2">
							<label for="buildingsSel">Building</label>					

							<select name="buildingsSel" id="buildingsSel" class="form-control mb-2" onchange="this.form.submit()"> <!--page_direct('floorplans', this.value)-->
								<option>Select a building</option>
								<!--Display all buildings from the resultset.-->						
								@foreach($bldgs as $row)
									
									<option value="{{$row->id}}"
										@if(isset($bldg_id))
											@if($row->id == $bldg_id)
												selected
											@endif
										@endif
									>{{$row->bldg_name}}</option>
								@endforeach
								
							</select>
						</div><!--end form-group-->	
            
            
						<div class="form-group mx-2">
							<label for="yearSel">Select a Year</label>					

							<select name="yearSel" id="yearSel" class="form-control mb-2" onchange="">
								<option value="">Select a Year</option>
								<!--Display all schoolYears from the resultset.-->						
								@foreach($years as $row)
								<option value="{{$row->id}}"
										
									>{{$row->school_year}}</option>
								@endforeach
															
							</select>
						</div><!--end form-group-->			
					</div><!--d-flex my-3-->
    
					
					<div class="d-flex my-3">			
						<div class="form-group mx-2">
							<label for="rptSel">Reporting</label>					

							<select name="rptSel" id="orgSel" class="form-control mb-2" onchange="">											
								
									<option>Select an option</option>
									<option value="no">Not Reporting</option>
									<option value="yes">Reporting</option>									
							</select>
						</div><!--end form-group-->
    	
						<div class="form-group mx-2">
							<label for="tonerSel">Toner Low</label>					

							<select name="tonerSel" id="tonerSel" class="form-control mb-2" onchange="">
								<option>Select an option</option>
								<option value="no">No</option>
								<option value="yes">Yes</option>
								
							</select>
						</div><!--end form-group-->	
            
            
						<div class="form-group mx-2">
							<label for="serviceSel">Service Needed</label>					

							<select name="serviceSel" id="serviceSel" class="form-control mb-2" onchange="">
								<option>Select an option</option>
								<option value="no">No</option>
								<option value="yes">Yes</option>
															
							</select>
						</div><!--end form-group-->
            
						<div class="form-group mx-2">
							<label for="contractSel">Under Contract</label>					

							<select name="contractSel" id="contractSel" class="form-control mb-2" onchange="">
								<option>Select an option</option>
								<option value="no">Non-Contracted Device</option>
								<option value="yes">Device Under Contract</option>
															
							</select>
						</div><!--end form-group-->
						
					</div><!--end d-flex-->
				</div><!--end panel-body-->			
			</div><!--end panel-->
    </form>
	
        
        
    <main id="js-page-content" class="my-3 mx-3">
    <form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
		@csrf
	<div class="row">
		<div class="col-xl-12">
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<h2>
						@if(isset($id))
							Device Data <span class="fw-300"><i>For specific devices</i></span>
						@else
							Device Data <span class="fw-300"><i>For all devices</i></span>
						@endif
					</h2>
					<div class="panel-toolbar">
						<button class="btn btn-primary btn-sm" data-toggle="dropdown">Table Style</button>
						<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right position-absolute pos-top">
							<button class="dropdown-item active" data-action="toggle" data-class="table-bordered" data-target="#dt-basic-example"> Bordered Table </button>
							<button class="dropdown-item" data-action="toggle" data-class="table-sm" data-target="#dt-basic-example"> Smaller Table </button>
							<button class="dropdown-item" data-action="toggle" data-class="table-dark" data-target="#dt-basic-example"> Table Dark </button>
							<button class="dropdown-item active" data-action="toggle" data-class="table-hover" data-target="#dt-basic-example"> Table Hover </button>
							<button class="dropdown-item active" data-action="toggle" data-class="table-stripe" data-target="#dt-basic-example"> Table Stripped </button>
							<div class="dropdown-divider m-0"></div>
							
						</div><!--end dropdown-menu-->
					</div><!--end panel-toolbar-->
				</div><!--end panel-hdr-->
				
				<div class="panel-container show">
					<div class="panel-content table-responsive">
						<div class="panel-tag">
							This table shows all devices <strong>that match the selected criteria.</strong> 
						</div>
        
        
						<!-- datatable start -->
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead">						
								<tr>
									<th colspan="19" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="js-get-date h5 mb-2">[your date here]</div>
									</th>
								</tr>
							
								<tr>
									<th>Org Name</th>
									<th>Machine ID</th>
									<th>Building Name</th>
									<th>Room Number</th>
									<th>Make</th>
									<th>Model</th>
									<th>Serial Number</th>
									<th>IP Address</th>
									<th>Mac Address</th>
                                	<th>Last Reporting Date</th>
									<th>Budgeted Black</th>
									<th>Budgeted Color</th>
									<th>Reporting</th>
									<th>Current Black Meter</th>
									<th>Current Color Meter</th>
									<th>Toner Low</th>
									<th>Service Needed</th>
									<th>Under Contract</th>
									<th>Note</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($device_data))	
                            	@foreach($device_data as $row)
									<tr>
									<td>org_name</td>
									<td>machine_id</td>
									<td>bldg_name</td>
									<td>Room Number</td>
									<td>Make</td>
									<td>Model</td>
									<td>{{$row->serial_number}}</td>
									<td>IP Address</td>
									<td>Mac Address</td>
                                	<td>Last Reporting Date</td>
									<td>Budgeted Black</td>
									<td>Budgeted Color</td>
									<td>Reporting</td>
									<td>Current Black Meter</td>
									<td>Current Color Meter</td>
									<td>Toner Low</td>
									<td>Service Needed</td>
									<td>Under Contract</td>
									<td>Note</td>
									</tr>
                            		@endforeach
                            	@endif
																
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
				</div><!-- end panel-container -->
			</div><!-- end panel-l -->
		</div><!-- end col-xl-12 -->
      </div><!-- end row -->
    </form>
	  </main>
            
    
	</div><!--container-fluid-->	
		
		
		

	
@endsection