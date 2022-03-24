@extends('layouts.app')
<!--machine_types/index.blade.php-->

@section('content')


<div class="my-3 mx-3">
	<h4>Machine Types</h4>		
		
	<!--Begin table for contacts data-->
	<!--<table border="1px" class="m-0 table-sm table-responsive table-responsive-sm table-hover">-->
	<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>
				<th>ID</th>
				<th>Type Name (*)</th>
				<th>Machine Type (*)</th>
				<th>Icon Type</th>				
				<th>Color</th>
				<th>Covered Type</th>
				<th></th>
			</tr>
		</thead>
		<tbody>					
				@if(isset($machine_types))
					@foreach($machine_types as $mach)
						<tr>				
							<td>{{$mach->mach_type_id}}</td>
							<td>{{$mach->type_name}}</td>
							<td>{{$mach->machine_type}}</td>
							<td>{{$mach->icon_type}}</td>
							<td>{{$mach->is_color}}</td>
							<td>{{$mach->covered}}</td>
							<td>
								
								<a href="{{route('machine_types.edit', $mach->mach_type_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
								<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$mach->id}}, 'deleteMachType', 'machine_types/')">Delete</button>
							</td>
						</tr>
					@endforeach
				@endif					
		</tbody>			
	</table>
	<!--End table for contacts data-->
	
	
		
	<div class="btn-group my-3">			
		<a href="{{route('machine_types.create')}}" class="btn btn-sm btn-primary center mx-2">Add Machine Type</a>		
	</div><!--end btn-group-->
	
	
	<!-- Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteMachType">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete Machine Type</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to permanently delete this machine type?
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