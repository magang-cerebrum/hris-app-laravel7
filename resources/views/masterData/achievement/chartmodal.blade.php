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
    var data = {!!json_encode($data) !!}
    
    $(document).ready(function () {
        // modal
        $(document).on('click', '#detail_staff_chart', function () {
            var name = $(this).data('name');
            var userid = $(this).data('userid');

            $('#name').text(name);
            $('#userid').text(userid);

            setTimeout(function () {
                var graph = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i].achievement_user_id == userid) {
                        graph.push(data[i]);
                    }
                }
                var score = [
                    [1, graph[0] ? graph[0].score : 0],
                    [2, graph[1] ? graph[1].score : 0],
                    [3, graph[2] ? graph[2].score : 0],
                    [4, graph[3] ? graph[3].score : 0],
                    [5, graph[4] ? graph[4].score : 0],
                    [6, graph[5] ? graph[5].score : 0],
                    [7, graph[6] ? graph[6].score : 0],
                    [8, graph[7] ? graph[7].score : 0],
                    [9, graph[8] ? graph[8].score : 0],
                    [10, graph[9] ? graph[9].score : 0],
                    [11, graph[10] ? graph[10].score : 0],
                    [12, graph[11] ? graph[11].score : 0]
                ];
                $.plot('#charts-achievement', [{
                    data: score,
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: false
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
                    colors: ['#bf0404', '#177bbb'],
                    legend: {
                        show: true,
                        position: 'nw',
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
                        content: 'Bulan: %x, Score: %y'
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
