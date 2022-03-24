@extends('layouts.app')
<!-- departments/index.php-->

@section('content')
<div class="my-3 mx-3">
	<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
	@csrf
		<div class="container-fluid">
			<div class="d-flex my-3">
				<div class="form-group">
					<label for="orgSel">Organization</label>					

					<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('departments', this.value)">
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
							All Departments <span class="fw-300"><i>For all organizations</i></span>
						@else
							All Departments <span class="fw-300"><i>For this organization</i></span>
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
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<div class="panel-tag">
							This table shows all departments that are associated with any organization. <strong>Note: </strong>To view only
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
									<th>Department ID</th>
									<th></th>
									<th>Organization</th>
									<th>Department Name</th>
                                	<th></th>
                                	
								</tr>
							</thead>
							<tbody>
							    @if (isset($dept_data))
    								@foreach($dept_data as $row)
    									<tr>
    										<td>{{$row->dept_id}}</td>
    										<td>Go to floorplans records</td>
    										<td>{{$row->org_name}}</td>
    										<td>{{$row->dept_name}}</td>
    										
                                        	<td><a href="{{route('departments.edit', $row->dept_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
    											@if(isset($id))
                    						        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->dept_id}}, 'deleteDepartment', '')">Delete</button>
                    						    @else
                    						        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->dept_id}}, 'deleteDepartment', 'departments/')">Delete</button>
                    						    @endif
    											
    											<!--<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->dept_id}}) ?? ''}}, 'deleteDepartment', 'departments/')">Delete</button>-->
    										</td>
                                        	
    									</tr>
    								@endforeach	
								@endif
								
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<a href="{{route('buildings.create')}}" class="btn btn-sm btn-primary center mx-3">Add Building</a>
							
					</div><!--end btn-group-->
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->
			
			Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteDepartment">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete Department Record</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to delete this department record?
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