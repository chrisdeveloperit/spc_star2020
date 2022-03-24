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
	

<div class="container-fluid my-3">		
	<h3>Table: Meter</h3>			
</div><!--container-fluid-->


<div class="my-3 mx-3">
	<h4>Meter Reads</h4>		
	
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
	<form action="{{isset($meter) ? route('meters.update', $meter->id) : route('meters.store')}}" method="post" name="createMeter">
		
	@csrf
	@if(isset($meter))
		@method('PUT')
	@endif

	
	<!--Begin table for meters create-->	
	<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>				
				<th>Machine ID</th>
				<th>Black Meter</th>
				<th>Color Meter</th>
				<th>Action</th>				
			</tr>
		</thead>
		
		<tbody>		
			<tr>
				<td><input type="text" id="machines_id" name="machines_id" value="{{isset($meter->machines_id) ? $meter->machines_id : ''}}"/></td>
				<td><input type="text" id="black_meter" name="black_meter" value="{{isset($meter->black_meter) ? $meter->black_meter : ''}}"/></td>
				<td><input type="text" id="color_meter" name="color_meter" value="{{isset($meter->color_meter) ? $meter->color_meter : ''}}"/></td>
				<td><button type="submit" class="btn btn-success btn-sm">{{isset($meter) ? 'Update Record' : 'Add Record'}}</button>
					<a href="{{route('meters.index')}}" class="btn btn-danger btn-sm">Cancel</a>
				</td>
				
			</tr>
		</tbody>			
	</table>
	</form>
	<!--End table for contacts data-->	
		
</div><!--end my-3-->
</form>	
@endsection