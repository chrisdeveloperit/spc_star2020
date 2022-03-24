@extends('layouts.app')


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
					</div>
				</div>
				<div class="panel-container show">
					<div class="panel-content table-responsive">
						<div class="panel-tag">
							In order to create a new contact for an organization, a building <strong>MUST</strong> be selected. If the building that the new contact will be associated with
								does not appear in the dropdown, the building needs to be added BEFORE adding the contact. If this is the case, please click the <i>Add Building</i>
								button below.<strong>
						</div>
						
						
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
						
						
						<form action="{{isset($org_contact) ? route('org_contacts.update', $org_contact->id) : route('org_contacts.store')}}" method="post">
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
									<th>Organization</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Position</th>
									<th>Building</th>
									<th>Email</th>
									<th>Username</th>
									<th>Password</th>
									<th>Toner Alerts</th>
									<th>Service Alerts</th>
									<th>Monthly Audit Report</th>
									<th></th>
								</tr>
							</thead>
							<tbody>								
								<tr>
									<td>										
										<select name="org" id="org" class="form-control mb-2">
											<option>Select an Organization</option>
											@if (isset($orgs))
												@foreach($orgs as $org)						
												
													<!--Display all orgs from the resultset.-->														
													<option value="{{$org->id}}"
														@if(isset($org_contact))
															@if($org->id == $org_contact->organizations_id)
																selected
															@endif
														@endif
														>
														{{$org->org_name}}
													</option>													
												@endforeach
											@endif												
										</select>											
									</td>
									<td><input type="text" name="first_name" id="first_name" value="{{isset($org_contact->first_name) ? $org_contact->first_name : ''}}"/></td>
									<td><input type="text" name="last_name" id="last_name" value="{{isset($org_contact->last_name) ? $org_contact->last_name : ''}}" /></td>
									<td><input type="text" name="position" id="position" value="{{isset($org_contact->position) ? $org_contact->position : ''}}"/></td>
									
									<td>										
										<select name="bldg_id" id="bldg_id" class="form-control mb-2">
											<option value="">Select a Building</option>
											@if (isset($buildings))
												@foreach($buildings as $row)						
												
													<!--Display all bldgs from the resultset.-->														
													<option value="{{$row->id}}"
														@if(isset($org_contact))
															@if($row->id == $org_contact->bldg_id)
																selected
															@endif
														@endif
													>
														{{$row->bldg_name}}
													</option>
													
												@endforeach
											@endif												
										</select>											
									</td>
									
									<td><input type="text" name="email" id="email" value="{{isset($org_contact->email) ? $org_contact->email : ''}}" /></td>
									<td><input type="text" name="user_name" id="user_name" value="{{isset($org_contact->user_name) ? $org_contact->user_name : ''}}" /></td>
									<td><input type="text" name="pword" id="pword" value="{{isset($org_contact->pword) ? $org_contact->pword : ''}}" /></td>
									
									<td>										
										<select name="toner_alert" id="toner_alert" class="form-control mb-2">											
											<!--Display all options.-->														
											<option value="N">Select Y/N</option>
											<option value="Y">Yes</option>
											<option value="N">No</option>																							
										</select>											
									</td>
									
									<td>										
										<select name="service_alert" id="service_alert" class="form-control mb-2">											
											<!--Display all options.-->														
											<option value="N">Select Y/N</option>
											<option value="Y">Yes</option>
											<option value="N">No</option>																							
										</select>											
									</td>
									
									<td>										
										<select name="audit_reports" id="audit_reports" class="form-control mb-2">											
											<!--Display all options.-->														
											<option value="N">Select Y/N</option>
											<option value="Y">Yes</option>
											<option value="N">No</option>																							
										</select>											
									</td>
									<td><button type="submit" class="btn btn-success btn-sm">{{isset($org_contact) ? 'Update Contact' : 'Add Contact'}}</button>
										<a href="{{route('org_contacts.index')}}" class="btn btn-danger btn-sm">Cancel</a>
									</td>										
								</tr>								
							</tbody>			
						</table><!-- end datatable -->
						
						<div class="btn-group my-3">			
						<a href="{{route('buildings.create')}}" class="btn btn-sm btn-primary center mx-3">Add Building</a>
						<a href="{{route('org_contacts.index')}}" class="btn btn-sm btn-primary center mx-3">Return to Org Selection</a>
					</div><!--end btn-group-->
					</div><!-- end panel-content -->
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->
		</div><!--end col-xl-12-->
	</div><!--end row-->
</main><!--end my-3-->
	
@endsection