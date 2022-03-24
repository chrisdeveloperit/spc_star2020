@extends('layouts.app')

<!--org_contacts/create.blade.php-->
@section('content')
<div class="my-3 mx-3">
	
</div><!--end my-3 mx-3-->		
		
<main id="js-page-content" class="my-3 mx-3">
		
	<div class="row">
		<div class="col-xl-12">
			<div id="panel-1" class="panel">
				<div class="panel-hdr">
					<h2>
						Authorized Users <span class="fw-300"><i>For this org</i></span>
					</h2>
					
					<div class="panel-toolbar">
						<button class="btn btn-primary btn-sm" data-toggle="dropdown">Table Style</button>
						<div class="dropdown-menu dropdown-menu-animated dropdown-menu-right position-absolute pos-top">
							<button class="dropdown-item active" data-action="toggle" data-class="table-bordered" data-target="#dt-basic-example"> Bordered Table </button>
							<button class="dropdown-item" data-action="toggle" data-class="table-sm" data-target="#dt-basic-example"> Smaller Table </button>
							<button class="dropdown-item" data-action="toggle" data-class="table-dark" data-target="#dt-basic-example"> Table Dark </button>
							<button class="dropdown-item active" data-action="toggle" data-class="table-hover" data-target="#dt-basic-example"> Table Hover </button>
							<button class="dropdown-item active" data-action="toggle" data-class="table-stripe" data-target="#dt-basic-example"> Table Stripped </button>
							<div class="dropdown-divider m-0"></div>							
						</div>
					</div><!--end panel-toolbar-->
				</div><!--end panel-header-->
				
				<div class="panel-container show">
					<div class="panel-content table-responsive">
						<div class="panel-tag">
							<!--In order to create a new contact for an organization, a building <strong>MUST</strong> be selected. If the building that the new contact will be associated with
								does not appear in the dropdown, the building needs to be added BEFORE adding the contact. If this is the case, please click the <i>Add Building</i>
								button below.<strong>-->
								It is not required to select a building when creating a contact, however if the contact is specific to a building, the
								building name should be selected at this time.
						</div><!--end panel-tag-->
						
						
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
						
						
						<form action="{{isset($org_contact) ? route('org_contacts.update', $org_contact->contact_id) : route('org_contacts.store')}}" method="post">
						@csrf
						@if(isset($org_contact))
							@method('PUT')
						@endif
						
    						<!-- datatable start -->
    						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
    							<thead class="myTabHead"> <!--replaced bg-fusion-50 (dark gray color)with myTabHead for custom styling-->							
    								<tr>
    									<th colspan="11" class="pt-3 pb-2 pl-3 pr-3 text-center">
    										<div class="js-get-date h5 mb-2">[your date here]</div>
    									</th>
    								</tr>
    							
    								<tr>
    								    @if(isset($org_contacts))
    									    <th>Contact ID</th>
    									@endif
    									
    									<th>Building</th>
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
    									@if(isset($org_contacts))
    									    <td>
    									        <input type="text" name="contactId" id="contactId" value="{{isset($org_contact->contact_id) ? $org_contact->contact_id : ''}}"/>
    									    </td>
    									@endif
    									
        									<td>										
        										<select name="bldgSel" id="bldgSel" class="form-control mb-2">
        											<option>Select a Building</option>
        											    @if (isset($buildings))
            												@foreach($buildings as $bldg)
            													<!--Display all buildings from the resultset.-->														
            													<option value="{{$bldg->bldg_id}}"
            														@if(isset($org_contact))
            															@if($bldg->bldg_id == $org_contact->buildings_id)
            																selected
            															@endif
            														@endif
            														>{{$bldg->bldg_name}}
            													</option>													
            												@endforeach
        												@endif
        																							
        										</select>											
        									</td>
    									
    									
    									<td><input type="text" name="firstName" id="firstName" value="{{isset($org_contact->first_name) ? $org_contact->first_name : ''}}"/></td>
    									<td><input type="text" name="lastName" id="lastName" value="{{isset($org_contact->last_name) ? $org_contact->last_name : ''}}" /></td>
    									<td><input type="text" name="email" id="email" value="{{isset($org_contact->email) ? $org_contact->email : ''}}" /></td>
    									<td><input type="text" name="jobTitle" id="jobTitle" value="{{isset($org_contact->org_job_title) ? $org_contact->org_job_title : ''}}"/></td>
    									<td><input type="text" name="contactNotes" id="contactNotes" value="{{isset($org_contact->notes) ? $org_contact->notes : ''}}" /></td>
    									<td><input type="text" name="stardocId" id="stardocId" value="{{isset($org_contact->stardoc_user_id) ? $org_contact->stardoc_user_id : ''}}" /></td>
    									
    									<td>										
        								<select name="emailGroupSel" id="emailGroupSel" class="form-control mb-2">
        									@if (isset($email_groups))
    											@foreach($email_groups as $row)
    												<!--Display all email_groups from the resultset.-->														
    												<option value="{{$row->email_grp_id}}"
    													@if(isset($org_contact))
    														@if($row->email_grp_id == $org_contact->email_grp_id)
    															selected
    														@endif
    													@endif
    													>{{$row->email_group_title}}
    												</option>													
    											@endforeach
    										@endif
										</select>
    									
    									<!--<td>										
    										<select name="toner_alert" id="toner_alert" class="form-control mb-2">											
    																									
    											<option value="N">Select Y/N</option>
    											<option value="Y">Yes</option>
    											<option value="N">No</option>																							
    										</select>											
    									</td>
    									
    									<td>										
    										<select name="service_alert" id="service_alert" class="form-control mb-2">											
    																									
    											<option value="N">Select Y/N</option>
    											<option value="Y">Yes</option>
    											<option value="N">No</option>																							
    										</select>											
    									</td>
    									
    									<td>										
    										<select name="audit_reports" id="audit_reports" class="form-control mb-2">											
    																								
    											<option value="N">Select Y/N</option>
    											<option value="Y">Yes</option>
    											<option value="N">No</option>																							
    										</select>											
    									</td>-->
    									
    																			
    								</tr>								
    							</tbody>			
						    </table><!-- end datatable -->
						
						<div class="btn-group my-3">			
    						<button type="submit" class="btn btn-success btn-sm m-2">{{isset($org_contacts) ? 'Update Contact' : 'Add Contact'}}</button>
    						<a href="{{route('org_contacts.index')}}" class="btn btn-danger btn-sm m-2">Cancel</a>
    					</div><!--end btn-group-->
					</form>
					</div><!-- end panel-content table-responsive -->
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->
		</div><!--end col-xl-12-->
	</div><!--end row-->
</main><!--end my-3-->
	
@endsection