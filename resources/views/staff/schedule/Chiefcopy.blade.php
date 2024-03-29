
@extends('layouts/templateStaff')
@section('title','Jadwal Kerja')
@section('content-title','Jadwal Kerja / Salin Jadwal Kerja')
@section('content-subtitle','HRIS '.$company_name)

@section('head')
    <link rel="stylesheet" href="{{asset("plugins/bootstrap-validator/bootstrapValidator.min.css")}}">
    <link rel="stylesheet" href="{{asset("plugins/themify-icons/themify-icons.css")}}">
    <link rel="stylesheet" href="{{asset("plugins/css-loaders/css/css-loaders.css")}}">
    <link href="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.css")}}" rel="stylesheet">
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('content')
    <div class="panel" style="border: #211F6E 1px solid">
        <!-- Form wizard with Validation -->
        <!--===================================================-->
        <div id="bv-wz">
            <div class="wz-heading pad-top">
                <!--Nav-->
                <ul class="row wz-step wz-icon-bw wz-nav-off mar-top">
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#bv-tab1">
                            <span class="text-danger"><i class="ti-calendar"></i></span>
                            <p class="text-semibold mar-no">Bulan dan Karyawan untuk di Salin</p>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#bv-tab2">
                            <span class="text-warning"><i class="ti-target"></i></span>
                            <p class="text-semibold mar-no">Target Salin </p>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#bv-tab3">
                            <span class="text-info"><i class="ti-announcement"></i></span>
                            <p class="text-semibold mar-no">Kesimpulan</p>
                        </a>
                    </li>
                    <li class="col-xs-3">
                        <a data-toggle="tab" href="#bv-tab4">
                            <span class="text-success"><i class="ti-save"></i></span>
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
                <form id="bv-wz-form" class="form-horizontal" method="POST" action="{{url('/staff/schedule/copied')}}" >
                    @csrf
                    <div class="panel-body">
                        <div class="tab-content">
                            <!--First tab-->
                            <div id="bv-tab1" class="tab-pane">
                                <div class="panel-body">
                                    <div id="pickadate">
                                        <div class="input-group date">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button" style="z-index: 2">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                            <input type="text" name="first" id="first_periode"  placeholder="Pilih Tanggal" 
                                                class="form-control" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="shown" id="showns" hidden>
                                            <table class="table table-striped" id="table-data">
                                                <thead>
                                                    <tr id="theader">
                                                        <th>Nama : <small id="val"></small></th>
                                                        <th style="width: 300px" >Pilih :</th>
                                                    </tr>
                                                </thead>
                                                @foreach ($data as $item)
                                                    <tbody>
                                                        <tr class="{{$item->month}}">
                                                            <td>{{$item->user_name}}</td>
                                                            <td>
                                                                <input type="radio" name="chosen"  class="chosen-radio" value="{{$item->user_id}}" required>
                                                            </td>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Second tab-->
                            <div id="bv-tab2" class="tab-pane fade">
                                <div class="panel-body">
                                    <input type="hidden" name="dateOfMinorCount" id="hiddenCountMinor" >
                                    <div id="selectminor">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama : <small id="val"></small></th>
                                                    <th style="width: 300px" >Pilih :</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyCheckbox"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!--Third tab-->
                            <div id="bv-tab3" class="tab-pane">
                                <div class="form-group">
                                    <div class="timeline">
                                        <div class="timeline-entry">
                                            <div class="timeline-stat">
                                                <div class="timeline-icon bg-info"><i class="fa fa-check-circle"></i></div>
                                            </div>
                                            <div class="timeline-label">
                                                <p class="mar-no pad-btm" >Jadwal akan dicopy dari : <span id="firstSum"></span> Pada Periode : <span id="periode"></span></p>
                                            </div>
                                        </div>
                                        <div class="timeline-entry">
                                            <div class="timeline-stat">
                                                <div class="timeline-icon bg-success"><i class="ti-check-box"></i></div>
                                            </div>
                                            <div class="timeline-label">
                                                <p class="mar-no pad-btm" >Kepada Staff : <span id="secondSum"></span></p>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Fourth tab-->
                            <div id="bv-tab4" class="tab-pane  mar-btm text-center">
                                <div class="load6">
                                    <div class="loader"></div>
                                    <h4>Mohon tunggu hingga proses selesai ...</h4>
                                </div>
                                <div id="information" class="hidden">
                                    <h4>Proses penyalinan jadwal telah selesai</h4>
                                    <p class="text-muted">Tekan tombol finish untuk menyelesaikan...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Footer button-->
                    <div class="panel-footer text-right">
                        <div class="box-inline">
                            <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                            <button type="button" class="next btn btn-primary" form="bv-wz-form" disabled>Next</button>
                            <button type="submit" class="finish btn btn-warning" form="bv-wz-form">Finish</button>
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
    <script src="{{asset("plugins/bootstrap-wizard/jquery.bootstrap.wizard.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-validator/bootstrapValidator.min.js")}}"></script>
    <script src="{{asset("plugins/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("js/helpers.js")}}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>

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
            var chosen;
            
            $('#bv-wz').bootstrapWizard({
                tabClass		    : 'wz-steps',
                nextSelector	    : '.next',
                previousSelector	: '.previous',
                onTabClick          : function(tab, navigation, index) {
                    return false;
                },
                onInit : function(){
                    $('#bv-wz').find('.finish').hide().prop('disabled', true);
                },
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;
                    var $percent = ($current/$total) * 100;
                    var wdt = 100/$total;
                    var lft = wdt*index;
                    var first_periode
                    var split
                    var switched_month
                    var completed
                    var tr
                    var content
                    var td
                    var checkbox
                    var botTd
                    var datas
                    var nodesradio
                    var queue = new Array();
                    var completedRadioName
                    $('#bv-wz').find('.progress-bar').css({width:wdt+'%',left:lft+"%", 'position':'relative', 'transition':'all .5s'});
                    $('.next').attr('id','ajax')
                    if($current == 1){
                            
                        $('#first_periode').on('change',function(){
                            $('#showns').show()
                            first_periode = document.getElementById('first_periode').value
                            split = first_periode.split('/'); 
                            switched_month = switch_month(split[0])
                            $('.'+switched_month).show()
                            $('#table-data tr').not('.'+switched_month).hide()
                            $('#theader').show()
                        });

                        $('.chosen-radio').on('change', function(){
                            for(chosen_inputs of chosen_input){
                                if(chosen_inputs.checked){
                                    chosen = chosen_inputs.value
                                    break;
                                }
                            };
                            $('#bv-wz').find('.next').prop('disabled', false);
                        })

                        var url = '/staff/schedule/copyschedule/calculate'
                        $('#ajax').on('click',function(e){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            $.ajax({
                                url : url,
                                type : 'POST',
                                data : {
                                    first_periode : first_periode,
                                    chosen:chosen
                                },
                                dataType:'json',
                                success : function(response){
                                    
                                    $('#bv-wz').find('.next').prop('disabled', true);

                                    for(datas in response.dataUser){
                                        completedName = response.dataUser[datas].name
                                        completedId = response.dataUser[datas].id
                                        tr = document.createElement("tr")
                                        td = document.createElement("td")
                                        botTd = document.createElement('td')
                                        checkbox = document.createElement("input")
                                        checkbox.setAttribute('type','checkbox')
                                        checkbox.setAttribute('value',completedId)
                                        checkbox.setAttribute('class','chosen-checkbox')
                                        checkbox.setAttribute('name','chosen_checkbox[]')
                                        content = document.createTextNode(completedName)
                                        td.appendChild(content)
                                        botTd.appendChild(checkbox)
                                        tr.appendChild(td)
                                        tr.appendChild(botTd)
                                        document.getElementById('tbodyCheckbox').appendChild(tr) 
                                        queue.splice(0,queue.length);
                                    }

                                    var i = 1
                                    var valminor =[];
                                    for(dataMin in response.dataMinor){
                                    var select = document.createElement('select')
                                        select.setAttribute('class','selectpicker valminor-select')
                                        select.setAttribute('data-style','btn btn-warning')
                                        select.setAttribute('name','dataMinor[]')
                                        select.setAttribute('form','bv-wz-form')
                                        select.setAttribute('style','display:inline-block !important')

                                        

                                    var dateOfMinor = document.createElement('input')
                                        dateOfMinor.setAttribute('name','date[]')
                                        dateOfMinor.setAttribute('type','hidden')
                                        dateOfMinor.setAttribute('value', response.dataMinor[dataMin].day)
                                        dateOfMinor.setAttribute('form','bv-wz-form')
                                        dateOfMinor.setAttribute('class','date-minor')
                                        var scheduleMinor = document.createTextNode(response.dataMinor[dataMin].shift)
                                        for(dataShift in response.dataShift){
                                            var shift = response.dataShift[dataShift].name
                                            var opt = document.createElement('option')
                                            opt.setAttribute('value',shift)
                                            opt.appendChild(document.createTextNode(shift))
                                            opt.text = shift
                                            select.appendChild(opt)
                                        }
                                        // opt.setAttribute('')
                                        document.getElementById('selectminor').appendChild(select)
                                        document.getElementById('selectminor').appendChild(dateOfMinor)
                                    }
                                    var dateMinor = []
                                    $('.chosen-checkbox').on('click',function(){
                                        var valueRowsName = $(this).val();
                                        if($(this).is(':checked',true)) {
                                            queue.push(valueRowsName);
                                        } else {
                                            queue.splice(queue.indexOf(valueRowsName), 1);
                                        };
                                        $('#bv-wz').find('.next').prop('disabled', false);
                                    });   
                                    var urls = '/staff/schedule/copyschedule/calculates'
                                    $('#ajax').on('click',function(e){
                                        $('.valminor-select').each(function(){
                                            valminor.push($(this).val());
                                        });
                                        $('.date-minor').each(function(){
                                            dateMinor.push($(this).val())
                                        });
                                        if(queue.length==0){
                                            Swal.fire({
                                                    width:600,
                                                    title: 'Error!',
                                                    text: "Mohon Pilih Jadwal Karyawan yang akan di salin terlebih dahulu atau Mohon Pilih Target Copy Jadwal",
                                                    icon: 'error',
                                                    }).then(()=>{
                                                            window.location.href = "";
                                                    });

                                        }
                                        var secondsum
                                        var checkboxdata
                                        var datascheckbox
                                        $.ajax({
                                            url : urls,
                                            type : 'GET',
                                            data : {
                                                chosen : chosen,
                                                checkBox_val : queue,
                                                selectorMinor : valminor,
                                                date:dateMinor
                                            },
                                            dataType:'json',
                                            success : function(response){
                                                
                                                for(datascheckbox in response.names){
                                                    checkboxdata = response.names[datascheckbox].name
                                                    queue =1
                                                    var checkboxTextnodes = document.createTextNode(checkboxdata + ", ")
                                                    document.getElementById('secondSum').appendChild(checkboxTextnodes)   
                                                }
                                                for(var nodesradioItem in response.chosenUser ){
                                                    completedRadioName = response.chosenUser[nodesradioItem].name
                                                    nodesradio = document.createTextNode(completedRadioName + ", ")
                                                    var periodeNoding = document.createTextNode(first_periode)
                                                    document.getElementById('firstSum').appendChild(nodesradio)   
                                                    document.getElementById('periode').appendChild(periodeNoding)
                                                }
                                                $('#bv-wz').find('.next').prop('disabled', false);
                                            },
                                            error : function (jXHR, textStatus, errorThrown,XMLHttpRequest) {
                                                
                                             }

                                         });
                                    });
                                },
                                error : function (jXHR, textStatus, errorThrown) {
                                
                                }
                            });
                        })
                    }
                    if($current == 3){
                        $('.next').removeAttr('id','ajax')
                    }
                    else if($current == 4) {
                        setTimeout(function () {
                            $('.load6').addClass('hidden');
                            $('#information').removeClass('hidden');
                            $('#bv-wz').find('.finish').show();
                            $('#bv-wz').find('.finish').prop('disabled', false);
                        },3000);
                    }
                    // If it's the last tab then hide the last button and show the finish instead
                    if($current >= $total) {
                        $('#bv-wz').find('.next').hide();
                    } else {
                        $('#bv-wz').find('.next').show();
                        $('#bv-wz').find('.finish').hide().prop('disabled', true);
                    }
                },
                onNext: function(tab, navigation, index){
                    isValid = null;
                    $('#bv-wz-form').bootstrapValidator('validate');
                    
                    if(isValid === false)return false;
                }
            });

            var isValid;
            $('#bv-wz-form').bootstrapValidator({
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
                }
            }).on('success.field.bv', function(e, data) {
                var $parent = data.element.parents('.form-group');

                $parent.removeClass('has-success');

                $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
            }).on('error.form.bv', function(e) {
                isValid = false;
            });      
        });
    </script>
@endsection