@extends('layouts.app')

<!--machine_specs/create.blade-->

@section('content')
<div class="my-3 mx-3">	
	
</div><!--end my-3 mx-3-->

		
		
<main id="js-page-content" class="my-3 mx-3">
	<div class="row">
		<div class="col-xl-12">
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<h2>						
                        {{isset($specs) ? 'Update the Specification Record for This Machine' : 'Create a New Specification Record'}}
					</h2>
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<div class="panel-tag">
							Create a new specification record. <strong>Note: </strong>Some data is required to create a machine specifications record.
							    Your entry will not be submitted without the required data. This is to maintain the integrity of the data.
						</div>
						
						<form action="{{isset($specs) ? route('machine_specs.update', $specs->spec_id) : route('machine_specs.store')}}" method="post" enctype="multipart/form-data"> <!--enctype needed for image upload-->
						@csrf
                            @if(isset($specs))
                                @method('PUT')
                            @endif
						
						<!-- datatable Machine Specifications start -->
						<table id="dt-basic-exampleBD" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($specs) ? 'Update Specification Data' : 'Create Machine Specification'}}</div>
									</th>
								</tr>
							
								<tr>
								    @if(isset($specs))
                                    	<!--only display the spec_id text box if this is an update. The ID is auto incremented-->
                                    	<td>Spec ID</td>
                                	@endif									
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
								</tr>
							</thead>
							
							<tbody>
								<tr>										
									@if(isset($specs))
                                	
                                    	<!--only display the spec_id text box if this is an update. The ID is auto incremented-->
                                    	<td>
                                        	<input type="text" class="form-control" name="spec_id" id="spec_id"  readonly="readonly" value="{{isset($specs->spec_id) ? $specs->spec_id : ''}}"/>
                                    	</td>
                                	@endif
                                	
									
                                	<td>
										<select name="addMakeSel" id="addMakeSel" class="form-control mb-2">						
											<!--Display all specs from the resultset.-->						
											@if(isset($makes))
    											@foreach($makes as $row)													
    												<option value="{{$row->mach_make}}"
    													@if(isset($addMakeSel))
    														@if($row->mach_make == $addMakeSel)
    															selected
    														@endif
    													@endif
    												>{{$row->mach_make}}</option>
    											@endforeach
    										@endif
										</select>
									</td>
									<td><input type="text" class="form-control" name="model" id="model" value="{{isset($specs->model) ? $specs->model : ''}}"/></td>
									<td><input type="text" class="form-control" name="features" id="features" value="{{isset($specs->features) ? $specs->features : ''}}"/></td>
									<td><input type="text" class="form-control" name="min_speed" id="min_speed" value="{{isset($specs->min_speed) ? $specs->min_speed : ''}}"/></td>
									<td><input type="text" class="form-control" name="max_speed" id="max_speed" value="{{isset($specs->max_speed) ? $specs->max_speed : ''}}"/></td>
									<td><input type="text" class="form-control" name="machine_image" id="machine_image" value="{{isset($specs->machine_image) ? $specs->machine_image : ''}}"/></td>
									<td><input type="text" class="form-control" name="intro" id="intro" value="{{isset($specs->intro) ? $specs->intro : ''}}"/></td>
									<td><input type="text" class="form-control" name="life" id="life" value="{{isset($specs->life) ? $specs->life : ''}}"/></td>
									<td><input type="text" class="form-control" name="is_color" id="is_color" value="{{isset($specs->is_color) ? $specs->is_color : ''}}"/></td>
									<td><input type="text" class="form-control" name="created_date" id="created_date" value="{{isset($specs->created_date) ? $specs->created_date : ''}}"/></td>
								</tr>
							</tbody>
						</table>
							
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<!--<a href="{{route('machine_specs.create')}}" class="btn btn-sm btn-primary center mx-3">Add Specification</a>
						<a href="index" class="btn btn-sm btn-primary center">Edit Specification</a>-->
                    	<button type="submit" class="btn btn-success btn-sm m-2">{{isset($specs) ? 'Update Record' : 'Add Specification'}}</button>
					   <a href="{{route('machine_specs.index')}}" class="btn btn-danger btn-sm m-2">Cancel</a>
					</div><!--end form-group-->
					
					</form>
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->	
	
</main><!--end my-3-->


@endsection