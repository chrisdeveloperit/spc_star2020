@extends('layouts.app')

<!--org_contacts/index.php-->

@section('content')
<div class="my-3 mx-3">
    <form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
    @csrf
    	<div class="container-fluid">
    		<div class="d-flex my-3">
    			<div class="form-group">
    				<label for="orgSel">Organization</label>				
    
    				<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('org_contacts', this.value)">
    					<option value="">Select Organization</option>
    					@foreach($orgs as $org)
    						<option value="{{$org->org_id}}">{{$org->org_name}}</option>
    						
    					@endforeach
    				</select>
    			</div><!--end form-group-->			
    		</div><!--end d-flex-->
    	</div><!--container-fluid-->
    
    
    	<div class="container-fluid my-3">		
    		<h3>Contact - -  Administrator</h3>			
    	</div><!--container-fluid-->
    	
    		
    	<div class="container-fluid borderT">
    		
    		<div class="row">
    			<!--<div class="col-md-2 my-3">
    				<img src="" alt="school logo">
    			</div>-->
    			
    			<div class="col-md-10 my-3">
    				<!--<h5>IT Administrator</h5>-->
    				<h5>Users may contact:</h5>					
    			</div><!--end col-->				
    		</div><!--end row-->	
    	
    		<!--<div class="row">				
    												
    			<div class="col-md">
    				<label for="contact1">IT Manager</label>
    				<input type="text" class="form-control" id="contact1" placeholder="Phone for the IT Manager">
    			</div>	
    		
    			<div class="col-md">
    				<label for="contact1">IT Support</label>
    				<input type="text" class="form-control" id="contact1" placeholder="Phone for the IT Support person">
    			</div>	
    		
    			<div class="col-md">
    				<label for="contact1">IT Overseer</label>
    				<input type="text" class="form-control" id="contact1" placeholder="Phone for the IT Overseer">
    			</div>		
    		</div>--><!--end row-->
    	</div><!--end container-fluid-->
    
    </form>
</div><!--end my-3 mx-3-->

<main id="js-page-content" class="my-3 mx-3">
	<div class="row">
		<div class="col-xl-12">
			<div id="panel-1" class="panel">
	<!--<h4>Authorized Users</h4>-->	
		
	<!--Begin table for org_contacts data-->
	<table id="dt-basic-example" border="1px" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
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
							@if(isset($id))
						        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->contact_id}}, 'deleteContactForm', '')">Delete</button>
						    @else
						        <button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->contact_id}}, 'deleteContactForm', 'org_contacts/')">Delete</button>
						    @endif
							
							<!--<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->contact_id}}, 'deleteContactForm', 'org_contacts/')">Delete</button>-->
							
						</td>
        			</tr>
    			@endforeach
			@endif
		</tbody>			
	</table>
	<!--End table for org_contacts data-->
	
	</div><!-- end panel-1 -->
		</div><!--end col-xl-12-->
	</div><!--end row-->
	
	
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
				</div>
			</form>
	  </div><!-- End modal-dialog -->
	</div><!-- End modal deleteModal -->
	<!-- End Modal -->	
	
	
	<div class="btn-group my-3">			
		<a href="{{route('org_contacts.create')}}" class="btn btn-sm btn-primary center mx-3">Add Contact</a>
		<a href="{{route('org_contacts.index')}}" class="btn btn-sm btn-primary center mx-3">Add User</a>
	</div><!--end form-group-->
</div><!--end my-3-->
	
@endsection