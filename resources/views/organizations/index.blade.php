@extends('layouts.app')
<!--File: organizations/index.blade.php-->

@section('content')
<div class="my-3 mx-3">
	<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
	@csrf
		<div class="container-fluid">
			<div class="d-flex my-3">
				<div class="form-group">
					<label for="orgSel">Organization Type</label>					

					<select name="orgTypeSel" id="orgTypeSel" class="form-control mb-2" onchange="page_direct('organizations', this.value)">
                    
						<option>Select an org type</option>
						<!--Display all orgs from the resultset.-->						
						@foreach($data as $row)
							
							<option value="{{$row->org_type_id}}"
								@if(isset($type_id))
									@if($row->org_type_id == $type_id)
										selected
									@endif
								@endif
							>{{$row->org_type_name}}</option>
						@endforeach
						
					</select>
				</div><!--end form-group-->						
			</div><!--end d-flex-->
		</div><!--container-fluid-->
	</form>
</div><!--end my-3 mx-3-->

		
		
<main id="js-page-content" class="my-3 mx-3">
	<div class="row">
		<div class="col-xl-12">
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<h2>
						@if(!isset($id))
							All Organizations <span class="fw-300"><i>For any client status</i></span>
						@else
							All Organizations <span class="fw-300"><i>For this specific client status</i></span>
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
							This table shows all organizations, no matter what the org type is. <strong>Note: </strong>To view only
							specific types of organizations, please select an org type from the dropdown above.
						</div>
						
						<!-- datatable start -->
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> 							
								<tr>
									<th colspan="29" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="js-get-date h5 mb-2"></div>
									</th>
								</tr>
							
								<tr>
									<th>Org ID</th>
									<th>Org Name</th>
									<th>Org Type</th>
									<th>Address</th>
									<th>Address2</th>
									<th>City</th>
									<th>State</th>
									<th>Zip</th>
									<th>County</th>									
									<th>Phone Number</th>
									<th>Fax Number</th>
									<th>Website</th>									
									<th>FM Audit Client ID</th>
									<th>Commencement Date</th>
									<th>Client ID</th>
									<th>Client Since</th>
									<th>Client Status</th>
									<th>Print Mgmt Software Instal</th>
									<th>LENP Contract Signed</th>
									<th>Display Meter Data</th>
									<th>Meter Data Feed</th>
									<th>Client Logo</th>
									<th>GM Notes</th>
									<th>Org Message</th>
									<th>Bank Buyout</th>
									<th>SPC Service Fee</th>
									<th>Trade Out Deletion</th>
									<th>New Upgrade Date</th>
									<th>Temp Inactive</th>
									<th></th>
									
								</tr>
							</thead>
							<tbody>
								@if(isset($orgdata))
								@foreach($orgdata as $row)
									<tr>
										<td>{{$row->org_id}}</td>
										<td>{{$row->org_name}}</td>
										<td>{{$row->org_type_name}}</td>
										
										<td>@if(isset($row->address))
										        {{$row->address}}
										    @elseif(isset($row->address_mail))
										        {{$row->address_mail}}
										    @endif
										</td>
										
										<!--<td>{{$row->address2}}</td>-->
										<td>@if(isset($row->address) && isset($row->address2))
										        {{$row->address2}}
										    @endif
										</td>
										
										<td>{{$row->city}}</td>
										<td>{{$row->state}}</td>
										<td>{{$row->zip_code}}</td>
										<td>{{$row->county}}</td>									
										<td>@if(isset($row->area_code))
											{{$row->area_code}}-{{$row->exch}}-{{$row->phone_line}}
											@endif
										</td>
										<td>@if(isset($row->f_area_code))
											{{$row->f_area_code}}-{{$row->f_exch}}-{{$row->f_phone_line}}
											@endif
										</td>
										<td>{{$row->website}}</td>									
										<td>{{$row->fmaudit_client_id}}</td>
										<td>{{$row->commencement_date}}</td>
										<td>{{$row->org_short_name}}</td>
										<td>{{$row->client_since}}</td>
										<td>{{$row->client_status}}</td>
										<td>{{$row->print_mgmt_software_installed}}</td>
										<td>{{$row->lenp_contract_signed}}</td>
										<td>{{$row->display_meter_data}}</td>
										<td>{{$row->meter_data_feed}}</td>
										<td>{{$row->client_logo}}</td>
										<td>{{$row->gm_notes}}</td>
										<td>{{$row->org_message}}</td>
										<td>{{$row->bank_buyout}}</td>
										<td>{{$row->spc_service_fee}}</td>
										<td>{{$row->trade_out_deletion}}</td>
										<td>{{$row->new_upgrade_date}}</td>
										<td>{{$row->temp_inactive}}</td>
										
										<td><a href="{{route('organizations.edit', $row->org_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
											
											@if(isset($type_id))
                						        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->org_id}}, 'deleteOrganization', '')">Delete</button>
                						    @else
                						        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->org_id}}, 'deleteOrganization', 'organizations/')">Delete</button>
                						    @endif
										
											<!--<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->org_id}}, 'deleteOrganization', 'organizations/')">Delete</button>-->
										</td>
									</tr>
								@endforeach
							@endif								
								
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<a href="{{route('organizations.create')}}" class="btn btn-sm btn-primary center mx-3">Add Organization</a>
						<!--<a href="index" class="btn btn-sm btn-primary center">Edit Organization</a>-->			
					</div><!--end form-group-->
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->
			
			
			
		<!-- Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteOrganization">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete Organization Record</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to delete this organization record?
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Yes, Delete</button>
				  </div>
				</div>
			</form>
	  </div><!-- End modal-dialog -->
	</div><!-- End modal deleteModal -->
	<!-- End Modal -->	
	
</main><!--end my-3-->


@endsection