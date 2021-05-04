<div class="modal fade" id="modal-detail-top-scored-performance" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">All Staff Top Scored Performance</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height: 375px">
                    <table class="table table-striped" >
                        <thead>
                            <tr>
                                <td class="text-center">Posisi</td>
                                <td class="text-center">Nama Karyawan</td>
                                <td class="text-center">Skor</td>
                            </tr>
                        </thead>
                        <tbody>
                            
                        @if ($monthDecidePerformance)
                            @foreach ($monthDecidePerformance as $mdpItem)
                               <tr>
                                    <td class="text-center"> {{$loop->iteration}}</td>
                                    <td class="text-center">{{$mdpItem->name}}</td> 
                                    <td class="text-center text-semibold" style="
                                    @if ($loop->iteration == 1)
                                        color : #FFD700;
                                    @elseif($loop->iteration == 2)
                                        color:#C0C0C0;
                                    @elseif($loop->iteration == 3)
                                        color:#cd7f32;
                                    @else
                                        color:#800000
                                    @endif
                                    ">
                                        
                                        {{$mdpItem->performance_score}}
                                    </td>
                                </tr>
                            @endforeach
                    @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>