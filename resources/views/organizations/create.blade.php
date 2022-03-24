@extends('layouts.app')

<!--organizations/create.blade-->

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
                        {{isset($organizations) ? 'Update the Record for this Organization' : 'Create a new organization Record.'}}
					</h2>
					
				</div>
				<div class="panel-container show">
					<div class="panel-content">
						<div class="panel-tag">
							Create a record for a new organization. <strong>Note: </strong>Some data is required to create
								an organization record. Your entry will not be submitted without the required data. This is to maintain the integrity
								of the data.
						</div>
						
						<form action="{{isset($organizations) ? route('organizations.update', $organizations->org_id) : route('organizations.store')}}" method="post" enctype="multipart/form-data"> <!--enctype needed for image upload-->
						@csrf
                            @if(isset($organizations))
                                @method('PUT')
                            @endif
						
						<!-- datatable Organization Data start -->
						<table id="organization_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($organizations) ? 'Update Organization Data' : 'Create Organization Data'}}</div>
									</th>
								</tr>
							
								<tr>									
									@if(isset($organizations))
									    <th>Organization ID</th>
									@endif
									
									<th>Organization Name</th>
									<th>Org Short Name</th>
									<th>Organization Type</th>
									<th>Website</th>									
									<th>FM Audit<br>Client ID</th>
									<th>Commencement<br> Date</th>
									<th>Client Since</th>
									<th>Client Status</th>
								</tr>
							</thead>
							
							<tbody>
								<tr>										
									@if(isset($organizations))
                                    	<!--only display the bldgId text box if this is an update. The ID is auto incremented-->
                                    	<td>
                                        	<input type="text" class="form-control" name="orgId" id="orgId"  readonly="readonly" value="{{isset($organizations->org_id) ? $organizations->org_id : ''}}"/>
                                    	</td>
                                	@endif
                                	
                                	<td><input type="text" class="form-control" name="org_name" id="org_name" value="{{isset($organizations->org_name) ? $organizations->org_name : ''}}"/></td>
                                	<td><input type="text" class="form-control" name="orgShortName" id="orgShortName" value="{{isset($organizations->org_short_name) ? $organizations->org_short_name : ''}}"/></td>
                                	
                                	<td>
										<select name="organizations_type_id" id="organizations_type_id" class="form-control mb-2">						
											<!--Display all org_types from the resultset.-->						
											@if(isset($org_types))
    											@foreach($org_types as $row)													
    												<option value="{{$row->org_type_id}}"
    													@if(isset($org_type_id))
    														@if($row->org_type_id == $org_type_id)
    															selected
    														@endif
    													@endif
    												>{{$row->org_type_name}}</option>
    											@endforeach
    										@endif
										</select>
									</td>
                                	
                                	<td><input type="text" class="form-control" name="website" id="website" value="{{isset($organizations->website) ? $organizations->website : ''}}"/></td>
                                	<td><input type="text" class="form-control" name="fmaudit_client_id" id="fmaudit_client_id" value="{{isset($organizations->fmaudit_client_id) ? $organizations->fmaudit_client_id : ''}}"/></td>
									<td><input type="text" class="form-control" name="commencement_date" id="commencement_date" value="{{isset($organizations->commencement_date) ? $organizations->commencement_date : ''}}"/></td>
                                    <td><input type="text" class="form-control" name="client_since" id="client_since" value="{{isset($organizations->client_since) ? $organizations->client_since : ''}}"/></td>
                                	
                                	<td>
                                	    <select name="clientStatusSel" id="clientStatusSel" class="form-control mb-2">
    										<option value="A">Active</option>
    										<option value="I">Inactive</option>
    										<option value="N">NonActive???</option>
    										<option value="P">Prospective</option>
    									</select>
    								</td>
									
									
								
								</tr>
							</tbody>
						</table>
						
						
						<!--Address data block-->	
						<table id="address_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($organizations) ? 'Update Address Data' : 'Create Address Data'}}</div>
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
								
							<!--<tr>										
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
								</tr>-->
							</tbody>
						</table>
							
						
						<!--Phone data block-->
						<table id="phone_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($organizations) ? 'Update Phone Data' : 'Create Phone Data'}}</div>
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
						
						
						<!-- datatable Client Data start -->
						<table id="client_data_table" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
								<tr>
									<th colspan="13" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="h5 mb-2">{{isset($organizations) ? 'Update Client Data' : 'Create Client Data'}}</div>
									</th>
								</tr>
							
								<tr>									
									
									<th>Print Mgmt<br>Software Installed</th>
									<th>LENP Contract<br>Signed</th>
									<th>Display Meter Data</th>
									<!--<th>Meter Data Feed</th>-->
									<th>Client Logo</th>
									<th>GM Notes</th>
									<th>Org Message</th>
									<th>Bank Buyout</th>
									<th>SPC Service Fee</th>
									<th>Trade Out Deletion</th>
									<th>New Upgrade Date</th>
									<th>Temporarily Inactive</th>
								</tr>
							</thead>
							<tbody>
								<tr>										
									
									<td>
                                	    <select name="printMgmtSel" id="printMgmtSel" class="form-control mb-2">
    										<option value=""></option>
    										<option value="Y">Yes</option>
    										<option value="N">No</option>
    									</select>
    								</td>
    								
    								<td>
                                	    <select name="lenPSel" id="lenPSel" class="form-control mb-2">
    										<option value=""></option>
    										<option value="Y">Yes</option>
    										<option value="N">No</option>
    									</select>
    								</td>
    								
    								<td>
                                	    <select name="mtrDataSel" id="mtrDataSel" class="form-control mb-2">
    										<option value=""></option>
    										<option value="Y">Yes</option>
    										<option value="N">No</option>
    									</select>
    								</td>
									
									<!--<td><input type="text" class="form-control" name="printMgmt" id="printMgmt" value="{{isset($organizations->print_mgmt_software_installed) ? $organizations->print_mgmt_software_installed : ''}}"/></td>
									<td><input type="text" class="form-control" name="lenP" id="lenP" value="{{isset($organizations->lenp_contract_signed) ? $organizations->lenp_contract_signed : ''}}"/></td>
									<td><input type="text" class="form-control" name="mtrData" id="mtrData" value="{{isset($organizations->display_meter_data) ? $organizations->display_meter_data : ''}}"/></td>-->
									<td><input type="text" class="form-control" name="clientLogo" id="clientLogo" value="{{isset($organizations->client_logo) ? $organizations->client_logo : ''}}"/></td>
									<td><input type="text" class="form-control" name="gmNotes" id="gmNotes" value="{{isset($organizations->gm_notes) ? $organizations->gm_notes : ''}}"/></td>
									<td><input type="text" class="form-control" name="orgMsg" id="orgMsg" value="{{isset($organizations->org_message) ? $organizations->org_message : ''}}"/></td>
									<td><input type="text" class="form-control" name="bankBuy" id="bankBuy" value="{{isset($organizations->bank_buyout) ? $organizations->bank_buyout : ''}}"/></td>
									<td><input type="text" class="form-control" name="spcSvcFee" id="spcSvcFee" value="{{isset($organizations->spc_service_fee) ? $organizations->spc_service_fee : ''}}"/></td>
									<td><input type="text" class="form-control" name="tradeOut" id="tradeOut" value="{{isset($organizations->trade_out_deletion) ? $organizations->trade_out_deletion : ''}}"/></td>
									<td><input type="text" class="form-control" name="newUpgrade" id="newUpgrade" value="{{isset($organizations->new_upgrade_date) ? $organizations->new_upgrade_date : ''}}"/></td>
									<!--<td><input type="text" class="form-control" name="tempInactive" id="tempInactive" value="{{isset($organizations->temp_inactive) ? $organizations->temp_inactive : ''}}"/></td>-->
									
									<td>
                                	    <select name="tempInactiveSel" id="tempInactiveSel" class="form-control mb-2">
    										<option value="N">No</option>
    										<option value="Y">Yes</option>
    									</select>
    								</td>
								</tr>
							</tbody>
						</table>
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">
                    	<button type="submit" class="btn btn-success btn-sm m-2">{{isset($organizations) ? 'Update Record' : 'Add Organization'}}</button>
					    <a href="{{route('organizations.index')}}" class="btn btn-danger btn-sm m-2">Cancel</a>
					</div><!--end form-group-->
					
				</form>
			</div><!-- end panel-container -->
		</div><!-- end panel-1 -->	
	
</main><!--end my-3-->


@endsection