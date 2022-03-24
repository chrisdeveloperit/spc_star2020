@extends('layouts.app')

<!--buildings/create.blade-->

@section('content')
<div class="my-3 mx-3">	
    <!--SJH added 3/20/22 - - need to test this more.-->
    @if($errors->any())
		<div class="alert alert-danger">
			<ul class="list-group">
				@foreach($errors->all() as $error)
					<li class="list-group-item  text-danger">
						{{$error}}
					</li>
				@endforeach
			</ul>
		</div><!--end alert-->
	@endif	
</div><!--end my-3 mx-3-->

		
		
<main id="js-page-content" class="my-3 mx-3">
	<div class="row">
		<div class="col-xl-12">
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<h2>						
                        {{isset($buildings) ? 'Update the Building Record for This Organization' : 'Create a Building Record for a Specific Organization'}}
					</h2>
					
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<div class="panel-tag">
							Create a building record for a specific organization. <strong>Note: </strong>Some data is required to create
								a building record. Your entry will not be submitted without the required data. This is to maintain the integrity
								of the data.
						</div>
						
						<form action="{{isset($buildings) ? route('buildings.update', $buildings->bldg_id) : route('buildings.store')}}" method="post" enctype="multipart/form-data"> <!--enctype needed for image upload-->
						@csrf
                            @if(isset($buildings))
                                @method('PUT')
                            @endif
						
						<!-- datatable Building Data start -->
						<table id="building_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($buildings) ? 'Update Building Data' : 'Create Building Data'}}</div>
									</th>
								</tr>
							
								<tr>									
									@if(isset($buildings))
									    <th>Building ID</th>
									@endif
									<th>Organization</th>
									<th>Building Name</th>
									<th>Building Name Short</th>
									<!--<th>Building Contact</th>-->
									<th>Student Pop</th>
									<th>Bldg Equip Costs</th>
									<th>Notes</th>
								</tr>
							</thead>
							<tbody>
								<tr>										
									@if(isset($buildings))
                                    	<!--only display the bldgId text box if this is an update. The ID is auto incremented-->
                                    	<td>
                                        	<input type="text" class="form-control" name="bldgId" id="bldgId"  readonly="readonly" value="{{isset($buildings->bldg_id) ? $buildings->bldg_id : ''}}"/>
                                    	</td>
                                	@endif
                                	
									
                                	<td>
										<select name="organizations_id" id="organizations_id" class="form-control mb-2">						
											<!--Display all orgs from the resultset.-->						
											@foreach($orgs as $row)													
												<option value="{{$row->org_id}}"
													@if(isset($id))
														@if($row->org_id == $id)
															selected
														@endif
													@endif
												>{{$row->org_name}}</option>
											@endforeach												
										</select>
									</td>
									<td><input type="text" class="form-control" name="bldg_name" id="bldg_name" value="{{isset($buildings->bldg_name) ? $buildings->bldg_name : ''}}"/></td>
									<td><input type="text" class="form-control" name="bldgNameShort" id="bldgNameShort" value="{{isset($buildings->bldg_name_short) ? $buildings->bldg_name_short : ''}}"/></td>
									<!--<td><input type="text" class="form-control" name="bldgContact" id="bldgContact" value="{{isset($buildings->bldg_contact_id) ? $buildings->bldg_contact_id : ''}}"/></td>-->
									<td><input type="text" class="form-control" name="studentPop" id="studentPop" value="{{isset($buildings->student_pop) ? $buildings->student_pop : ''}}"/></td>
									<td><input type="text" class="form-control" name="equipCost" id="equipCost" value="{{isset($buildings->bldg_equip_cost) ? $buildings->bldg_equip_cost : ''}}"/></td>
									<td><input type="text" class="form-control" name="bldgNotes" id="bldgNotes" value="{{isset($buildings->notes) ? $buildings->notes : ''}}"/></td>
								</tr>
							</tbody>
						</table>
							
						<table id="address_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($buildings) ? 'Update Address Data' : 'Create Address Data'}}</div>
									</th>
								</tr>
							
								<tr>									
									<th>Address Type</th>
									<th>Address</th>
									<th>Address2</th>
									<th>City</th>
									<th>State</th>
									<th>Zip</th>
									<th>County</th>
								</tr>
							</thead>
							<tbody>
								<tr>										
									<td>
										<select name="addrType" id="addrType" class="form-control mb-2">
											<option value="M">Mailing</option>
											<option value="L">Legal</option>
										</select>
									</td>
									<td><input type="text" class="form-control" name="address" id="address"></td>
									<td><input type="text" class="form-control" name="address2" id="address2"></td>
									<td><input type="text" class="form-control" name="city" id="city"></td>
									<td>
										<select name="state" id="state" class="form-control mb-2" >
											<option value="ME">Maine</option>
											<option value="NH">New Hampshire</option>												
										</select>
									</td>
									<td><input type="text" class="form-control" name="zip" id="zip"></td>
									<td><input type="text" class="form-control" name="county" id="county"></td>
								</tr>
								
								<tr>										
									<td>
										<select name="addrType_2" id="addrType_2" class="form-control mb-2">
											<option value="M">Mailing</option>
											<option value="L">Legal</option>
										</select>
									</td>
									<td><input type="text" class="form-control" name="address_2" id="address_2"></td>
									<td><input type="text" class="form-control" name="address2_2" id="address2_2"></td>
									<td><input type="text" class="form-control" name="city_2" id="city_2"></td>
									<td>
										<select name="state_2" id="state_2" class="form-control mb-2" >
											<option value="ME">Maine</option>
											<option value="NH">New Hampshire</option>												
										</select>
									</td>
									<td><input type="text" class="form-control" name="zip_2" id="zip_2"></td>
									<td><input type="text" class="form-control" name="county_2" id="county_2"></td>
								</tr>
							</tbody>
						</table>
							
						<table id="phone_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($buildings) ? 'Update Phone Data' : 'Create Phone Data'}}</div>
									</th>
								</tr>
							
								<tr>									
									<th>Phone Type</th>
									<th>Area Code</th>
									<th>Exchange</th>
									<th>Phone Line</th>
									<th>Extension</th>
								</tr>
							</thead>
							
							<tbody>
								<tr>										
									<td>
										<select name="phType" id="phType" class="form-control mb-2">
											<option value="M">Main</option>
											<option value="F">Fax</option>
											<option value="C">Cell</option>
										</select>
									</td>
									<td><input type="text" class="form-control" name="areaCode" id="areaCode"></td>
									<td><input type="text" class="form-control" name="exchange" id="exchange"></td>
									<td><input type="text" class="form-control" name="phLine" id="phLine"></td>
									<td><input type="text" class="form-control" name="extension" id="extension"></td>																				
								</tr>
									
								<tr>										
									<td>
										<select name="phType_2" id="phType_2" class="form-control mb-2">
											<option value="M">Main</option>
											<option value="F">Fax</option>
											<option value="C">Cell</option>
											<option value="A">Additional</option>
										</select>
									</td>
									<td><input type="text" class="form-control" name="areaCode_2" id="areaCode_2"></td>
									<td><input type="text" class="form-control" name="exchange_2" id="exchange_2"></td>
									<td><input type="text" class="form-control" name="phLine_2" id="phLine_2"></td>
									<td><input type="text" class="form-control" name="extension_2" id="extension_2"></td>
								</tr>
							</tbody>
						</table>
						
						
						<!-- datatable Building Contact Data start -->
						<table id="building_contact_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($buildings) ? 'Update Building Contact Data' : 'Create Building Contact Data'}}</div>
									</th>
								</tr>
							
								<tr>									
									@if(isset($buildings))
									    <th>Contact ID</th>
									@endif
									
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>Job Title</th>
									<th>Notes</th>
									<th>StarDOC User ID</th>
									<th>Email Group ID</th>
								</tr>
							</thead>
							<tbody>
								<tr>										
									@if(isset($buildings))
                                    	<!--only display the bldgId text box if this is an update. The ID is auto incremented-->
                                    	<td>
                                        	<input type="text" class="form-control" name="contactId" id="contactId"  readonly="readonly" value="{{isset($buildings->contacts_id) ? $buildings->contacts_id : ''}}"/>
                                    	</td>
                                	@endif
                                	
									<td><input type="text" class="form-control" name="firstName" id="firstName" value="{{isset($contacts->first_name) ? $contacts->first_name : ''}}"/></td>
									<td><input type="text" class="form-control" name="lastName" id="lastName" value="{{isset($contacts->last_name) ? $contacts->last_name : ''}}"/></td>
									<td><input type="text" class="form-control" name="email" id="email" value="{{isset($contacts->email) ? $contacts->email : ''}}"/></td>
									<td><input type="text" class="form-control" name="jobTitle" id="jobTitle" value="{{isset($contacts->org_job_title) ? $contacts->org_job_title : ''}}"/></td>
									<td><input type="text" class="form-control" name="contactNotes" id="contactNotes" value="{{isset($contacts->notes) ? $contacts->notes : ''}}"/></td>
									<td><input type="text" class="form-control" name="stardocId" id="stardocId" value="{{isset($contacts->stardoc_user_id) ? $contacts->stardoc_user_id : ''}}"/></td>
									<td><input type="text" class="form-control" name="emailGroupId" id="emailGroupId" value="{{isset($contacts->email_group_id) ? $contacts->email_group_id : ''}}"/></td>
								</tr>
							</tbody>
						</table>
						
						
						
						
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">
					    
					    
					    
					    			
						<!--<a href="{{route('buildings.create')}}" class="btn btn-sm btn-primary center mx-3">Add Building</a>
						<a href="index" class="btn btn-sm btn-primary center">Edit Building</a>-->
                    	<button type="submit" class="btn btn-success btn-sm m-2">{{isset($buildings) ? 'Update Record' : 'Add Building'}}</button>
					   <a href="{{route('buildings.index')}}" class="btn btn-danger btn-sm m-2">Cancel</a>
					</div><!--end form-group-->
					
					</form>
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->	
	
</main><!--end my-3-->


@endsection