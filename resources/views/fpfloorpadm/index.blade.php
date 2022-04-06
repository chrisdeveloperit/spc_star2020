@extends('layouts.app')
@section('content')
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
   <script type="text/javascript" src="{{asset('jQuery-3.3.1/jquery-3.3.1.min.js')}}"></script>
   <div>
      <div class="toast" id="popmsg" role="alert" aria-live="assertive" aria-atomic="true" data-delay="1800">
         <div id="tbody" class="toast-body  bg-warning d-flex justify-content-center align-items-center"> toast message. </div>
      </div>

      <form name="selectboxes" id="selectboxes" action="{{ route('fpfloorpadm.index') }}" method="post">
      @csrf
         <div class="container-fluid">
            <div class="d-flex">
               <div class="form-group p-1">
                  <label for="buildingsSel">Organization</label>

                  <select name="sorg_id" id="sorg_id" class="form-control mb-2" onchange="this.form.submit()">
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

                  <select name="buildingsSel" id="buildingsSel" class="form-control mb-2" onchange="this.form.submit()">
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
                           @endif >
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
                     <th scope="col"><img class="ink" src="{{asset('spcsd/images/black_drop.jpg')}}" /></th>
                     <th scope="col">Room</th>
                     <th scope="col">Make</th>
                     <th scope="col">Model</th>
                     <th scope="col">Connectivity</th>
                  </tr>
               </thead>
               <tbody>
               @foreach($machines as $mac)
                  <tr class="machinelist" id="row{{$mac->fpm_id}}" data-id="{{$mac->fpm_id}}" data-image="{{$mac->machine_image}}" data-bldg="{{$floorplans->bldg_name}}" data-room="{{$mac->room_name}}" data-mactype="{{$mac->type_name}}" data-serial="{{$mac->present_serial_number}}" data-ip="{{$mac->ip_address}}" data-macAdd="{{$mac->mac_address}}" data-model="{{$mac->model}}" data-vendorid="{{$mac->mach_make}}">
                     <th scope="row">{{$loop->index + 1 }}</th>
                     @if($mac->is_color === 'N')
                     <td><img class="ink" src="{{asset('spcsd/images/black_drop.jpg')}}" /></td>
                     @else
                     <td><img class="ink" src="{{asset('spcsd/images/magenta_drop.jpg')}}" /></td>
                     @endif
                     <td>{{$mac->room_name}}</td>
                     <td>{{$mac->mach_make}}</td>
                     <td>{{$mac->model}}</td>
                     <td>
                        {{$connect = $mac->ip_address !== NULL ? "Networked" : "Local";}}
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

         <!-- MODAL WINDOW -->
   <div class="modal fade" id="fpmModal" tabindex="-1" aria-labelledby="fpmModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content bg-light">
      <form name="updateRoom" id="updateRoom" action="" method="post">
         @csrf
         @method('POST')
         <div id="fpmbody" class="modal-body">
            <div class="form-group">
            <label for="usr">Enter New Room Name:</label>
            <input type="text" class="form-control" name="roomName" 
            id="roomName" value="">
            <input type="hidden" id="xpos" name="present_x_position" value="" />
            <input type="hidden" id="ypos" name="present_y_position" value="" />
            </div>
         </div>
         <div class="modal-footer">
         <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
         <button type="button" id="saveXY" class="btn btn-primary btn-sm" data-dismiss="modal">Save Changes</button>
         </div>
      </form>  
      </div>
   </div>
   </div>

   </main> 
@endsection

@section('css')
         <style>

      label { font-weight: bold;}
      .detailLabel {
      text-align: right;
      width: 125px;
         }
      #template { width: 200px;}

      .makeDraggable { position: absolute; width: 25px; height: 25px; border: 2px solid #1769aa; background-color: #00bcd4; color: #fff; border-radius: 50%; z-index: 50; cursor: pointer; font-size: 11px; font-weight:bold;}

      .makeDraggable2 { position: absolute; width: 30px; height: 30px; border: 0px solid #1769aa; background-image:url('/images/shapes/multiprinter2.svg');  background-size: contain; display: block; background-repeat: no-repeat;background-color: transparent; color: #fff;  z-index: 50; cursor: pointer; font-size: 11px; font-weight:bold;  padding-right:4px;padding-top:3px;}

      .ink {width: 8px; height: 16px; }

      #deviceList, #detailCollapse, .card-body {
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
      .toast { 
         max-width: 200px; 
         left: 55%;
         top: 40%;
         position: fixed;
         transform: translate(-50%, -40%);
         z-index: 52;
      }
      .toast-body { min-height:4em; }
      @if(isset($floorplans->floorplan_image))

      .displayDiv { position: relative; width: 1000px; height: 726px; border: solid 1px #ccc;
      background-image: url("{{asset('spcsd/images/floorplans')}}/{{$floorplans->floorplan_image}}"); background-size: contain; display: block; background-repeat: no-repeat; border-radius: 3px;}
      @endif 
   </style>
@endsection

@section('scripts')

   <script>
   let vertOffset = 0;
   $('.multi-collapse').on('show.bs.collapse', ()=>{ vertOffset = 466; })
                       .on('hide.bs.collapse', ()=>{ vertOffset = 0; });
 
   $('input[name=radioFloors]').change(function() {
         $('#selectboxes').submit();
      });

      const createDragItem = (id, xcoor, ycoor,label, room, icontype ="Circle") => {
            const parentpos = document.getElementById('floorplandiv').getBoundingClientRect();
            const itemClass = icontype == "Octagon" ? "makeDraggable2" : "makeDraggable";
            const itemName = `dragItem${id}`;
            const item = `<div id="${itemName}" data-id="${id}" class="${itemClass} d-flex" data-room = "${room}">
            <div class="mr-auto ml-auto mt-1 mb-1">${label}</div> </div>`;
            let scale = Math.abs(1000/1135).toPrecision(2);
            let newXoffset = (xcoor * scale + parentpos.left).toPrecision(5);
            let newYoffset = (ycoor * scale + (parentpos.top * 0.93)).toPrecision(5);
            if (newXoffset > parentpos.right) { newXoffset = (parentpos.right - 50).toPrecision(5); }
            if (newYoffset > parentpos.bottom) { newYoffset = (parentpos.bottom - 50).toPrecision(5); }
            $("#floorplandiv").append(item);
            setTimeout(() => { let _ = itemName; }, 500);
            $(`#${itemName}`).offset({ top: newYoffset, left: newXoffset});
            $(`#${itemName}`).draggable( {
               containment: '#floorplandiv',
               cursor: 'point',
               snap: '#floorplandiv',
               stop: () => {
                  let finalOffset = $(`#${itemName}`).offset();
                  let finalxPos = ((finalOffset.left - parentpos.left)/scale).toPrecision(5);
                  let finalyPos = (((finalOffset.top - (parentpos.top * 0.93))/scale));
                  console.log('Before',finalyPos);
                  finalyPos = (finalyPos - vertOffset).toPrecision(5);
                  console.log('After',finalyPos);
                  saveNewLocation(finalxPos, finalyPos, id, room);
               }
         } );
      }
      @if(isset($machines) )
         @foreach($machines as $mac)
         createDragItem({{$mac->fpm_id}}, {{$mac->present_x_position}}, {{$mac->present_y_position}}, "{{$loop->index + 1 }}", "{{$mac->room_name}}", "{{$mac->icon_type}}");
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

      // $(document).on('submit','form', function(e) { 
         $('#saveXY').on('click', function(e) { 
            $.ajax({
               type: 'POST',
               url: $('#updateRoom').attr('action'),
               data: $('#updateRoom').serialize(),
               dataType: "text",
               encode: true, 
            })
            .done( function( msg ) {
               $('#tbody').text(msg);
               $('#popmsg').toast('show');
            })
            .fail(function( xhr, textStatus, errorThrown ) {
               $('#tbody').text('SAVE FAILED: '+ textStatus);
               $('#popmsg').toast('show');
               console.log('statusText ' + xhr.statusText);
               console.log('RESPONSE ' + xhr.responseText);
               console.log('errorThrown ' + errorThrown);
            });
         });
      });

      const toastMessage = function (msg) {
            $('#tbody').text(msg);
            $('#popmsg').toast('show');
         }  

      const saveNewLocation = (finalxPos, finalyPos, id, roomName) => {
        console.log(`{{url('/')}}/api/device/${id}`);
        let putUrl = `{{url('/')}}/api/device/${id}`;
         $('#updateRoom').attr('action', putUrl);
         $('#roomName').val(roomName);
         $('#xpos').val(finalxPos);
         $('#ypos').val(finalyPos);
         $('#fpmModal').modal(); 
         $('#roomName').focus();
      }
   </script>
@endsection