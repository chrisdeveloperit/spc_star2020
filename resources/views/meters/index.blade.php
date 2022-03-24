@extends('layouts.app')

@section('content')
<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
@csrf
	<div class="container-fluid">
		<div class="d-flex my-3">
			<div class="form-group">
				<label for="yearSel">Year (Only 2015-2016 through 2018-2019 Are in db for testing)</label>				

				<select name="yearSel" id="yearSel" class="form-control mb-2" onchange="page_direct('meters', this.value)">
					<option value="">Select Year</option>
					@if(isset($years))
						@foreach($years as $year)
							<option value="{{$year->id}}">{{$year->school_year}}</option>							
						@endforeach
					@endif
				</select>
			</div><!--end form-group-->			
		</div><!--end d-flex-->
	</div><!--container-fluid-->
</form>
	

<!--<div class="container-fluid my-3">		
		<h3>Table: Meter</h3>			
	</div>--><!--container-fluid-->
	


<div class="my-3 mx-3">
	<h4>Meter Reads</h4>		
		
	<!--Begin table for contacts data-->
	<!--<table border="1px" class="m-0 table-sm table-responsive table-responsive-sm table-hover">-->
	<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>
				<th>ID</th>
				<th>Serial Number</th>
				<th>Black Meter</th>
				<th>Color Meter</th>
				<th>Read Date</th>
				<th></th>
			</tr>
		</thead>
		<tbody>					
				@if(isset($meters))
					@foreach($meters as $meter)
						<tr>				
							<td>{{$meter->mtr_id}}</td>
							<td>{{$meter->serial_number}}</td>
							<td>{{$meter->black_meter}}</td>
							<td>{{$meter->color_meter}}</td>
							<td>{{$meter->created_date}}</td>
							<td>
								
								<a href="{{route('meters.edit', $meter->mtr_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
								<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$meter->id}}, 'deleteMeter', 'meters/')">Delete</button>
							</td>
						</tr>
					@endforeach
				@endif					
		</tbody>			
	</table>
	<!--End table for contacts data-->
	
	
	
	
	
	<div class="btn-group my-3">			
		<a href="{{route('meters.create')}}" class="btn btn-sm btn-primary center mx-2">Add Meter Read</a>
		<a href="index" class="btn btn-sm btn-primary center mx-2">Update All Selected Records</a>
		<a href="index" class="btn btn-sm btn-primary center mx-2">Delete Selected Records</a>
	</div><!--end btn-group-->
	
	
	<!-- Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteMeter">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete Meter Record</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to permanently delete this meter record?
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