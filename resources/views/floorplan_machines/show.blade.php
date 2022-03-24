@extends('layouts.app')
<!--floorplan_machines/index.blade.php-->

@section('content')
<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
@csrf
	<div class="container-fluid">
		<div class="d-flex my-3">
			<div class="form-group">
				<label for="fpSel">Floorplan</label>				

				<select name="fpSel" id="fpSel" class="form-control mb-2" onchange="page_direct('floorplan_machines', this.value)">
					<option value="">Select Floorplan</option>
					@if(isset($plans))
						@foreach($plans as $row)
							<option value="{{$row->fp_id}}">bldg_id --{{$row->buildings_id}} - - floor_number --{{$row->floor_number}}</option>							
						@endforeach
					@endif
				</select>
			</div><!--end form-group-->			
		</div><!--end d-flex-->
	</div><!--container-fluid-->
</form>
	

	<!--<div class="container-fluid my-3">		
		<h3>Table: Floorplan Machines</h3>			
	</div>--><!--container-fluid-->
	


<div class="my-3 mx-3">
	<h4>Floorplan Machines</h4>		
		
	<!--Begin table for contacts data-->
	<!--<table border="1px" class="m-0 table-sm table-responsive table-responsive-sm table-hover">-->
	<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>
				<th>ID</th>
				<th>Floorplan ID</th>
				<th>Dept ID</th>
				<th>Proposed x Position</th>
				<th>Proposed y Position</th>
				
				<th></th>
			</tr>
		</thead>
		<tbody>					
				@if(isset($machs))
					@foreach($machs as $row)
						<tr>				
							<td>{{$row->fpm_id}}</td>
							<td>{{$row->present_floorplans_id}}</td>
							<td>{{$row->departments_id}}</td>
							<td>{{$row->proposed_x_position}}</td>
							<td>{{$row->proposed_y_position}}</td>
							
							<td>
								<a href="{{route('floorplan_machines.edit', $row->fpm_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
								<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->fpm_id}}, 'deleteMach', 'floorplan_machines/')">Delete</button>
							</td>
						</tr>
					@endforeach
				@endif					
		</tbody>			
	</table>
	<!--End table for contacts data-->
	
	
	
	
	
	<!--<div class="btn-group my-3">			
		<a href="{{route('meters.create')}}" class="btn btn-sm btn-primary center mx-2">Add Meter Read</a>
		<a href="index" class="btn btn-sm btn-primary center mx-2">Update All Selected Records</a>
		<a href="index" class="btn btn-sm btn-primary center mx-2">Delete Selected Records</a>
	</div>--><!--end btn-group-->
	
	
	<!-- Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteMach">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete Machine Record</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to delete this machine record?
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
	
</div><!--end my-3-->
	
@endsection