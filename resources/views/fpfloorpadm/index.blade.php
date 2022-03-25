@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<div>
	<form action="{{ route('fpfloorpadm.index') }}" method="post">
	@csrf
		<div class="container-fluid">
			<div class="d-flex">
				<div class="form-group p-1">
					<label for="buildingsSel">Organization</label>

					<select name="sorg_id" id="sorg_id" class="form-control mb-2" onchange="form.submit()">
						<option value="">Select an Organization</option>
						<!--Display all orgs from the resultset.-->
                  @if(isset($org_data))
						@foreach($org_data as $row)
							<option value="{{$row->org_id}}"
								@if(isset($sorg_id))
									@if($row->org_id == $sorg_id)
										selected
									@endif
								@endif
							>{{$row->org_name}}</option>
						@endforeach
                  @endif
					</select>
				</div><!--end form-group-->
            <div class="form-group p-1">
					<label for="buildingsSel">Buildings</label>

					<select name="buildingsSel" id="buildingsSel" class="form-control mb-2" onchange="form.submit()">
						<option value="">Select a building</option>
						<!--Display all orgs from the resultset.-->
                  @if(isset($buildings))
						@foreach($buildings as $row)
							<option value="{{$row->bldg_id}}"
								@if(isset($sbldg_id))
									@if($row->bldg_id == $sbldg_id)
										selected
									@endif
								@endif
							>{{$row->bldg_name}}</option>
						@endforeach
                  @endif
					</select>
				</div><!--end form-group-->
            <div class="form-group p-1">
					<label for="radioFloors">Floor #</label>
               <div>
                  @if(isset($total_floors))
                  @foreach($total_floors as $flr)

                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="radioFloors"  value="{{$flr->floor_number}}"
                     @if(isset($sfloornum))
									@if($flr->floor_number == $sfloornum)
										checked
									@endif
								@endif
                     >
                     <label class="form-check-label">{{$flr->floor_number}}</label>
                  </div>
                  @endforeach
                  @endif
               </div>
				</div><!--end form-group-->
			</div><!--end d-flex-->
		</div><!--container-fluid-->
	</form>
</div><!--end my-3 mx-3-->

<main id="js-page-content">
	<div class="row">
		<div class="col-xl-12">
   @if(isset($machines) )
   <p>
  <button class="btn btn-primary m-1" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="deviceList">Device List - Detail </button>
   </p>
<div class="row pb-2">
   <div class="col-sm-6">
    <div class="collapse multi-collapse" id="detailCollapse">
      <div class="card card-body bgblue">
         <table border="0" style="font-size: 12px; width:400px;">
            <tbody>
               <tr>
                  <td colspan="3" class="detailCenter" style="padding: 0.7em;"><img id="detail-img" src="{{ asset('spcsd/images/machines/RicohP501.png') }}" width="200" height="151" alt="printer"></td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>Building:</strong></td>
                  <td colspan="2" class="detailValue" id="detail-bldg"> </td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>Room:</strong></td>
                  <td id="detail-room" colspan="2" class="detailValue"> </td>
               </tr>
               <tr>
                  <td colspan="3"><hr></td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>Model:</strong></td>
                  <td id="detail-model" colspan="2" class="detailValue"> </td>
               </tr>
               <tr>
                  <td colspan="3"><hr></td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>Type:</strong></td>
                  <td id="detail-type" colspan="2" class="detailValue"> </td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>Serial Number:</strong></td>
                  <td id="detail-serial" colspan="2" class="detailValue"> </td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>IP Address:</strong></td>
                  <td colspan="2" class="detailValue"><a id="detail-ip" href="http://10.7.110.39/" title="Click to view web interface" target="10.7.110.39" class="popup"> </a></td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>MAC Address:</strong></td>
                  <td id="detail-macAddr" colspan="2" class="detailValue"></td>
               </tr>
               <tr>
                  <td class="detailLabel"><strong>Vendor Id:</strong></td>
                  <td id="detail-vendorId" colspan="2" class="detailValue"> </td>
               </tr>
               <tr>
                  <td colspan="3"><hr></td>
               </tr>
            </tbody>
         </table>
      </div>
    </div>
   </div>
  <div class="col-sm-6">
    <div class="collapse multi-collapse" id="deviceList">
      <div class="card card-body">

      <table class="table table-hover">
         <thead>
            <tr style="background-color: #f0f8fa">
               <th scope="col">#</th>
               <th scope="col"><img class="ink" src="/images/black_drop.jpg" /></th>
               <th scope="col">Room</th>
               <th scope="col">Make</th>
               <th scope="col">Model</th>
               <th scope="col">Connectivity</th>
            </tr>
         </thead>
         <tbody>
         @foreach($machines as $mac)
            <tr class="machinelist" id="row{{$mac->id}}" data-id="{{$mac->id}}" data-image="{{$mac->machine_image}}" data-bldg="{{$floorplans->bldg_name}}" data-room="{{$mac->room_number}}" data-mactype="{{$mac->type_name}}" data-serial="{{$mac->present_serial_number}}" data-ip="{{$mac->IP_Address}}" data-macAdd="{{$mac->mac_address}}" data-model="{{$mac->model}}" data-vendorid="Vendor">
               <th scope="row">{{$loop->index + 1 }}</th>
               @if($mac->is_color == 'N')
               <td><img class="ink" src="/images/black_drop.jpg" /></td>
               @else
               <td><img class="ink" src="/images/magenta_drop.jpg" /></td>
               @endif
               <td>{{$mac->room_number}}</td>
               <td>{{$mac->make}}</td>
               <td>{{$mac->model}}</td>
               <td>
                  {{$connect = $mac->local_connection == 'N'? "Networked" : "Local";}}
               </td>
            </tr>
         @endforeach
         </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
   @endif
      <div id="panel-1" class="panel">
         <div id="floorplandiv" class="displayDiv">
         </div>
      </div><!-- end panel-1 -->
</main> 


<style>
   label { font-weight: bold;}
   .detailLabel {
    text-align: right;
    width: 125px;
      }
   #template { width: 200px;}
  /** .fp { width: 1120px; height: 813px; min-width:1120px; min-height: 813px; }  **/
   .makeDraggable { position: absolute; width: 25px; height: 25px; border: 2px solid #1769aa; background-color: #00bcd4; color: #fff; border-radius: 50%; z-index: 100; cursor: pointer; font-size: 11px; font-weight:bold;}

   .makeDraggable2 { position: absolute; width: 30px; height: 30px; border: 0px solid #1769aa; background-image:url('/images/shapes/multiprinter2.svg');  background-size: contain; display: block; background-repeat: no-repeat;background-color: transparent; color: #fff;  z-index: 100; cursor: pointer; font-size: 11px; font-weight:bold;  padding-right:4px;padding-top:3px;}

   .ink {width: 8px; height: 16px; }

   #deviceList, #detailCollapse {
      min-height: 466px;

    }
    #deviceList { 
       max-height: 466px;
       overflow-y:auto;
   }
   .machinelist { cursor: pointer;}

   tr.highlight td, tr.highlight th {
      background-color: #b7dde8;
   }

   .selectedCircle { border: 3px solid #e91e63;}

   .btn-primary, .btn-primary:active, .btn-primary:focus { background-color: #40627b; border-color: #40627b; opacity: 1.0;}
   .btn-primary:hover { background-color: #40627b; border-color: #40627b; opacity: 0.7;}

      /* width */
   .collapse::-webkit-scrollbar {
   width: 10px;
   }

   /* Track */
   .collapse::-webkit-scrollbar-track {
   background: #e1e1e1;
   }

   /* Handle */
   .collapse::-webkit-scrollbar-thumb {
      background: #1769aa;
   }

   /* Handle on hover */
   .collapse::-webkit-scrollbar-thumb:hover {
      background: #0d3f66;
   }

   .bg-warning {opacity: 0.85;}
   .bgblue { background-color: #f0f8fa; }
   
   @if(isset($floorplans->floorplan_image))

   .displayDiv { position: relative; width: 1000px; height: 726px; border: solid 1px #ccc;
   background-image: url("{{asset('spcsd/images/floorplans')}}/{{$floorplans->floorplan_image}}"); background-size: contain; display: block; background-repeat: no-repeat; border-radius: 3px;}
   @endif
   
</style>

<script>

   $('input[type=radio][name=radioFloors]').change(function() {
      $('form').submit();
   });

   const createDragItem = (id, xcoor, ycoor,label, room, icontype ="Circle") => {
         const parentpos = document.getElementById('floorplandiv').getBoundingClientRect();
         const itemClass = icontype == "Octagon" ? "makeDraggable2" : "makeDraggable";
         const itemName = `dragItem${id}`;
         const item = `<div id="${itemName}" data-id="${id}" class="${itemClass} d-flex" data-room = "${room}">
         <div class="mr-auto ml-auto mt-1 mb-1">${label}</div> </div>`;
         let scale = Math.abs(1000/1135);
         let newXoffset = xcoor * scale + parentpos.left;
         let newYoffset = ycoor * scale + (parentpos.top * 0.94);
         if (newXoffset > parentpos.right) { newXoffset = parentpos.right - 50; }
         if (newYoffset > parentpos.bottom) { newYoffset = parentpos.bottom - 50; }
         $("#floorplandiv").append(item);
         //setTimeout(() => { console.log(`${itemName}`,`Y: ${newYoffset}`, `X: ${newXoffset}`); }, 500);
         setTimeout(() => { let _ = itemName; }, 500);
         $(`#${itemName}`).offset({ top: newYoffset, left: newXoffset});
         $(`#${itemName}`).draggable( {
            containment: '#floorplandiv',
            cursor: 'point',
            snap: '#floorplandiv',
            stop: () => {
               let finalOffset = $(`#${itemName}`).offset();
               let finalxPos = finalOffset.left;
               let finalyPos = finalOffset.top;
              // saveNewLocation(finalxPos, finalyPos, itemName);
            }
      } );
   }
   @if(isset($machines) )
      @foreach($machines as $mac)
      createDragItem({{$mac->id}}, {{$mac->x_position}}, {{$mac->y_position}}, "{{$loop->index + 1 }}", "{{$mac->room_number}}", "{{$mac->icon_type}}");
   @endforeach 
   @endif 

   $(function(){
      $(document).on('click mouseenter','.machinelist', function() {
         let img = $(this).data('image');
         $('#detail-img').attr('src','spcsd/images/machines/'+ img);
         $('#detail-bldg').text( $(this).data('bldg') );
         $('#detail-room').text( $(this).data('room') );
         $('#detail-model').text( $(this).data('model') );
         $('#detail-type').text( $(this).data('mactype') );
         $('#detail-serial').text( $(this).data('serial') );
         $('#detail-ip').attr('src','http://'+ $(this).data('ip')).text( $(this).data('ip') );
         $('#detail-macAddr').text( $(this).data('macAdd') );
         $('#detail-vendorId').text( $(this).data('vendorid') );
         // Highlight row
         $(this).addClass('highlight').siblings().removeClass('highlight');
         // Highlight icon on floorplan
         $('.makeDraggable, .makeDraggable2').removeClass('selectedCircle');
         $('#dragItem'+ $(this).data('id')).addClass('selectedCircle');
      });
   });

   const saveNewLocation = (finalxPos, finalyPos, item) => {
      let itm = '#'+ item;
      let popTemplate = ['<div class="popover">',
        '<div class="arrow"></div>',
        '<div class="popover-content">',
        '</div>',
        '</div>'].join('');

      let content = ['<h4>This is working</h4>',
                     '<p>What time is it?</p>'].join('');

    $('body').popover({
         selector: '[rel=popover]',
         placement: 'top auto',
         template: popTemplate,
        //title: 'Room Name',
        content: content,
        trigger: 'focus',
        html: true
      });
     // console.log(finalxPos);
   }
</script>
@endsection