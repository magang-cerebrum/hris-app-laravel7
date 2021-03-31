
@extends('layouts/templateAdmin')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Salin Jadwal Kerja')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')

@section('head')
<link rel="stylesheet" href="{{asset("plugins/bootstrap-validator/bootstrapValidator.min.css")}}">
<link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
<meta name="csrf-token" content="{{csrf_token()}}">
@endsection
@section('content')

    <div class="panel">

        <!-- Form wizard with Validation -->
        <!--===================================================-->
        <div id="demo-bv-wz">
            <div class="wz-heading pad-top">

                <!--Nav-->
                <ul class="row wz-step wz-icon-bw wz-nav-off mar-top">
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#demo-bv-tab1">
                            <span class="text-danger"><i class="demo-pli-information icon-2x"></i></span>
                            <p class="text-semibold mar-no">Account</p>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#demo-bv-tab2">
                            <span class="text-warning"><i class="demo-pli-male icon-2x"></i></span>
                            <p class="text-semibold mar-no">Profile</p>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#demo-bv-tab3">
                            <span class="text-info"><i class="demo-pli-home icon-2x"></i></span>
                            <p class="text-semibold mar-no">Address</p>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#demo-bv-tab4">
                            <span class="text-success"><i class="demo-pli-medal-2 icon-2x"></i></span>
                            <p class="text-semibold mar-no">Finish</p>
                        </a>
                    </li>
                </ul>
            </div>

            <!--progress bar-->
            <div class="progress progress-xs">
                <div class="progress-bar progress-bar-primary"></div>
            </div>


            <!--Form-->
            <div class="form-group">
            <form id="demo-bv-wz-form" class="form-horizontal" method="GET" action="#" >
                @csrf
                <div class="panel-body">
                    <div class="tab-content">

                        <!--First tab-->
                        <div id="demo-bv-tab1" class="tab-pane">
                            <div class="panel-body">
                                <div id="pickadate">
                                    <div class="input-group date">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger" type="button" style="z-index: 2"><i
                                                    class="fa fa-calendar"></i></button>
                                        </span>
                                        <input type="text" name="first" id="first_periode"  placeholder="Pilih Tanggal" 
                                            class="form-control" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <div class="shown" id="showns" hidden>
                                    <table class="table table-striped">
                                        
                                        <thead>
                                            <tr>
                                                <th>Nama : <small id="val"></small></th>
                                                
                                                <th style="width: 300px" >Pilih :</th>
                                            </tr>
                                        </thead>
                                        @foreach ($data as $item)
                                        <tbody>
                                            <tr>
                                                <td>{{$item->user_name}}</td>
                                                <td><input type="radio" name="chosen"  class="chosen-radio" value="{{$item->user_id}}" required></td>
                                        </tbody>
                                        @endforeach
                                        
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>

                        <!--Second tab-->
                        <div id="demo-bv-tab2" class="tab-pane fade">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama : <small id="val"></small></th>
                                                
                                                <th style="width: 300px" >Pilih :</th>
                                            </tr>
                                        </thead>
                                        @foreach ($data as $item)
                                        <tbody>
                                            <tr>
                                                <td>{{$item->user_name}}</td>
                                                <td><input type="checkbox" name="chosen_checkbox[]" class="chosen-checkbox" value="{{$item->user_id}}" required></td>
                                        </tbody>
                                        @endforeach
                                        
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--Third tab-->
                        <div id="demo-bv-tab3" class="tab-pane">
                            <div class="form-group">
                                <div class="timeline">
					
                                    <!-- Timeline header -->
                                   
                                    <div class="timeline-entry">
                                        <div class="timeline-stat">
                                            <div class="timeline-icon bg-warning"><i class="fa fa-check-circle"></i></div>
                                            
                                        </div>
                                        <div class="timeline-label">
                                            <p class="mar-no pad-btm" id="firstSum"></p>
                                        </div>
                                    </div>
                                    <div class="timeline-entry">
                                        <div class="timeline-stat">
                                            <div class="timeline-icon bg-info"><i class="demo-psi-mail icon-lg"></i></div>
                                        </div>
                                        <div class="timeline-label">
                                            <p class="mar-no pad-btm" >Kepada Staff : <span id="secondSum"></span> Periode <span id="periodesc"></span></p>    
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <!--Fourth tab-->
                        <div id="demo-bv-tab4" class="tab-pane  mar-btm text-center">
                            <h4>Thank you</h4>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
                        </div>
                    </div>
                </div>

                <!--Footer button-->
                <div class="panel-footer text-right">
                    <div class="box-inline">
                        <button type="button" class="previous btn btn-primary">Previous</button>
                        <button type="button" class="next btn btn-primary">Next</button>
                        <button type="button" class="finish btn btn-warning" disabled>Finish</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!--===================================================-->
        <!-- End Form wizard with Validation -->

    </div>

@endsection
@section('script')

<script src="{{asset("plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js")}}"></script>
<script src="{{asset("plugins/bootstrap-validator/bootstrapValidator.min.js")}}"></script>
<script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
<script>
    $(document).ready(function(){
        $('#pickadate .input-group.date').datepicker({
            format: 'mm/yyyy',
            autoclose: true,
            minViewMode: 'months',
            maxViewMode: 'years',
            startView: 'months',
            orientation: 'bottom',
            forceParse: false,
            startDate:'0d',
            endDate:'+1m'
        });
        var chosen_input = document.querySelectorAll('input[name="chosen"]')
        let chosen ;
        
        $('#demo-bv-wz').bootstrapWizard({
        tabClass		    : 'wz-steps',
        nextSelector	    : '.next',
        previousSelector	: '.previous',
        onTabClick          : function(tab, navigation, index) {
            return false;
        },
        onInit : function(){
            $('#demo-bv-wz').find('.finish').hide().prop('disabled', true);
        },
        onTabShow: function(tab, navigation, index) {
            // console.log(index);
            var $total = navigation.find('li').length;
            var $current = index+1;
            // console.log($current,$total)
            var $percent = ($current/$total) * 100;
            var wdt = 100/$total;
            var lft = wdt*index;

            $('#demo-bv-wz').find('.progress-bar').css({width:wdt+'%',left:lft+"%", 'position':'relative', 'transition':'all .5s'});
            
            if($current == 1){

                $('#first_periode').on('change',function(){
                    $('#showns').show()
                })

                $('.chosen-radio').on('change', function(){
                for(chosen_inputs of chosen_input){
                    if(chosen_inputs.checked){
                        chosen = chosen_inputs.value
                        break;
                    }
                }; console.log(chosen)
                })

                // var queue = new Array();
                // queue.splice(0,queue.length);
                // var queueFilter = new Array();
                // $('.next').attr('id','ajax')
                // $('.chosen-checkbox').on('click',function(){

                //     var valueRowsName = $(this).val();
                //     if($(this).is(':checked',true)) {
                //         queue.push(valueRowsName);
                //     } else {
                //         queue.splice(queue.indexOf(valueRowsName), 1);
                //     }
                //     console.log(queue);
                // });
               
                
                let url = '/admin/schedule/copyschedule/calculate'
                $('#ajax').on('click',function(){
                    var second_periode = document.getElementById('second_periode').value
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url : url,
                        type : 'POST',
                        data : {
                            chosen : chosen,
                            first_periode : first_periode,
                            second_periode : second_periode,
                            queue : queue
                        },
                        dataType:'json',
                        success : function(response){
                            
                            document.getElementById('firstSum').innerHTML = "Jadwal akan disalin dari staff " + response.dataRadio[0].name + " pada periode "+ response.dataRadio[0].month +"/"+ response.dataRadio[0].year 
                                // response.dataCheckBox.forEach(responses=>
                                //     // console.log(responses.name)
                                //     // document.getElementById('secondSum').innerHTML = "Kepada " + responses.name
                                
                                
                                // )
                            response.dataCheckBox.map( (dataCheckBoxes) => {
                            var content = document.getElementById('secondSum').textContent
                            var result = content+dataCheckBoxes.name + ', '
                            document.getElementById('secondSum').innerHTML = result
                                
                            });
                            document.getElementById('periodesc').innerHTML = response.secondPeriode
                            
                                // console.log(element)

                           
                            // console.log(response)
                            // function test(){
                            //     document.getElementById('secondSum').innerHTML = 

                            // }
                            
                        },
                        error : function (jXHR, textStatus, errorThrown) {
                            console.log(jXHR, textStatus, errorThrown)
                        }

                    })
                })
            }

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $('#demo-bv-wz').find('.next').hide();
                $('#demo-bv-wz').find('.finish').show();
                $('#demo-bv-wz').find('.finish').prop('disabled', false);
            } else {
                $('#demo-bv-wz').find('.next').show();
                $('#demo-bv-wz').find('.finish').hide().prop('disabled', true);
            }
        },
        onNext: function(){
            isValid = null;
            $('#demo-bv-wz-form').bootstrapValidator('validate');


            if(isValid === false)return false;
        }
    });

    var isValid;
    $('#demo-bv-wz-form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
        },
        fields: {
            chosen: {
            validators: {
                notEmpty: {
                    message: 'Mohon Pilih Salah Satu'
                }
            }
        },
        chosen_checkbox: {
            validators: {
                notEmpty: {
                    message: 'Mohon Isi Checkbox'
                },
                min:1
            }
        },
        
        // lastName: {
        //     validators: {
        //         notEmpty: {
        //             message: 'The last name is required and cannot be empty'
        //         },
        //         regexp: {
        //             regexp: /^[A-Z\s]+$/i,
        //             message: 'The last name can only consist of alphabetical characters and spaces'
        //         }
        //     }
        // },
        // phoneNumber: {
        //     validators: {
        //         notEmpty: {
        //             message: 'The phone number is required and cannot be empty'
        //         },
        //         digits: {
        //             message: 'The value can contain only digits'
        //         }
        //     }
        // },
        // address: {
        //     validators: {
        //         notEmpty: {
        //             message: 'The address is required'
        //         }
        //     }
        // }
        }
    }).on('success.field.bv', function(e, data) {
        // $(e.target)  --> The field element
        // data.bv      --> The BootstrapValidator instance
        // data.field   --> The field name
        // data.element --> The field element

        var $parent = data.element.parents('.form-group');

        // Remove the has-success class
        $parent.removeClass('has-success');


        // Hide the success icon
        $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
    }).on('error.form.bv', function(e) {
        isValid = false;
    });

//     $('#pickadate .input-group.date').on('changeDate show', function(e) {
//     $('#contactForm').bootstrapValidator('revalidateField', 'first');
// });

        
    });
        
    
    
</script>
@endsection