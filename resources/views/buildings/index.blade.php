@extends('layouts.app')
<!-- buildings/index.php-->

@section('content')
<div class="my-3 mx-3">
	<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
	@csrf
		<div class="container-fluid">
			<div class="d-flex my-3">
				<div class="form-group">
					<label for="orgSel">Organization</label>					

					<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('buildings', this.value)">
						<option>Select an Organization</option>
						<!--Display all orgs from the resultset.-->						
						@foreach($orgs as $row)
							
							<option value="{{$row->org_id}}"
								@if(isset($id))
									@if($row->org_id == $id)
										selected
									@endif
								@endif
							>{{$row->org_name}}</option>
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
							All Buildings <span class="fw-300"><i>For all organizations</i></span>
						@else
							All Buildings <span class="fw-300"><i>For this organization</i></span>
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
							
						</div>
					</div>
				</div><!--end panel-hdr-->
				
				<div class="panel-container show">
					<div class="panel-content">
						<div class="panel-tag">
							This table shows all buildings that are associated with any organization. <strong>Note: </strong>To view only
							the buildings associated with a specific organization, please select an org from the dropdown above.
						</div>
						
						<!-- datatable start -->
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="js-get-date h5 mb-2">[your date here]</div>
									</th>
								</tr>
							
								<tr>
									<th>Building ID</th>
									<th>Floorplans</th>
									<th>Organization</th>
									<th>Building Name</th>
									<th>Address</th>
									<th>City</th>
									<th>State</th>
									<th>Zip</th>
									<th>Building Contact</th>
									<th>Student Pop</th>
									<th>Bldg Equip Costs</th>
									<th>Org Short Name - was Client ID</th>
                                	<th></th>
                                	
								</tr>
							</thead>
							<tbody>
								@foreach($bldg_data as $row)
									<tr>
										<td>{{$row->bldg_id}}</td>
										<td>See Floorplan</td>
										
										<!--<td><button class="btn btn-danger btn-sm m-1" onclick="showMyModal({{$row->bldg_id}}, 'showFloorplanForm', 'floorplans/')">See Floorplan</button></td>-->
										<td>{{$row->org_name}}</td>
										<td>{{$row->bldg_name}}</td>
										<td>@if(isset($row->address))
										        {{$row->address}}
										    @elseif(isset($row->address_mail))
										        {{$row->address_mail}}
										    @endif
										</td>
										<td>{{$row->city}}</td>
										<td>{{$row->state}}</td>
										<td>{{$row->zip_code}}</td>
										<td>@if(isset($row->contacts_id))
										        {{$row->contacts_id}}
										    @endif</td>
										<td>{{$row->student_pop}}</td>
										<td>{{$row->bldg_equip_cost}}</td>
										<td>{{$row->org_short_name}}</td>
                                    	<td><a href="{{route('buildings.edit', $row->bldg_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
											
											@if(isset($id))
										        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->bldg_id}}, 'deleteBuilding', '')">Delete</button>
										    @else
										        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->bldg_id}}, 'deleteBuilding', 'buildings/')">Delete</button>
										    @endif
											
										</td>
									</tr>
								@endforeach				
								
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<a href="{{route('buildings.create')}}" class="btn btn-sm btn-primary center mx-3">Add Building</a>
							
					</div><!--end btn-group-->
				
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->
		</div><!--end col-xl-12-->
	</div><!--end row-->
	
	
	<!-- Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteBuilding">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete Building Record</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to delete this building record?
					</p>
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