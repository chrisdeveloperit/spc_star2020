@extends('layouts.app')

@section('content')

<main id="js-page-content" >
	<div class="col-xl-7 float-right">		
		<div id="panel-1" class="panel">
			<div class="panel-hdr">
				<div class="panel-content table-responsive">
					<h5>Floorplan Data</h5>
				</div>
			</div>
			<div class="panel-container show">
				<div class="panel-content">
					<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
						<thead>
							<th>ID</th>
							<th>Color</th>
							<th>Room</th>
							<th>Make</th>
							<th>Model</th>
							<th>Connectivity</th>
						</thead>
						
						<tr>
							<td>1</td>
							<td>color icon</td>										
							<td>Principal's Office</td>						
							<td>Canon</td>						
							<td>LBP5460</td>						
							<td>Networked</td>						
						</tr>
					</table>				
					
				</div><!--end panel-content-->
			</div><!--end panel-container show-->		
		</div><!--end panel-1-->
	</div><!--end col-xl-7-->


	<div style="float-left">
		<div class="row col-xl-5">
			<div class="col-xl-5">
				<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
				@csrf
					<div class="container-fluid">
						<div class="d-flex my-3">
							<div class="form-group">
								<label for="orgSel">Organization</label>					

								<select name="orgSel" id="orgSel" class="form-control mb-2" style="min-width:200px;" onchange="page_direct('buildings', this.value)">
									<option>Select an Organization</option>
									<!--Display all orgs from the resultset.-->						
									@if(isset($orgs))
										@foreach($orgs as $row)
											
											<option value="{{$row->id}}"
												@if(isset($bldgs))
													@if($bldgs[0]->organizations_id == $row->id)
														selected
													@endif
												@endif
											>{{$row->org_name}}</option>
										@endforeach
									@endif
										
								</select>
							</div><!--end form-group-->						
						</div><!--end d-flex-->
					</div><!--container-fluid-->
				</form>
			</div><!--end col-xl-5-->
		</div><!--end row-->
	
		<div class="row col-xl-5">
			<div class="col-xl-8">
				<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
				@csrf
					<div class="container-fluid">
						<div class="d-flex my-6">
							<div class="form-group">
								<label for="colSel">Building</label>					

								<select name="orgSel" id="orgSel" style="min-width:170px;" class="form-control mb-2">
									<option value="">Select a Building</option>
									@if(isset($bldgs))
										@foreach($bldgs as $row)
											
											<option value="{{$row->bldg_id}}"
												@if(isset($bldg_id))
													@if($row->bldg_id == $bldg_id)
														selected
													@endif
												@endif
											>{{$row->bldg_name}}</option>
										@endforeach
									@endif							
								</select>
							</div><!--end form-group-->						
						</div><!--end d-flex-->
					</div><!--container-fluid-->
				</form>
			</div><!--end col-xl-7-->
		
			<div class="col-xl-4">
				<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
				@csrf
					<div class="container-fluid">
						<div class="d-flex my-6">
							<div class="form-group">
								<label for="colSel">Floor/Wing</label>					

								<select name="floorSel" id="floorSel" style="min-width:130px;" class="form-control mb-2">
									<option value="">Select Floor</option>
									@if(isset($floors))
										@foreach($floors as $row)
											
											<option value="{{$row->floor_number}}"
												@if(isset($data))
													@if($row->floor_number == $data->floor_number)
														selected
													@endif
												@endif
											>{{$row->floor_number}}</option>
										@endforeach
									@endif								
								</select>
							</div><!--end form-group-->						
						</div><!--end d-flex-->
					</div><!--container-fluid-->
				</form>
			</div><!--end col-xl-3-->
		</div><!--end row-->
	</div><!--end float left-->
	
	<div class="row col-xl-12">
		<div id="panel-1" class="panel">
			<!--<div class="panel-hdr">
				<div class="panel-content table-responsive">
					<h5>Floorplan Data</h5>
				</div>
			</div>-->
			<div class="panel-container show">
				<div class="panel-content">
					
					
					@if(isset($data))
						<img src="{{asset('images/' . $data->floorplan_image ?? '') }}" alt="{{'images/' . $data->floorplan_image}}">
						
					@else
						<img src="" alt="floorplan image">	
					@endif
						
						
					
					
				</div><!--end panel-content-->
			</div><!--end panel-container-->
		</div>
	</div><!--end row-->
</div><!--end main-->


@endsection