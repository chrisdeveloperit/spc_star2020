@extends('layouts.app')
<!--floorplans/index.blade.php-->

@section('content')
<div class="my-3 mx-3">
	<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
	@csrf
		<div class="container-fluid">
			<div class="d-flex my-3">
				<div class="form-group">
					<label for="buildingsSel">Buildings</label>					

					<select name="buildingsSel" id="buildingsSel" class="form-control mb-2" onchange="page_direct('floorplans', this.value)">
						<option>Select a building</option>
						<!--Display all orgs from the resultset.-->						
						@foreach($buildings as $row)
							
							<option value="{{$row->bldg_id}}"
								@if(isset($bldg_id))
									@if($row->buildings_id == $bldg_id)
										selected
									@endif
								@endif
							>{{$row->bldg_name}}</option>
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
						@if(!isset($bldg_id))
							All Floorplans <span class="fw-300"><i>For all buildings</i></span>
						@else
							All Floorplans <span class="fw-300"><i>For this specific building</i></span>
						@endif
					</h2>
					<div class="panel-toolbar">
						<button class="btn btn-primary btn-sm" data-toggle="dropdown">Table Style</button>
						<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right position-absolute pos-top">
							<button class="dropdown-item active" data-action="toggle" data-class="table-bordered" data-target="#dt-basic-example"> Bordered Table </button>
							<button class="dropdown-item" data-action="toggle" data-class="table-sm" data-target="#dt-basic-example"> Smaller Table </button>
							<button class="dropdown-item" data-action="toggle" data-class="table-dark" data-target="#dt-basic-example"> Table Dark </button>
							<button class="dropdown-item active" data-action="toggle" data-class="table-hover" data-target="#dt-basic-example"> Table Hover </button>
							<button class="dropdown-item active" data-action="toggle" data-class="table-stripe" data-target="#dt-basic-example"> Table Striped </button>
							<div class="dropdown-divider m-0"></div>
							
						</div>
					</div>
				</div>
				<div class="panel-container show">
					<div class="panel-content table-responsive">
						<div class="panel-tag">
							This table shows all floorplans that are associated with any building. <strong>Note: </strong>To view only
							the floorplans associated with a specific building, please select a building from the dropdown above.
						</div>
						
						<!-- datatable start -->
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="7" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="js-get-date h5 mb-2"></div>
									</th>
								</tr>
							
								<tr>
									<th>Floorplan ID</th>
									<th>Building ID</th>
									<th>Floor Number</th>
									<th>Floorplan Image</th>
									<th>Last Audited By</th>
									<th>Last Audited Date</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@if(isset($floorplans))
								@foreach($floorplans as $row)
									<tr>
										<td>{{$row->fp_id}}</td>
										<td>{{$row->buildings_id}}</td>
										<td>{{$row->floor_number}}</td>
										<td>{{$row->floorplan_image}}</td>
										<td>{{$row->modified_by}}</td>
										<td>{{$row->modified_date}}</td>
										<td>
										<a href="{{route('floorplans.edit', $row->fp_id)}}" class="btn btn-sm btn-primary float-right m-1">Edit</a>-->
											<button class="btn btn-sm btn-danger m-1 float-right m-1" onclick="handleDelete({{$row->fp_id}}, 'deleteFloorplan', '')">Delete</button>
										</td>
									</tr>
								@endforeach
							@endif								
								
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<a href="index" class="btn btn-sm btn-primary center mx-3">Add Floorplan</a>									
					</div><!-- end form-group -->
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->

			<!-- Begin Modal -->
			<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
					<form action="" method="post" id="deleteFloorplan">						
					@csrf
					@method('DELETE')
					
						<div class="modal-content">
						  <div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete Floorplan</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
						  </div>
						  <div class="modal-body">
							<p class="text-center text-bold">
								Are you sure you want to permanently delete this floorplan?
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
	
</main><!-- end my-3 -->


@endsection