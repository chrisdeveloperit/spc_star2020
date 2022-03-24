@extends('layouts.app')

@section('content')



<div class="my-3 mx-3">
	<h4>Machine Types</h4>		
	
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
	
	<form action="{{isset($machine_types) ? route('machine_types.update', $machine_types->id) : route('machine_types.store')}}" method="post" name="createMachType">		
	@csrf
	@if(isset($machine_types))
		@method('PUT')
	@endif

	
	<!--Begin table for meters create-->	
	<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>				
				@if(isset($machine_types))
					<th>ID</th>
				@endif
				<th>Type Name (*)</th>
				<th>Machine Type (*)</th>
				<th>Icon Type</th>				
				<th>Color</th>
				<th>Covered Type</th>
				<th></th>			
			</tr>
		</thead>
		
		<tbody>		
			<tr>
				@if(isset($machine_types))
					<td>{{$machine_types->id}}</td>
				@endif
				
				<td>
					<input type="text" name="type_name" id="type_name" value="{{isset($machine_types->type_name) ? $machine_types->type_name : ''}}"/>
				</td>
				
				
				<td>
					<select name="machine_type" id="machine_type" class="form-control mb-2">
						@if(isset($data))
							@foreach($data as $row)						
												
								<!--Display all machine_types from the resultset.-->														
								<option value="{{$row->machine_type}}"
									@if(isset($machine_types->machine_type))
										@if($row->machine_type == $machine_types->machine_type)
											selected
										@endif
									@endif
									>
									{{$row->machine_type}}
								</option>													
							@endforeach
						@endif				
					</select>
				</td>
				
				<td>
					<select name="icon_type" id="icon_type" class="form-control mb-2">
						@if(isset($icons))
							@foreach($icons as $row)						
												
								<!--Display all machine_types from the resultset.-->														
								<option value="{{$row->icon_type}}"
									@if(isset($machine_types->icon_type))
										@if($row->icon_type == $machine_types->icon_type)
											selected
										@endif
									@endif
									>
									{{$row->icon_type}}
								</option>													
							@endforeach
						@endif				
					</select>
				</td>
								
				
				<td>
					<select name="is_color" id="is_color" class="form-control mb-2">
						<option value="N">Select Y/N</option>
						@if(isset($color))
							@foreach($color as $row)						
												
								<!--Display all machine_types from the resultset.-->														
								<option value="{{$row->is_color}}"
									@if(isset($machine_types->is_color))
										@if($row->is_color == $machine_types->is_color)
											selected
										@endif
									@endif
									>
									@if($row->is_color == 'Y')
										Yes
									@else
										No									
									@endif									
								</option>													
							@endforeach
						@endif											
					</select>
				</td>
				
											
				<td>
					<select name="covered" id="covered" class="form-control mb-2">
						<option value="N">Select Y/N</option>
						@if(isset($color))
							@foreach($color as $row)						
												
								<!--Display all machine_types from the resultset.-->														
								<option value="{{$row->is_color}}"
									@if(isset($machine_types->is_color))
										@if($row->is_color == $machine_types->is_color)
											selected
										@endif
									@endif
									>
									@if($row->is_color == 'Y')
										Yes
									@else
										No									
									@endif									
								</option>													
							@endforeach
						@endif											
					</select>
				</td>
				
				
				
				
				<td><button type="submit" class="btn btn-success btn-sm">{{isset($machine_types) ? 'Update Record' : 'Add Record'}}</button>
					<a href="{{route('machine_types.index')}}" class="btn btn-danger btn-sm">Cancel</a>
				</td>
				
			</tr>
		</tbody>			
	</table>
	</form>
	<!--End table for contacts data-->	
		
</div><!--end my-3-->
</form>	
@endsection