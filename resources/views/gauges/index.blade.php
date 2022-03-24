@extends('layouts.app')

@section('content')

<div class="col-xl-4 float-right">		
	<div id="panel-1" class="panel">
		<div class="panel-hdr">
			<div class="panel-content table-responsive">
				<h5>Data Totals</h5>
			</div>
		</div><!--end panel-hdr-->
		
		<div class="panel-container show">
			<div class="panel-content">
				<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
					<tr>
						<td>Total Contract Devices:
						</td>
                    <td>
						</td>
					</tr>
					<tr>
						<td>Contract Devices Reporting:
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td>Devices Not Reporting<span style="color:red;">*</span>:
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td>Devices W/Toner Alert:
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td>Devices W/Service Needed:
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td>Non-Contracted Devices:
						</td>
						<td>
						</td>
					</tr>
					<tr>
						<td>Last Synch Date:
						</td>
						<td>
						</td>
					</tr>
				</table>
				
				<div style="color:red;">
					*Not reporting for 15 days.
				</div>
				
				<div class="btn-group my-2">
					<a href="index" class="btn btn-sm btn-primary center">View Device Listing</a>
				</div>
				
			</div><!--end panel-content-->
		</div><!--endpanel-container show-->		
	</div><!--end panel-1-->
</div><!--end col-xl-4-->


<div style="float-left">
	<div class="row col-xl-8">
		<div class="col-xl-3">
        
        	
			<form action="{{isset($org_id) ? route('gauges.show', $org_id) : route('gauges.index')}}" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
			@csrf
				<div class="container-fluid">
					<div class="d-flex my-3">
						<div class="form-group">
							<label for="orgSel">Organization</label>					

							<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('gauges', this.value)"> <!--page_direct('gauges', this.value)-->
								<option>Select an Org</option>
								<!--Display all orgs from the resultset.-->						
								@if(isset($orgs))
									@foreach($orgs as $row)
										
										<option value="{{$row->id}}"
											@if(isset($org_id))
												@if($row->id == $org_id)
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
		</div><!--end col-xl-3-->


		<div class="col-xl-3">			
				<div class="container-fluid">
					<div class="d-flex my-3">
						<div class="form-group">
							<label for="colSel">Select a Color</label>					

							<select name="colSel" id="colSel" class="form-control mb-2" onchange="this.form.submit()">
								<option value="">Select a Color</option>
								<option value="both">Both</option>
								<option value="black">Black</option>
								<option value="color">Color</option>							
							</select>
						</div><!--end form-group-->						
					</div><!--end d-flex-->
				</div><!--container-fluid-->			
		</div><!--end col-xl-3-->
    
    	<div class="col-xl-3">
			
           
				<div class="container-fluid">
					<div class="d-flex my-3">
						<div class="form-group">
							<label for="yearSel">Select a Year</label>					

							<select name="yearSel" id="yearSel" class="form-control mb-2" onchange="this.form.submit()">
								<option value="">Select a Year</option>
                            	<!--Display all orgs from the resultset.-->						
								@if(isset($years))
									@foreach($years as $row)
										
										<option value="{{$row->id}}"
											@if(isset($year))
												@if($row->id == $year)
													selected
												@endif
											@endif
										>{{$row->school_year}}</option>
									@endforeach
								@endif                            
                            							
							</select>
						</div><!--end form-group-->						
					</div><!--end d-flex-->
				</div><!--container-fluid-->			
		</div><!--end col-xl-3-->
    
	
		<div class="col-xl-3">		
				<div class="container-fluid">
					<div class="d-flex my-3">
						<div class="form-group">
							<label for="dateSel">Select Timeline Date</label>					

							<select name="dateSel" id="dateSel" class="form-control mb-2" onchange="this.form.submit()">
								<option value="">Select a Date</option>
								<option value="this date">this date</option>
								<option value="that date">that date</option>
								<option value="another date">another date</option>							
							</select>
						</div><!--end form-group-->						
					</div><!--end d-flex-->
				</div><!--container-fluid-->
			</form>
		</div><!--end col-xl-3-->
	</div><!--end row-->

	
	<div class="row col-xl-8">
		<div class="col-xl-4">		
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<div class="panel-content">
						<h5>Annual Black</h5>
					</div>
				</div>
				
				<div class="panel-container show">
					<div class="panel-content table-responsive">
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<tr>
								<td>Consumed:
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td>Budgeted:
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td>Projected:
								</td>
								<td>
								</td>
							</tr>
						</table>
					</div>
				</div>				
			</div><!--end panel-1-->
		</div><!--end col-xl-4-->
		
		<div class="col-xl-4">		
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<div class="panel-content table-responsive">
						<h5>Annual Color</h5>
					</div>
				</div>
				
				<div class="panel-container show">
					<div class="panel-content table-responsive">
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<tr>
								<td>Consumed:
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td>Budgeted:
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td>Projected:
								</td>
								<td>
								</td>
							</tr>
						</table>
					</div>
				</div>			
			</div><!--end panel-1-->
		</div><!--end col-xl-4-->


		<div class="col-xl-4">		
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<div class="panel-content">
						<h5>Request History</h5>
					</div>
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<p>
							When was the last time you had a vendor do a service history on your account?
						</p>
						<div class="btn-group my-3">
							<a href="index" class="btn btn-sm btn-primary center">Request Org Service History</a>
						</div>
					</div>
				</div>			
			</div><!--end panel-1-->
		</div><!--end col-xl-4-->
	</div><!--end row col-xl-8-->
<main id="js-page-content" >






	@if(isset($bldgs))
		
		{{--Count the gauges because only 4 will fit in each row--}}
		@php
			$gaugeCount = 0;
		@endphp
		<div class="container-responsive gaugeDiv row col-xl-8">
			<div class="row gaugeRow col-xl-12 mb-4">
		
        	@foreach($bldgs as $row)
            	@php
                	$gaugeCount += 1;
            	@endphp
			
				<div class="gaugeBox" style="width:25%; text-align:center; float:left;"><!--{{$row->bldg_name}}-->
            		<div style="height:35px; text-align:center;">{{$row->bldg_name}}</div>
			
					@if(isset($fp_data))
						<canvas id ="coltest"
							data-type="radial-gauge"
							data-width="175"
							data-height="175"
							data-units="%"
							data-title="Color"						
							
							data-value=
								@if(isset($fp_data))
									"{{$fp_data}}"
								@endif
							data-min-value="0"
							data-max-value="200"
							data-major-ticks="0,20,40,60,80,100,120,140,160,180,200"
							data-minor-ticks="2"
							data-stroke-ticks="false"						
							
							data-highlights='[
								{ "from": 0, "to": 50, "color": "rgba(0,255,0,.50)" },
								{ "from": 50, "to": 100, "color": "rgba(255,255,0,.50)" },
								{ "from": 100, "to": 150, "color": "rgba(255,30,0,.50)" },
								{ "from": 150, "to": 200, "color": "rgba(255,0,225,.50)" },
								{ "from": 200, "to": 220, "color": "rgba(0,0,255,.50)" }
							]'
							data-color-plate="#000099"
							data-color-major-ticks="#f5f5f5"
							data-color-minor-ticks="#ddd"
							data-color-title="#fff"
							data-color-units="#ccc"
							data-color-numbers="#eee"
							data-color-needle-start="rgba(240, 128, 128, 1)"
							data-color-needle-end="rgba(255, 160, 122, .9)"
							data-value-box="true"
							data-animation-rule="bounce"
							data-animation-duration="1500"
							data-font-value="Led"
							data-animated-value="true"		
						></canvas>					
					@endif
                
                	<div style="height:18px; text-align:center;"><a href="{{route('floorplan_diagrams.show', $row->id)}}">Go to Live Floorplan</a></div>
				</div><!--end gaugeBox-->
		
			@if($gaugeCount == 4)
				@php
					$gaugeCount = 0;
				@endphp
				</div><!--end gaugeRow-->
        
        		<!--Add an empty div for horiz spacing-->
        		<div style="width:100%; height:2%;"><br></div>
				<div class="row gaugeRow col-xl-12 mb-4 pt4">
                
                	                	
			@endif
	
		@endforeach
		</div><!--end gaugeRow-->
	</div><!--end gaugeDiv-->
</div><!--end float-left-->		
	@endif
	<!--<div class="row my-9" style="margin-top:25px;">

		<div style="width:25%; text-align:center; float:left;">Elm Street School
			<canvas data-type="radial-gauge"
					data-width="100"
					data-height="100"
					data-units="Km/h"
					data-title="Color"
					data-value="60"
					data-min-value="0"
					data-max-value="200"
					data-major-ticks="0,20,40,60,80,100,120,140,160,180,200"
					data-minor-ticks="2"
					data-stroke-ticks="false"
					data-highlights='[
						{ "from": 0, "to": 50, "color": "rgba(0,255,0,.30)" },
						{ "from": 50, "to": 100, "color": "rgba(255,255,0,.30)" },
						{ "from": 100, "to": 150, "color": "rgba(255,30,0,.30)" },
						{ "from": 150, "to": 200, "color": "rgba(255,0,225,.30)" },
						{ "from": 200, "to": 220, "color": "rgba(0,0,255,.30)" }
					]'
					data-color-plate="#222"
					data-color-major-ticks="#f5f5f5"
					data-color-minor-ticks="#ddd"
					data-color-title="#fff"
					data-color-units="#ccc"
					data-color-numbers="#eee"
					data-color-needle-start="rgba(240, 128, 128, 1)"
					data-color-needle-end="rgba(255, 160, 122, .9)"
					data-value-box="true"
					data-animation-rule="bounce"
					data-animation-duration="1500"
					data-font-value="Led"
					data-animated-value="true"
			></canvas>
			<br><a href="www.spcstardoc.com">Go to Live Floorplan</a>
		</div>


		<div style="width:25%; text-align:center; float:left;">Huot Tech Center
			<canvas data-type="radial-gauge"
					data-width="100"
					data-height="100"
					data-units="Km/h"
					data-title="Black"
					data-value="80"
					data-min-value="0"
					data-max-value="200"
					data-major-ticks="0,20,40,60,80,100,120,140,160,180,200"
					data-minor-ticks="2"
					data-stroke-ticks="false"
					data-highlights='[
						{ "from": 0, "to": 50, "color": "rgba(0,255,0,.15)" },
						{ "from": 50, "to": 100, "color": "rgba(255,255,0,.15)" },
						{ "from": 100, "to": 150, "color": "rgba(255,30,0,.25)" },
						{ "from": 150, "to": 200, "color": "rgba(255,0,225,.25)" },
						{ "from": 200, "to": 220, "color": "rgba(0,0,255,.25)" }
					]'
					data-color-plate="#999999" //222
					data-color-major-ticks="#f5f5f5"
					data-color-minor-ticks="#ddd"
					data-color-title="#fff"
					data-color-units="#ccc"
					data-color-numbers="#eee"
					data-color-needle-start="rgba(240, 128, 128, 1)"
					data-color-needle-end="rgba(255, 160, 122, .9)"
					data-value-box="true"
					data-animation-rule="bounce"
					data-animation-duration="1500"
					data-font-value="Led"
					data-animated-value="true"
			></canvas>
			<br><a href="www.spcstardoc.com">Go to Live Floorplan</a>
		</div>


		<div style="width:25%; text-align:center; float:left;">Huot Tech Center
			<canvas id ="coltest"
					data-type="radial-gauge"
					data-width="100"
					data-height="100"
					data-units="%"
					data-title="Black"
					data-value="95"
					data-min-value="0"
					data-max-value="200"
					data-major-ticks="0,20,40,60,80,100,120,140,160,180,200"
					data-minor-ticks="2"
					data-stroke-ticks="false"
					data-highlights='[
						{ "from": 0, "to": 50, "color": "rgba(0,255,0,.50)" },
						{ "from": 50, "to": 100, "color": "rgba(255,255,0,.50)" },
						{ "from": 100, "to": 150, "color": "rgba(255,30,0,.50)" },
						{ "from": 150, "to": 200, "color": "rgba(255,0,225,.50)" },
						{ "from": 200, "to": 220, "color": "rgba(0,0,255,.50)" }
					]'
					data-color-plate="#000099"
					data-color-major-ticks="#f5f5f5"
					data-color-minor-ticks="#ddd"
					data-color-title="#fff"
					data-color-units="#ccc"
					data-color-numbers="#eee"
					data-color-needle-start="rgba(240, 128, 128, 1)"
					data-color-needle-end="rgba(255, 160, 122, .9)"
					data-value-box="true"
					data-animation-rule="bounce"
					data-animation-duration="1500"
					data-font-value="Led"
					data-animated-value="true"		
			></canvas>
			<br><a href="www.spcstardoc.com">Go to Live Floorplan</a>
		</div>
	</div>end row
	
	<div style="margin-top:200px; margin-left: 200px;"><div>

		<canvas data-type="radial-gauge"
				data-width="100"
				data-height="100"
				data-units="Km/h"
				data-title="Black"
				data-value="50"
				data-min-value="0"
				data-max-value="200"
				data-major-ticks="0,20,40,60,80,100,120,140,160,180,200"
				data-minor-ticks="2"
				data-stroke-ticks="false"
				data-highlights='[
					{ "from": 0, "to": 50, "color": "rgba(0,255,0,.15)" },
					{ "from": 50, "to": 100, "color": "rgba(255,255,0,.15)" },
					{ "from": 100, "to": 150, "color": "rgba(255,30,0,.25)" },
					{ "from": 150, "to": 200, "color": "rgba(255,0,225,.25)" },
					{ "from": 200, "to": 220, "color": "rgba(0,0,255,.25)" }
				]'
				data-color-plate="#222"
				data-color-major-ticks="#f5f5f5"
				data-color-minor-ticks="#ddd"
				data-color-title="#fff"
				data-color-units="#ccc"
				data-color-numbers="#eee"
				data-color-needle-start="rgba(240, 128, 128, 1)"
				data-color-needle-end="rgba(255, 160, 122, .9)"
				data-value-box="true"
				data-animation-rule="bounce"
				data-animation-duration="1500"
				data-font-value="Led"
				data-animated-value="true"
		></canvas>

</div>
</div>--><!--end my-3 mx-3-->



</main>		


@endsection