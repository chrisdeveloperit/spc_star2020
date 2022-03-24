@extends('layouts.app')

<!--spc_users/index.blade.php-->

@section('content')
<form action="" method="get" enctype="multipart/form-data"> <!--enctype needed for image upload-->
@csrf
	<div class="container-fluid">
		<div class="d-flex my-3">
			<div class="form-group">
				<label for="orgSel">Organization</label>				

				<select name="orgSel" id="orgSel" class="form-control mb-2" onchange="page_direct('spc_users', this.value)">
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
			
			<!--<div class="col-md-10 my-3">
				<h5>IT Administrator</h5>
				<h5>Users may contact:</h5>					
			</div>--><!--end col-->				
		</div><!--end row-->	
	
		<!--<div class="row">
		     @if(isset($userdata))
		     @php
		        $mgr = "N";
		        $suprt = "N";
		        $suprt_count = 0;
		     @endphp
		     
    			@foreach($userdata as $row)				
												
    			@if($row->position == "IT Manager" AND $mgr == "N") 
        			<div class="col-md">
        				<label for="contact1">{{$row->spc_first_name}} {{$row->spc_last_name}}</label>
        				<input type="text" class="form-control" id="contact1" value="@if(isset($row->area_code))
											{{$row->area_code}}-{{$row->exch}}-{{$row->phone_line}} . . OR . .
											@endif {{$row->spc_email}}> 
        			</div>
        			
        			@php
    		            $mgr = "Y";
    		        @endphp
    			
    		    @endif
    		    
    		    
    		    @if($row->position == "IT Support" AND $suprt == "N" AND $suprt_count == 0)
        			<div class="col-md">
        				<label for="contact1">{{$row->spc_first_name}} {{$row->spc_last_name}}</label>
        				<input type="text" class="form-control" id="contact1" placeholder={{$row->spc_email}}>
        			</div>
        			
        			@php
    		            $suprt = "Y";
    		            $suprt_count = 1;
    		        @endphp
    			
    		    
    		
    			
    			@elseif($row->position == "IT Support" AND $suprt == "Y" AND $suprt_count == 1)
        			<div class="col-md">
        				<label for="contact1">{{$row->spc_first_name}} {{$row->spc_last_name}}</label>
        				<input type="text" class="form-control" id="contact1" placeholder={{$row->spc_email}}>
        			</div>
        			
        			@php
    		            $suprt_count = 2;
    		        @endphp
		        @endif
    			
    			@endforeach
			@endif
    			
		</div>-->
	</div><!--end container-fluid-->
	

</form>
<div class="my-3 mx-3">
	<h4>Authorized Users</h4>		
		
	<!--Begin table for spc_users data-->
	<table id="dt-basic-example" border="1px" class="table table-bordered table-hover table-striped w-100">
		<thead class="myTabHead">
			<tr>
				<th>Name</th>
				<th>Position</th>
				<th>Building</th>
				<th>Email</th>
				<th>Username</th>
				<th>Toner Alerts</th>
				<th>Service Alerts</th>
				<th>Monthly Audit Report</th>
				<th></th>
			</tr>
		</thead>
		<tbody>	
		    @if(isset($userdata))
    			@foreach($userdata as $row)
        			<tr>
        				<td>{{$row->first_name}} {{$row->last_name}}</td>
        				<td>{{$row->position}}</td>
        				<td>{{$row->buildings_id}}</td>
        				<td>{{$row->email}}</td>
        				<td>{{$row->user_name}}</td>
        				<td>{{$row->toner_alert}}</td>
        				<td>{{$row->service_alert}}</td>
        				<td>{{$row->audit_reports}}</td>
        				<td><a href="{{route('spc_users.edit', $row->peo_id)}}" class="btn btn-primary btn-sm m-1">Edit</a>
							<button class="btn btn-danger btn-sm m-1" onclick="handleDelete({{$row->peo_id}}, 'deleteUser', 'spc_users/')">Delete</button>
						</td>
        			</tr>
				@endforeach
			@endif
		</tbody>			
	</table>
	<!--End table for org_contacts data-->
	
	<div class="btn-group my-3">			
		<a href="{{route('spc_users.create')}}" class="btn btn-sm btn-primary center mx-3">Add User</a>					
	</div><!--end form-group-->
	
	<!-- Begin Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
			<form action="" method="post" id="deleteUser">						
			@csrf
			@method('DELETE')
			
				<div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title" id="deleteModalLabel">Delete User Record</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				  </div>
				  <div class="modal-body">
					<p class="text-center text-bold">
						Are you sure you want to permanently delete this user's record?
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
	
	
	
	
	
</div><!--end my-3-->
	
@endsection