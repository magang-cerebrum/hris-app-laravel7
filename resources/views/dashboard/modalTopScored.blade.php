<div class="modal fade" id="modal-detail-top-scored" tabindex="-1" role="dialog" style="overflow-x: auto !important">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">All Staff Top Scored <span id="type-modal"></span></h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive" style="height: 375px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Posisi</th>
                                <th class="text-center">Nama Karyawan</th>
                                <th class="text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody id="table-performance">
                            @if ($monthDecidePerformance)
                                @for ($i = 0; $i < count($monthDecidePerformance); $i++)
                                <tr
                                    @if($i == 0)
                                        class="text-bold"
                                        style="color: #FFD700;
                                    @elseif($i == 1)
                                        class="text-bold"
                                        style="color: #C0C0C0;
                                    @elseif($i == 2)
                                        class="text-bold"
                                        style="color: #CD7F32;
                                    @endif

                                    @if($monthDecidePerformance[$i]->name == Auth::user()->name)
                                        background-color: rgba(139, 195, 74, 0.4); 
                                        font-size: 16px;"
                                    @else
                                        "
                                    @endif
                                >
                                    <td class="text-center"><span id="{{'p_rank_' . $i}}"></span></td>
                                    <td class="text-center"><span id="{{'p_name_' . $i}}"></td>
                                    <td class="text-center text-bold"><span id="{{'p_score_' . $i}}"></td>
                                </tr>
                                @endfor
                            @endif
                        </tbody>
                        <tbody id="table-achievement">
                            @if ($monthDecideAchievement)
                                @for ($i = 0; $i < count($monthDecideAchievement); $i++)
                                <tr
                                    @if($i == 0)
                                        class="text-bold"
                                        style="color: #FFD700;
                                    @elseif($i == 1)
                                        class="text-bold"
                                        style="color: #C0C0C0;
                                    @elseif($i == 2)
                                        class="text-bold"
                                        style="color: #CD7F32;
                                    @endif

                                    @if($monthDecideAchievement[$i]->name == Auth::user()->name)
                                        background-color: rgba(139, 195, 74, 0.4); 
                                        font-size: 16px;"
                                    @else
                                        "
                                    @endif
                                >
                                    <td class="text-center"><span id="{{'a_rank_' . $i}}"></span></td>
                                    <td class="text-center"><span id="{{'a_name_' . $i}}"></td>
                                    <td class="text-center text-bold"><span id="{{'a_score_' . $i}}"></td>
                                </tr>
                                @endfor
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