@extends('layouts.app')

@section('content')

	<div class="container-fluid">
        
        <form action="" method="post" enctype="multipart/form-data"> <!--enctype needed for image upload-->
		@csrf
        
        	<div class="panel panel-default">
				<div class="panel-heading m-2">Select the Criteria</div>
            	<div class="panel-body">
					<div class="d-flex my-3">
            	
						<div class="form-group mx-2">
							<label for="orgSel">Organization</label>					

							<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('show_device_data', this.value)"> <!--form.submit(this.value)-->

								@foreach($orgs as $org)						

									<!--Display all orgs from the resultset. If org.id = the id that was passed in the compact args, make that org the selected one in the dropdown.-->
									<option value="{{$org->id}}"
										@if(isset($org->id))
											@if($org->id == session('org_id'))
												selected
											@endif
										@endif

									>{{$org->org_name}}</option>
								@endforeach

							</select>
						</div><!--end form-group-->
    	
						<div class="form-group mx-2">
							<label for="buildingsSel">Building</label>					

							<select name="buildingsSel" id="buildingsSel" class="form-control mb-2" onchange="page_direct('show_device_data', this.value)"> <!--page_direct('floorplans', this.value)-->
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
                                     @if(isset($year))
											@if($row->id == $year)
												selected
											@endif
										@endif
										
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
                            	<!--If summary isset use that value to determine which values go here-->
                            	
							
								<tr>
									<th>Org Name</th>
									<th>Machine ID</th>
									<th>Building Name</th>
									<th>Room Name</th>
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
                            	
                     
                
								@if(isset($non_contract_devices))	
                            		@foreach($non_contract_devices as $row)
									<tr>
									<td>{{$row->org_name}}</td>
									<td>{{$row->machines_id}}</td>
									<td>{{$row->bldg_name}}</td>
									<td>{{$row->room_name}}</td>
									<td>{{$row->make}}</td>
									<td>{{$row->model}}</td>
									<td>{{$row->serial_number}}</td><!--$row->serial_number-->
									<td>{{$row->ip_address}}</td>
									<td>{{$row->mac_address}}</td>
                                	<td>Last Reporting Date</td>
									<td>{{$row->budgeted_black}}</td>
									<td>{{$row->budgeted_color}}</td>
									<td>Reporting</td>
									<td>Current Black Meter</td>
									<td>Current Color Meter</td>
									<td>@if($row->toner == 'Y')Yes @else No @endif</td>
									<td>@if($row->service_needed == 'Y')Yes @else No @endif</td>
									<td>under_contract</td>
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