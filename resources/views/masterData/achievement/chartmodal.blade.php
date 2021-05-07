<!-- modal -->
<div class="modal fade" id="modal-detail-staff-chart" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h5 class="modal-title text-bold text-center">Grafik Penilaian "<span id="name"></span>" Tahun <?=date('Y')?></h5>
            </div>
            <div class="modal-body">
                <div id="charts-achievement"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
<script>
    var d_score = {!!json_encode($score) !!}
    var d_average = {!!json_encode($average) !!}
    var d_max = {!!json_encode($max) !!}
    var d_min = {!!json_encode($min) !!}
    
    $(document).ready(function () {
        // modal
        $(document).on('click', '#detail_staff_chart', function () {
            var name = $(this).data('name');
            var userid = $(this).data('userid');

            $('#name').text(name);
            $('#userid').text(userid);

            setTimeout(function () {
                var score = [
                    [1, d_score[0] ? d_score[0][userid] : 0],
                    [2, d_score[1] ? d_score[1][userid] : 0],
                    [3, d_score[2] ? d_score[2][userid] : 0],
                    [4, d_score[3] ? d_score[3][userid] : 0],
                    [5, d_score[4] ? d_score[4][userid] : 0],
                    [6, d_score[5] ? d_score[5][userid] : 0],
                    [7, d_score[6] ? d_score[6][userid] : 0],
                    [8, d_score[7] ? d_score[7][userid] : 0],
                    [9, d_score[8] ? d_score[8][userid] : 0],
                    [10, d_score[9] ? d_score[9][userid] : 0],
                    [11, d_score[10] ? d_score[10][userid] : 0],
                    [12, d_score[11] ? d_score[11][userid] : 0]
                ];
                var average = [
                    [1, d_average[0]],
                    [2, d_average[1]],
                    [3, d_average[2]],
                    [4, d_average[3]],
                    [5, d_average[4]],
                    [6, d_average[5]],
                    [7, d_average[6]],
                    [8, d_average[7]],
                    [9, d_average[8]],
                    [10, d_average[9]],
                    [11, d_average[10]],
                    [12, d_average[11]]
                ];
                var max = [
                    [1, d_max[0]],
                    [2, d_max[1]],
                    [3, d_max[2]],
                    [4, d_max[3]],
                    [5, d_max[4]],
                    [6, d_max[5]],
                    [7, d_max[6]],
                    [8, d_max[7]],
                    [9, d_max[8]],
                    [10, d_max[9]],
                    [11, d_max[10]],
                    [12, d_max[11]]
                ];
                var min = [
                    [1, d_min[0]],
                    [2, d_min[1]],
                    [3, d_min[2]],
                    [4, d_min[3]],
                    [5, d_min[4]],
                    [6, d_min[5]],
                    [7, d_min[6]],
                    [8, d_min[7]],
                    [9, d_min[8]],
                    [10, d_min[9]],
                    [11, d_min[10]],
                    [12, d_min[11]]
                ];

                $.plot('#charts-achievement', [{
                    data: score,
                    label: 'Score',
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.5
                            }, {
                                opacity: 0.5
                            }]
                        }
                    },
                    points: {
                        show: true,
                        radius: 4,
                    }
                }, {
                    data: average,
                    label: 'Rata-rata',
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: false,
                        // fillColor: {
                        //     colors: [{
                        //         opacity: 0.5
                        //     }, {
                        //         opacity: 0.5
                        //     }]
                        // }
                    },
                    points: {
                        show: true,
                        radius: 4,
                    }
                }, {
                    data: max,
                    label: 'Max',
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: false,
                        // fillColor: {
                        //     colors: [{
                        //         opacity: 0.5
                        //     }, {
                        //         opacity: 0.5
                        //     }]
                        // }
                    },
                    points: {
                        show: true,
                        radius: 4,
                    }
                }, {
                    data: min,
                    label: 'Min',
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: false,
                        // fillColor: {
                        //     colors: [{
                        //         opacity: 0.5
                        //     }, {
                        //         opacity: 0.5
                        //     }]
                        // }
                    },
                    points: {
                        show: true,
                        radius: 4,
                    }
                }, ], {
                    series: {
                        lines: {
                            show: true
                        },
                        points: {
                            show: true,
                        },
                        shadowSize: 0
                    },
                    colors: ['#bf0404', '#177bbb','#19e331','#ed7a07'],
                    legend: {
                        show: true,
                        position: 'ne',
                        margin: [15, 0]
                    },
                    grid: {
                        borderWidth: 0,
                        hoverable: true,
                        clickable: true
                    },
                    yaxis: {
                        ticks: 9,
                        min: 0,
                        max: 100,
                        tickColor: 'rgba(0,0,0,.1)'
                    },
                    xaxis: {
                        ticks: [
                            [1, 'Januari'],
                            [2, 'Februari'],
                            [3, 'Maret'],
                            [4, 'April'],
                            [5, 'Mei'],
                            [6, 'Juni'],
                            [7, 'Juli'],
                            [8, 'Agustus'],
                            [9, 'September'],
                            [10, 'Oktober'],
                            [11, 'November'],
                            [12, 'Desember']
                        ],
                        tickColor: 'transparent'
                    },
                    tooltip: {
                        show: true,
                        content: 'Bulan: %x, Score: %y.1',
                    }
                });
            },200);
        });
    });

    // live search
    function search_staff() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("cari-staff");
        filter = input.value.toUpperCase();
        table = document.getElementById("masterdata-chart-staff");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            for (j = 2; j < 3; j++) {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }

</script>
