@extends('layouts/templateStaff')
@section('title','Jadwal Kerja')
@section('content-title','Data Staff / Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
    <link href="{{ asset('calender/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{ asset('calender/css/fullcalendar.css')}}"" rel='stylesheet' />
    <style>
    body {
        padding-top: 70px;
    }
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>
@endsection

@section('content')
    <div class="panel">
        <div class="panel-body">
            <div class="table-responsive">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>FullCalendar PHP MySQL</h3>
                            <div id="calendar" class="col-centered">
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.row -->
                    
                    <!-- Modal -->
                    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="addEvent.php">
                        
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add Event</h4>
                          </div>
                          <div class="modal-body">
                            
                              <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="color" class="col-sm-2 control-label">Color</label>
                                <div class="col-sm-10">
                                  <select name="color" class="form-control" id="color">
                                      <option value="">Choose</option>
                                      <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                      <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                      <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
                                      <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                      <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                      <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                      <option style="color:#000;" value="#000">&#9724; Black</option>
                                      
                                    </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="start" class="col-sm-2 control-label">Start date</label>
                                <div class="col-sm-10">
                                  <input type="text" name="start" class="form-control" id="start" readonly>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="end" class="col-sm-2 control-label">End date</label>
                                <div class="col-sm-10">
                                  <input type="text" name="end" class="form-control" id="end" readonly>
                                </div>
                              </div>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('calender/js/jquery.js')}}"></script>
<script src="{{ asset('calender/js/bootstrap.min.js')}}"></script>
<script src='{{ asset('calender/js/moment.min.js')}}'></script>
<script src='{{ asset('calender/js/fullcalendar.min.js')}}'></script>

{{-- <script>

	$(document).ready(function() {
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '2018-01-01',
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			
			
			// eventDrop: function(event, delta, revertFunc) { // si changement de position

			// 	edit(event);

			// },
			// eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

			// 	edit(event);

			// },
			// events: [
			// <?php foreach($events as $event): 
			
			// 	$start = explode(" ", $event['start']);
			// 	$end = explode(" ", $event['end']);
			// 	if($start[1] == '00:00:00'){
			// 		$start = $start[0];
			// 	}else{
			// 		$start = $event['start'];
			// 	}
			// 	if($end[1] == '00:00:00'){
			// 		$end = $end[0];
			// 	}else{
			// 		$end = $event['end'];
			// 	}
			// ?>
			// 	{
			// 		id: '<?php echo $event['id']; ?>',
			// 		title: '<?php echo $event['title']; ?>',
			// 		start: '<?php echo $start; ?>',
			// 		end: '<?php echo $end; ?>',
			// 		color: '<?php echo $event['color']; ?>',
			// 	},
			// <?php endforeach; ?>
			// ]
		});
		
		// function edit(event){
		// 	start = event.start.format('YYYY-MM-DD HH:mm:ss');
		// 	if(event.end){
		// 		end = event.end.format('YYYY-MM-DD HH:mm:ss');
		// 	}else{
		// 		end = start;
		// 	}
			
		// 	id =  event.id;
			
		// 	Event = [];
		// 	Event[0] = id;
		// 	Event[1] = start;
		// 	Event[2] = end;
			
		// 	$.ajax({
		// 	 url: 'editEventDate.php',
		// 	 type: "POST",
		// 	 data: {Event:Event},
		// 	 success: function(rep) {
		// 			if(rep == 'OK'){
		// 				alert('Saved');
		// 			}else{
		// 				alert('Could not be saved. try again.'); 
		// 			}
		// 		}
		// 	});
		}
		
	});

</script> --}}
@endsection