@extends('layouts.app')

<!--org_contacts/show.blade.php-->
@section('content')

<div class="my-3 mx-3">
	<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
	@csrf
		<div class="container-fluid">
			<div class="d-flex my-3">
				<div class="form-group">
					<label for="orgSel">Organization</label>					

					<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('org_contacts.index', this.value)">
											
						@foreach($orgs as $org)						
						
							<!--Display all orgs from the resultset. If org.id = the id that was passed in the compact args, make
							    that org the selected one in the dropdown.-->
							<option value="{{$org->org_id}}"
								@if($org->org_id == $id)
									selected
								@endif
								
							>{{$org->org_name}}</option>
						@endforeach
						
					</select>
				</div><!--end form-group-->						
			</div><!--end d-flex-->
		</div><!--container-fluid-->
			
		<div class="container-fluid my-3">
			@foreach($contact_data as $vals)		
				@if(isset($vals->org_name))
					<!--<h3>Contact {{$vals->org_name}} Administrator</h3>-->
					@break
				@endif
			@endforeach
			
		</div><!--end container-fluid-->

	</form>
</div><!--end my-3 mx-3-->

		
		
<main id="js-page-content" class="my-3 mx-3">

<!--<div class="tab-pane" id="tab-events" role="tabpanel">
    <div class="d-flex flex-column h-100">
        <div class="h-auto">-->

	<!--Begin table for org_contacts data-->
	<!--<table id="contactsData" border="1px" class="table table-bordered table-hover table-striped w-100">-->
		
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
							This table shows all contacts that are associated with the selected organization. <strong>Note: </strong>The main
								people to contact for IT issues or questions are also listed above this table, along with their respective titles.
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
						
						
						<!-- datatable start -->
						<table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
							<thead class="myTabHead">						
								<tr>
									<th colspan="10" class="pt-3 pb-2 pl-3 pr-3 text-center">
										<div class="js-get-date h5 mb-2"></div>
									</th>
								</tr>
							
								<tr>
									<th>ID</th>
                    				<th>Org ID</th>
                    				<th>Client Type</th>
                    				<th>First Name</th>
                    				<th>Last Name</th>
                    				<th>Email</th>
                    				<th>Job Title</th>
                    				<th>Business Phone</th>
                    				<th>Fax</th>
                    				<th>Mobile Phone</th>
                    				<th>Extension</th>
                    				<th>Notes</th>
                    				<th>Address</th>
                    				<th>City</th>
                    				<th>State</th>
                    				<th>Zip</th>
                    				<th>Created Date</th>
                    				<td></td>
								</tr>
							</thead>
							<tbody>
								@if(isset($contact_data))
                        			@foreach($contact_data as $row)					
                            			<tr>
                            				<td>{{$row->contact_id}}</td>
                            				<td>{{$row->org_id}}</td>
                            				<td>Client Type</td>
                            				<td>{{$row->first_name}}</td>
                            				<td>{{$row->last_name}}</td>
                            				<td>{{$row->email}}</td>
                            				<td>{{$row->org_job_title}}</td>
                            				
                            				<td>@if(isset($row->area_code))
                    							    {{$row->area_code}}-{{$row->exch}}-{{$row->phone_line}}
                    							@endif
                    						</td>
                            				
                            				<td>@if(isset($row->area_code))
                    							    {{$row->f_area_code}}-{{$row->f_exch}}-{{$row->f_phone_line}}
                    							@endif
                    						</td>
                            				
                            				<td>@if(isset($row->m_area_code))
                    							    {{$row->m_area_code}}-{{$row->m_exch}}-{{$row->m_phone_line}}
                    							@endif
                    						</td>
        				
                            				<td>Extension</td>
                            				<td>{{$row->notes}}</td>
                            				<td>@if(isset($row->address))
                    							    {{$row->address}}
                    							@elseif(isset($row->address_mail))
                    								{{$row->address_mail}}
                    							@endif</td>
                            				<td>{{$row->city}}</td>
                            				<td>{{$row->state}}</td>
                            				<td>{{$row->zip_code}}</td>
                            				<td>{{$row->created_date}}</td>
                            				
                            				<td><a href="{{route('org_contacts.edit', $row->contact_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
                            				    <!--<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->contact_id}}, 'deleteContactForm', 'org_contacts/')">Delete</button>-->
                    							<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->contact_id}}, 'deleteContactForm', '')">Delete</button>
                    							
                    							<!--<a href="{{$row->contact_id}}" class="btn btn-danger btn-sm m-1">Delete</a>-->
                    							
                    							
                    						</td>
        			                    </tr>
                        			@endforeach
                    			@endif					
							</tbody>			
						</table><!-- end datatable -->
					</div><!-- end panel-content -->
					
					<div class="btn-group my-3">			
						<a href="{{route('org_contacts.create')}}" class="btn btn-sm btn-primary center mx-3">Add User</a>
						<a href="{{route('org_contacts.index')}}" class="btn btn-sm btn-primary center mx-3">Return to Org Selection</a>						
					</div><!--end btn-group-->
				</div><!-- end panel-container -->
			</div><!-- end panel-1 -->

			<!-- Begin Modal -->
        	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        	    <div class="modal-dialog" role="document">
        			<form action="" method="post" id="deleteContactForm">						
        			@csrf
        			@method('DELETE')
			
        				<div class="modal-content">
        				  <div class="modal-header">
        						<h5 class="modal-title" id="deleteModalLabel">Delete Contact Record</h5>
        						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        						  <span aria-hidden="true">&times;</span>
        						</button>
        				  </div>
        				  <div class="modal-body">
        					<p class="text-center text-bold">
        						Are you sure you want to delete this contact record?
        					</p>
        				  </div>
        				  <div class="modal-footer">
        					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        					<button type="submit" class="btn btn-danger">Yes, Delete</button>
        				  </div>
        				</div><!-- end modal-content -->
			        </form>
	            </div><!-- End modal-dialog -->
	        </div><!-- End modal deleteModal -->
	<!-- End Modal -->	
	
</main><!--end my-3-->
	
@endsection