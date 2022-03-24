@extends('layouts.app')

@section('content')



<div class="my-3 mx-3">
	<h4>Machine Status</h4>		
	
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
	<form action="{{isset($machine_statuses) ? route('machine_statuses.update', $machine_statuses->id) : route('machine_statuses.store')}}" method="post" name="createMachStat">
		
	@csrf
	@if(isset($machine_statuses))
		@method('PUT')
	@endif

	
	<!--Begin table for meters create-->	
	<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>				
				@if(isset($machine_statuses))
					<th>ID</th>
				@endif
				<th>Serial Number (*)</th>
				<th>Black Toner (*)</th>
				<th>Service Needed</th>				
				<th></th>			
			</tr>
		</thead>
		
		<tbody>		
			<tr>
				@if(isset($machine_statuses))
					<td>{{$machine_statuses->id}}</td>
				@endif
				
				
				<td>
					<input type="text" name="serial_number" id="serial_number" value="{{isset($machine_statuses->serial_number) ? $machine_statuses->serial_number : ''}}"/>
				</td>
				
				<td>
					<select name="toner" id="toner" class="form-control mb-2">											
						<option value="N">Select Y/N</option>
						<!--Display all options.-->														
						
						<option value="Y"
						@if(isset($machine_statuses->toner))
								@if($machine_statuses->toner == "Y")
									selected
								@endif
						@endif
						>Yes</option>
						<option value="N"
						@if(isset($machine_statuses->toner))
								@if($machine_statuses->toner == "N")
									selected
								@endif
						@endif
						>No</option>																							
					</select>
				</td>

				<td>
					<select name="service_needed" id="service_needed" class="form-control mb-2">											
						<option value="N">Select Y/N</option>
						<!--Display all options.-->														
						
						<option value="Y"
						@if(isset($machine_statuses->service_needed))
								@if($machine_statuses->service_needed == "Y")
									selected
								@endif
						@endif
						>Yes</option>
						<option value="N"
						@if(isset($machine_statuses->service_needed))
								@if($machine_statuses->service_needed == "N")
									selected
								@endif
						@endif
						>No</option>																							
					</select>
				</td>
				
				<td><button type="submit" class="btn btn-success btn-sm">{{isset($machine_statuses) ? 'Update Record' : 'Add Record'}}</button>
					<a href="{{route('machine_statuses.index')}}" class="btn btn-danger btn-sm">Cancel</a>
				</td>
				
			</tr>
		</tbody>			
	</table>
	</form>
	<!--End table for contacts data-->	
		
</div><!--end my-3-->
</form>	
@endsection