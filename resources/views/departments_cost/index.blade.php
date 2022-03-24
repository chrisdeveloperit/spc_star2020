@extends('layouts.app')

@section('content')

<div class="col-xl-4 float-right">		
	<div id="panel-1" class="panel">
		<div class="panel-hdr">
			<div class="panel-content table-responsive">
				<h5>Data Totals on Buildings Cost Page</h5>
			</div>
		</div><!--end panel-hdr-->
    
    
    	
		<div class="panel-container show">
			<div class="panel-content">
				<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
					<tr>
						<td>Total Contract Devices:
						</td>
                    <td><a href="">111,223</a>
						</td>
					</tr>
					<tr>
						<td>Contract Devices Reporting:
						</td>
						<td>111,223
						</td>
					</tr>
					<tr>
						<td>Devices Not Reporting<span style="color:red;">*</span>:
						</td>
						<td>111,223
						</td>
					</tr>
					<tr>
						<td>Devices W/Toner Alert:
						</td>
						<td>xxx
						</td>
					</tr>
					<tr>
						<td>Devices W/Service Needed:
						</td>
						<td>111,223
						</td>
					</tr>
					<tr>
						<td>Non-Contracted Devices:
						</td>
						<td>111,223
						</td>
					</tr>
					<tr>
						<td>Last Synch Date:
						</td>
						<td>05/08/2020xxx
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
        	
        		
        	
			<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
			@csrf
				<div class="container-fluid">
					<div class="d-flex my-3">
                    
                                        
                    
						<div class="form-group">
							<label for="orgSel">Orgxxx on Show Pg</label>					

							<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('buildings_cost.show', this.value)"> 
								<option>Select an Organization</option>
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
											@if(isset($year_id))
												@if($row->id == $year_id)
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
								<td id="consBlk" name="consBlk">@if(isset($org_id))
									{{$org_id}}
								@endif
								</td>
							</tr>
							<tr>
								<td>Budgeted:
								</td>
								<td id="bgtBlk">@if(isset($year_id))
									{{$year_id}}
								@endif
								</td>
							</tr>
							<tr>
								<td>Projected:
								</td>
								<td id="projBlk">@if(isset($request->selYear)) {{$request->selYear}} @endif
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
								<td>248,256
								</td>
							</tr>
							<tr>
								<td>Budgeted:
								</td>
								<td>404,104
								</td>
							</tr>
							<tr>
								<td>Projected:
								</td>
								<td>111,223
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
	<div class="panel-container show">
					<div class="panel-content table-responsive">
						<div class="panel-tag">
							This table shows costs by department.
						</div>
						
						<!-- datatable start -->
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> 							
								<tr>
									<th colspan="29" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="js-get-date h5 mb-2">[your date here]</div>
									</th>
								</tr>
							
								<tr>
									<th>Building Name</th>
									<th>Consumed Black (To Date)</th>
									<th>Budgeted Black (FY21)</th>
									<th>Projected Black (FY21)</th>
									<th>Avg Per Student</th>
									<th>Next Year's Black (FY22)</th>
									<th>Consumed Color (To Date)</th>
									<th>Budgeted Color (FY21)</th>
									<th>Projected Color (FY21)</th>									
									<th>Avg Per Student</th>
									<th>Next Year's Color (FY22)</th>
									<th>Go to Live Floorplan</th>									
									<th>Over/Under Budget</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Building Name</td>
									<td>Consumed Black (To Date)</td>
									<td>Budgeted Black (FY21)</td>
									<td>Projected Black (FY21)</td>
									<td>Avg Per Student</td>
									<td>Next Year's Black (FY22)</td>
									<td>Consumed Color (To Date)</td>
									<td>Budgeted Color (FY21)</td>
									<td>Projected Color (FY21)</td>									
									<td>Avg Per Student</td>
									<td>Next Year's Color (FY22)</td>
									<td>Go to Live Floorplan</td>									
									<td>Over/Under Budget</td>										
								</tr>																
								
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<a href="index" class="btn btn-sm btn-primary center mx-3">Add Organization</a>
						<a href="index" class="btn btn-sm btn-primary center">Edit Organization</a>			
					</div><!--end form-group-->
				</div><!-- end panel-container -->
	
</main>
@endsection