@extends('layouts.app')


@section('content')

		
		
<main id="js-page-content" class="my-3 mx-3">	
	<div id="panel-1" class="panel">
		<div class="panel-hdr">
			<h2>Organization Types</h2>
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
			<div class="panel-content">
				<div class="panel-tag">
					This table shows all types that an organization can be classified as. <strong>Note: </strong>These classifications are
						used to determine inclusion in certain reports, among other things.
				</div><!--end panel-tag-->
				
				<!-- datatable start -->
				<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
					<thead class="myTabHead">							
						<tr>
							<th colspan="8" class="pt-3 pb-2 pl-3 pr-3 text-center">
								<div class="js-get-date h5 mb-2">[your date here]</div>
							</th>
						</tr>
					
						<tr>
							<th>ID</th>
							<th>Org Type Name</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($orgTypes as $row)
							<tr>
								<td>{{$row->org_type_id}}</td>
								
									@if($row->org_type_id == $typeRec->org_type_id) <!--$type_id)-->
									
									
										@if($errors->any())
											<div class="alert alert-danger">
												<ul class="list-group">
												
													@foreach($errors->all() as $error)
													<li class="list-item">
														{{$error}}
													</li>
													@endforeach
												</ul>
										
											</div><!--end alert -->
										@endif
									
										<form method="post" action="{{route('org_types.update', $row->org_type_id)}}" >
										@method('PUT')
										@csrf
										
											<!--<td><input type="text" id="in_org_type_name" name="in_org_type_name" value="{{$row->org_type_name}}"</td>-->
											<td><input type="text" id="org_type_name" name="org_type_name" value="{{$typeRec->org_type_name}}"</td>
											<td>
												<!--<a href="{{route('org_types.update', $row->id)}}" class="btn btn-success btn-sm">Submit Update</a>-->
												<button type="submit" class="btn btn-success btn-sm">Submit Update</button>
												<a href="{{route('org_types.index')}}" class="btn btn-danger btn-sm">Cancel Update</a>
											</td>
										</form>
									@else
										<td>{{$row->org_type_name}}</td>
									<!--<td>
										<a href="{{route('org_types.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
										<button class="btn btn-danger btn-sm" onclick="handleDelete({{$row->id}}, 'deleteOrgTypeForm', 'org_types/')">Delete</button>
									</td>-->
									@endif
																
							</tr>
						@endforeach						
					</tbody>			
				</table><!-- end datatable -->
				
				<div class="btn-group my-3">
					<form action="{{route('org_types.store')}}" method="post">
					@csrf
						
					</form>
				</div><!--end btn-group-->
				
				
				<!-- Begin Modal -->
				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
						<form action="" method="post" id="deleteOrgTypeForm">						
						@csrf
						@method('DELETE')
						
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Delete Org Type</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<p class="text-center text-bold">
									Are you sure you want to permanently delete this org type?
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
				
				
			</div><!-- end panel-content -->
			
			
		</div><!-- end panel-container -->
	</div><!-- end panel-1 -->	
</main><!--end my-3-->
@endsection