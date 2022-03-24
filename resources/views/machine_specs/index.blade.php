@extends('layouts.app')
<!--machine_specs/index.blade.php-->

@section('content')

<div class="my-3 mx-3">
    
    <!--Search by Make-->
	<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
	@csrf
		<div class="container-fluid">
			<div class="d-flex my-3">
				<div class="form-group">
					<label for="makeSel">Make</label>					

					<select name="makeSel" id="makeSel" class="form-control mb-2" onchange="page_direct('machine_specs', this.value)">
						<option>Select a Make</option>
						<!--Display all machines from the resultset.-->	
						@if(isset($makes))
    						@foreach($makes as $row)
    							
    							<option value="{{$row->mach_make}}"
    								@if(isset($make_name))
    									@if($row->mach_make == $make_name)
    										selected
    									@endif
    								@endif
    							>{{$row->mach_make}}</option>
    						@endforeach
    					@endif
					</select>
				</div><!--end form-group-->						
			</div><!--end d-flex-->
		</div><!--container-fluid-->
	</form>
	
</div><!--end my-3 mx-3-->
		

<main id="js-page-content" class="my-3 mx-3">
    <!--<div class="row">
		<div class="col-xl-12">-->	
        	<div id="panel-1" class="panel">
        		<div class="panel-hdr">
        			
        			<h2>
						@if(!isset($id))
							All Machine Specifications <span class="fw-300"><i>For all makes</i></span>
						@else
							All Machine Specifications <span class="fw-300"><i>For this make</i></span>
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
        			<div class="panel-content">
        				<div class="panel-tag">
        					This table shows the specifications for all machines. <strong>Note: </strong>To view only
							the specifications associated with a specific make, please select a make from the dropdown above.
        				</div><!--end panel-tag-->
        				
        				<!-- datatable start -->
        				<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
        					<thead class="myTabHead">							
        						<tr>
        							<th colspan="12" class="pt-1 pb-1 pl-1 pr-1 text-center">
        								<div class="js-get-date h5 mb-2"></div>
        							</th>
        						</tr>
        					
        						<tr>
        							<th>Spec ID</th>
        							<th>Make</th>
        							<th>Model</th>
        							<th>Features</th>
        							<th>Min Speed</th>
        							<th>Max Speed</th>
        							<th>Machine Image</th>
        							<th>Intro</th>
        							<th>Life</th>
        							<th>Color</th>
        							<th>Date Added</th>
        							<th>Auto Created</th>
        							<th></th>
        						</tr>
        					</thead>
        					<tbody>
        						@foreach($specs as $row)
        							<tr>
        								<td>{{$row->spec_id}}</td>
        								<td>{{$row->mach_make}}</td>
        								<td>{{$row->model}}</td>
        								<td>{{$row->features}}</td>
        								<td>{{$row->min_speed}}</td>
        								<td>{{$row->max_speed}}</td>
        								<td>{{$row->machine_image}}</td>
        								<td>{{$row->intro}}</td>
        								<td>{{$row->life}}</td>
        								<td>{{$row->is_color}}</td>
        								<td>{{$row->created_date}}</td>
        								<td>{{$row->auto_created}}</td>
        								<td>
        									<a href="{{route('machine_specs.index', $row->mach_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
        									@if(isset($make_name))
										        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->spec_id}}, 'deleteMachSpec', '')">Delete</button>
										    @else
										        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->spec_id}}, 'deleteMachSpec', 'machine_specs/')">Delete</button>
										    @endif
        									
        									<!--<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->spec_id}}, 'deleteMachSpec', 'machine_specs/')">Delete</button>-->
        								</td>								
        							</tr>
        						@endforeach						
        					</tbody>			
        				</table><!-- end datatable -->
        			<!--</div> end panel-content -->
        				
        				<div class="btn-group my-3">
        				
        					@if($errors->any())
        						<div class="alert alert-danger">
        							<ul class="list-group">
        								@foreach($errors->all() as $error)
        									<li class="list-group-item  text-danger">
        										{{$error}}
        									</li>
        								@endforeach
        							</ul>
        						</div><!--end alert-->
        					@endif
        				
        				
        					<form action="{{route('machine_specs.store')}}" method="post">
        					@csrf
        						<!--<div class="form-group">
        							<label for="org_type_name">Add a New Org Type</label>						
        							<input type="text" class="form-control" name="org_type_name" id="org_type_name">
        						</div>-->
        						
        						<div class="btn-group my-3">			
            						<a href="{{route('machine_specs.create')}}" class="btn btn-sm btn-primary center mx-3">Add a Specification</a>
            							
            					</div><!--end btn-group-->
        						
        						<!--<div class="form-group">						
        							<button class="btn btn-success">Add Machine Specification</button>
        							
        						</div>--><!--end form-group-->
        					</form>
        			</div><!--end btn-group-->
        				
        				
        				<!-- Begin Modal -->
        				<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        				  <div class="modal-dialog" role="document">
        						<form action="" method="post" id="deleteMachSpec">						
        						@csrf
        						@method('DELETE')
        						
        							<div class="modal-content">
        							  <div class="modal-header">
        									<h5 class="modal-title" id="deleteModalLabel">Delete Machine Spec</h5>
        									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        									  <span aria-hidden="true">&times;</span>
        									</button>
        							  </div>
        							  <div class="modal-body">
        								<p class="text-center text-bold">
        									Are you sure you want to permanently delete this machine specification?
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
        <!--</div> end col-xl-12 
    </div>end row -->
</main><!--end my-3-->
@endsection