<script>
    $(document).ready(function() {
        Chart.plugins.register(ChartDataLabels);
        var month = '10';
        var tile_2 = 'SEV';
        var tile_3 = 'SEVT';
        var tile_4 = 'Kết quả Best Practice lũy kế 2023';
        var tile_5 = 'Kết quả Best Practice tháng 10/2023';
        var tile_6 = 'BEST PRACTICE STATUS 2023';
        var tile_7 = 'SEVT KẾT QUẢ BEST PRACTICE 2023';

        var label_luy_ke = ['2022 BM', '2023', 'Q1', 'Q2', 'Q3', 'Tháng 8'];
        var label_lever = ['Level 1', 'Level 2', 'Level 3'];


        chart_mind_rate_2023("best-status-2023", tile_6, tile_7, month);
        chart_mind_rank('best-rank', tile_4, tile_5, month);
        chart_luy_ke_team_bar("luy-ke-best-team", tile_4, tile_5, month);


        function chart_mind_rate_2023(id, title_1, title_2, thang) {
            $.ajax({
                type: "GET",
                url: "mind/tab/" + id,
                dataType: "json",
                data: {
                    month: thang
                },
                success: function(users, ) {
                    // /* console.log(users); */

                    var high_status = [];
                    var common_status = [];
                    var total = [];

                    var status = users.status;
                    var result_22 = users.result_2022;
                    var result_23 = users.result_2023;

                    var common_result_22 = [];
                    var high_result_22 = [];
                    var total_22 = [];
                    var common_result_23 = [];
                    var high_result_23 = [];
                    var total_23 = [];
                    var lable_1 = [];
                    var lable_2 = [];

                    var tableData1 = [];
                    var tableData2 = [];
                    var tableData3 = [];
                    var tableData = [];
                    var data2 = [];

                    var item = ['Status', 'Common Class', 'Hight Class', 'Total'];
                    var data3 = [];

                    // Tạo mảng dữ liệu cho biểu đồ và bảng

                    $.each(status, function(index, value) {
                        high_status.push(value.high_glass);
                        common_status.push(value.common_glass);
                        total.push(value.total);
                        lable_1.push(value.team);

                        tableData1.push([
                            value.team,
                            value.common_glass,
                            value.high_glass,
                            value.total,

                        ]);
                    });

                    $.each(result_22, function(index, value) {
                        high_result_22.push(value.high_glass);
                        common_result_22.push(value.common_glass);
                        lable_2.push(value.team);
                        total_22.push(value.total);
                        tableData2.push([
                            value.team,
                            value.high_glass,
                            value.common_glass,
                            value.total,

                        ]);
                    });
                    $.each(result_23, function(index, value) {
                        high_result_23.push(value.high_glass);
                        common_result_23.push(value.common_glass);
                        total_23.push(value.total);
                        tableData3.push([
                            value.high_glass,
                            value.common_glass,
                            value.total,

                        ]);
                    });
                    var data = [];
                    for (var i = 0; i < tableData2.length; i++) {
                        data.push(tableData2[i].concat(tableData3[i]));
                    }
                    for (i = 0; i < tableData1[0].length; i++) {

                        var newrow = [];
                        for (var j = 0; j < tableData1.length; j++) {
                            newrow.push(tableData1[j][i]);
                        }
                        data2.push(newrow);
                    }

                    for (var i = 0; i < data2.length; i++) {
                        data3.push([item[i]].concat(data2[i]));
                    }

                    console.log(data3);

                    var colum = data3[0];
                    var data_table = data3.slice(1).map(function(row) {
                        var rowdata = {};
                        colum.forEach(function(colums, index) {
                            rowdata[colums] = row[index];
                        });
                        return rowdata
                    });
                    $('#text-3').text(title_1);
                    $('#text-4').text(title_2);
                    // $('#best-status').DataTable().destroy();
                    $('#best-status').DataTable({
                        data: data_table,
                        "searching": false,
                        "paging": false,
                        "info": false,
                        "select": {
                            'style': 'multi'
                        },
                        "columnDefs": [{
                            "targets": [1, 2, 3, 4, 5, 6, 7, 8, 9],
                            "render": $.fn.DataTable.render.number(',', '.', 0, ''),
                        }],
                        columns: colum.map(function(columnMane) {
                            return {
                                title: columnMane,
                                data: columnMane,
                            };
                        })


                    });

                    $('#best-lever-team').DataTable().destroy();
                    $('#best-lever-team').DataTable({
                        data: data,
                        "searching": false,
                        "paging": false,
                        "info": false,
                        "order": [6, 'desc'],
                        'autowidth': false,
                        "columnDefs": [{
                            "targets": [1, 2, 3, 4, 5, 6],
                            "render": $.fn.DataTable.render.number(',', '.', 0, ''),
                        }],

                        columns: [{
                                data: "0"
                            },
                            {
                                data: "1"
                            },
                            {
                                data: "2"
                            },
                            {
                                data: "3"
                            },
                            {
                                data: "4"
                            },
                            {
                                data: "5"
                            },
                            {
                                data: "6"
                            },

                        ]

                    });

                    var barChartData2 = {
                        labels: lable_2,
                        datasets: [{
                                label: '22-Common Class',
                                backgroundColor: '#737373',
                                stack: 'Stack 0',
                                data: common_result_22,
                                barThickness: 45,
                                datalabels: {
                                    // display:false,
                                    anchor: 'center',
                                    align: 'center',
                                    color: 'white',
                                },

                            }, {
                                label: '22-High Class',
                                backgroundColor: '#c6c6c6',
                                stack: 'Stack 0',
                                data: high_result_22,
                                barThickness: 45,
                                datalabels: {
                                    // display:false,
                                    anchor: 'start',
                                    align: 'end'
                                },


                            },
                            /*  {
                                 label: '22-Total',
                                 backgroundColor: '#fbbd00',
                                 borderColor: '#fbbd00',
                                 pointRadius: 5,
                                 stack: 'Stack 0',
                                 yAxesID: 'bar-rate',
                                 data: total_22,
                                 type: 'scatter',

                                 datalabels: {
                                     // align: 'center',
                                     anchor: 'center',
                                     font: {
                                         size: 16,

                                     },
                                     padding: 10,
                                 }
                             }, */
                            {
                                label: '23-Common Class',
                                backgroundColor: '#0066FF',
                                stack: 'Stack 1',
                                data: common_result_23,
                                barThickness: 45,
                                datalabels: {
                                    // display:false,
                                    anchor: 'center',
                                    align: 'center',
                                    color: 'white',
                                },

                            },
                            {
                                label: '23-High Class',
                                backgroundColor: '#00b0f0',
                                stack: 'Stack 1',
                                data: high_result_23,
                                barThickness: 45,
                                datalabels: {
                                    // display:false,
                                    anchor: 'start',
                                    align: 'end'
                                },
                            },
                            // {
                            //     label: '23-Total',
                            //     backgroundColor: '#fbbd00',
                            //     borderColor: '#fbbd00',
                            //     pointRadius: 5,
                            //     // stack: 'Stack 1',
                            //     // yAxesID: 'bar-rate',
                            //     data: total_23,
                            //     type: 'line',

                            //     datalabels: {
                            //         align: 'start',
                            //         // anchor: 'left',
                            //         font: {
                            //             size: 16,

                            //         },
                            //         padding: 10,
                            //     }
                            // }
                        ]


                    };
                    var barChartData1 = {
                        labels: lable_1,
                        datasets: [{
                                label: 'Common class',
                                backgroundColor: '#0066FF',
                                stack: 'Stack 0',
                                data: common_status,
                                datalabels: {
                                    display: false,
                                },
                                barThickness: 45,
                            }, {
                                label: 'high class',
                                backgroundColor: '#00b0f0',
                                stack: 'Stack 0',
                                data: high_status,
                                datalabels: {
                                    display: false,
                                },
                                barThickness: 45,


                            },
                            {
                                label: 'Total',
                                backgroundColor: '#fbbd00',
                                borderColor: '#fbbd00',
                                pointRadius: 5,
                                stack: 'Stack 0',
                                yAxesID: 'bar-rate',
                                data: total,
                                type: 'scatter',

                                datalabels: {
                                    align: 'top',
                                    anchor: 'top',
                                    font: {
                                        size: 16,

                                    },
                                    padding: 10,
                                }
                            }
                        ]


                    };

                    var ctx1 = document.getElementById('chart_besst_status_2023');
                    window.myBar1 = new Chart(ctx1, {
                        type: 'bar',
                        data: barChartData1,
                        options: {
                            plugins: {
                                datalabels: {
                                    display: true,
                                    anchor: 'end',
                                    align: 'end',
                                    font: {
                                        size: 12
                                    },
                                    formatter: function(value_person) {
                                        return value_person.toLocaleString();
                                    },
                                },
                            },
                            responsive: true,
                            maintainAspectRatio: false,

                            scales: {

                                yAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: true,
                                    },
                                    beginAtZero: true,
                                    ticks: {
                                        min: 0,
                                        max: 5000,
                                        maxTicksLimit: 6
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false,
                                    },
                                }],
                            },
                            legend: {
                                display: false,
                                position: 'bottom',
                            },
                            layout: {
                                padding: {
                                    top: 10,
                                    left: 30,
                                    right: 30,
                                    bottom: 30
                                }

                            },

                        }
                        // data: {
                        //     labels: lable_1,
                        //     datasets: [{
                        //             type: 'bar',
                        //             data: high_status,
                        //             label: 'Target',
                        //             backgroundColor: '#00b050',
                        //             borderWidth: 1,
                        //             borderColor: '#00b050',

                        //             barThickness: 27,

                        //         },
                        //         {
                        //             type: 'bar',
                        //             data: common_status,
                        //             label: 'Actual',
                        //             backgroundColor: '#0066FF',
                        //             borderWidth: 2,
                        //             borderColor: '#0066FF',

                        //             barThickness: 27,

                        //         }
                        //     ],
                        // },
                        // options: {
                        //     plugins: {
                        //         datalabels: {
                        //             display: true,
                        //             anchor: 'end',
                        //             align: 'end',
                        //             color: 'black',
                        //             font: {
                        //                 size: 12
                        //             },
                        //             formatter: function(value_person) {
                        //                 return value_person.toLocaleString();
                        //             },
                        //         },
                        //     },
                        //     responsive: true,
                        //     maintainAspectRatio: false,
                        //     elements: {
                        //         line: {
                        //             fill: false
                        //         },
                        //         point: {
                        //             hoverRadius: 7,
                        //             radius: 5
                        //         }
                        //     },
                        //     scales: {

                        //         yAxes: [{
                        //             display: false,
                        //             gridLines: {
                        //                 display: false,
                        //             },
                        //             beginAtZero: true,
                        //             ticks: {
                        //                 min: 0,
                        //                 max: 3000,
                        //             }
                        //         }],
                        //         xAxes: [{
                        //             display: true,
                        //             gridLines: {
                        //                 display: false,
                        //             },
                        //         }],
                        //     },
                        //     legend: {
                        //         display: true,
                        //         position: 'bottom',
                        //     }
                        // }
                    });
                    var ctx = document.getElementById('chart_besst_result_2023');
                    window.myBar2 = new Chart(ctx, {
                        type: 'bar',
                        data: barChartData2,
                        options: {
                            plugins: {
                                datalabels: {
                                    display: true,
                                    // anchor: 'end',
                                    // align: 'end',
                                    // color: 'black',
                                    // padding: 0,
                                    font: {
                                        size: 14
                                    },
                                    formatter: function(value_person) {
                                        return value_person.toLocaleString();
                                    },
                                },
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            elements: {
                                line: {
                                    fill: false
                                },
                                point: {
                                    hoverRadius: 7,
                                    radius: 5
                                }
                            },
                            layout: {
                                padding: {
                                    left: 30,
                                    right: 30,
                                    top: 30
                                }
                            },
                            scales: {

                                yAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: true,
                                    },
                                    stacked: true,
                                    beginAtZero: true,
                                    ticks: {
                                        min: 0,
                                        max: 5000,
                                        maxTicksLimit: 6
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false,
                                    },
                                    stacked: true,
                                }],
                            },
                            legend: {
                                display: true,
                                position: 'bottom',
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            animation: {
                                onComplate: function(animation) {

                                    var ctx = this.chart.ctx;
                                    ctx.fillStyle = 'black';
                                    xtc.textAlign = 'center';
                                    ctx.textBasseline = 'bottom';

                                    var datasets = this.data.datasets;
                                    datasets.forEach(function(dataset) {
                                        for (var i = 0; i < dataset.data
                                            .length; i++) {
                                            var mode = dataset._meta[Object
                                                .keys(dataset._meta)[0]
                                                .data[i]._model];
                                            var total = datasets.filter(ds => ds
                                                    .stack === dataset.stack)
                                                .reduce((acc, ds) => acc + ds
                                                    .data[i], 0);
                                            ctx.fillText(total, model.x, model
                                                .y - 5);
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            });
        }


        function chart_mind_rank(id, text_1, text_2, thang) {
            $.ajax({
                type: "GET",
                url: "mind/tab/" + id,
                dataType: "json",
                data: {
                    month: thang
                },
                success: function(users, ) {
                    /* console.log(users); */
                    var rank_luy_ke = users.rank_luyke;
                    var rank_august = users.rank_august;
                    var data_rank_luy_ke = [];
                    var lable_rank_luy_ke = [];
                    var data_rank_august = [];
                    var lable_august = [];


                    $.each(rank_luy_ke, function(index, value) {
                        data_rank_luy_ke.push(value.luy_ke);
                        lable_rank_luy_ke.push(value.Team);

                    });

                    $.each(rank_august, function(index, value) {
                        data_rank_august.push(value.August);
                        lable_august.push(value.Team);

                    });


                    var ctx1 = document.getElementById('chart_best_rank');
                    var Chart_luy_ke_team = new Chart(ctx1, {
                        type: 'horizontalBar',
                        data: {
                            labels: lable_rank_luy_ke,
                            datasets: [{
                                data: data_rank_luy_ke,
                                label: "Lũy Kế",
                                backgroundColor: '#0066FF',
                                borderWidth: 1,
                                borderColor: '#0066FF',
                                hoverBorderWidth: 1,
                                hoverBorderColor: '#000',
                                barThickness: 10,
                            }],
                        },

                        options: {
                            plugins: {
                                datalabels: {
                                    formatter: function(value_person) {
                                        return value_person.toLocaleString();
                                    },
                                    anchor: 'end',
                                    align: 'end',
                                    color: 'black',
                                    font: {
                                        size: 12
                                    }
                                },
                                formatter: Math.round,
                                padding: 6,

                            },
                            title: {
                                display: true,
                                text: text_1,
                                fontSize: 22,
                                padding: 30,
                            },

                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 10,
                                    top: 0,
                                    bottom: 0
                                }
                            },
                            scales: {

                                yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                    gridLines: {
                                        display: false,
                                    },
                                    minBarLength: 2,
                                }],
                                xAxes: [{
                                    display: true,
                                    barPercentage: 1,
                                    categoryPercentage: 1,
                                    gridLines: {
                                        display: false,
                                    },
                                    ticks: {
                                        display: false,
                                        callback: function(value_person) {
                                            return value_person
                                                .toLocaleString();
                                        },
                                        min: 0,
                                        max: Math.max(...data_rank_luy_ke) +
                                            (Math.max(...data_rank_luy_ke) /
                                                6),
                                        maxTicksLimit: 2
                                    },
                                }],
                            },

                            legend: {
                                display: false,
                                position: 'right',
                                labels: {
                                    fontColor: '#000'
                                }
                            },

                            tooltips: {
                                enabled: true,
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false,
                            }
                        }
                    });

                    var ctx2 = document.getElementById('chart_best_rank_august');
                    var Chart_lever_team = new Chart(ctx2, {
                        type: 'horizontalBar',
                        data: {
                            labels: lable_august,
                            datasets: [{
                                data: data_rank_august,
                                label: "August",
                                backgroundColor: '#0066FF',
                                borderWidth: 1,
                                borderColor: '#0066FF',
                                hoverBorderWidth: 1,
                                hoverBorderColor: '#000',
                                barThickness: 10,
                            }],
                        },

                        options: {
                            plugins: {
                                datalabels: {
                                    formatter: function(value_person) {
                                        return value_person.toLocaleString();
                                    },
                                    anchor: 'end',
                                    align: 'end',
                                    color: 'black',
                                    font: {
                                        size: 12
                                    }
                                },
                                formatter: Math.round,
                                padding: 6,

                            },
                            title: {
                                display: true,
                                text: text_2,
                                fontSize: 22,
                                padding: 30,
                            },

                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 10,
                                    top: 0,
                                    bottom: 0
                                }
                            },
                            scales: {

                                yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                    gridLines: {
                                        display: false,
                                    },
                                    minBarLength: 2,
                                }],
                                xAxes: [{
                                    display: true,
                                    barPercentage: 1,
                                    categoryPercentage: 1,
                                    gridLines: {
                                        display: false,
                                    },
                                    ticks: {
                                        display: false,
                                        callback: function(value_person) {
                                            return value_person
                                                .toLocaleString();
                                        },
                                        min: 0,
                                        max: 200,
                                        maxTicksLimit: 2
                                    },
                                }],
                            },

                            legend: {
                                display: false,
                                position: 'right',
                                labels: {
                                    fontColor: '#000'
                                }
                            },

                            tooltips: {
                                enabled: true,
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: false,
                            }
                        }
                    });
                }
            });
        }

        function chart_luy_ke_team_bar(id, text_1, text_2, thang) {
            $.ajax({
                type: "GET",
                url: "mind/tab/" + id,
                dataType: "json",
                data: {
                    month: thang
                },
                success: function(users) {
                    // console.log(users);
                    var data_target_2023 = [];
                    var data_actual_2023 = [];
                    var data_target_august = [];
                    var data_actual_august = [];
                    var lable_1 = [];
                    var lable_2 = [];
                    var tableData1 = [];
                    var tableData2 = [];
                    // Tạo mảng dữ liệu cho biểu đồ và bảng

                    $.each(users.years, function(index, value) {
                        data_target_2023.push(value.target);
                        data_actual_2023.push(value.actual);
                        lable_1.push(value.team);

                        tableData1.push([
                            value.team,
                            value.target,
                            value.actual,
                            value.rate,
                        ]);

                    });
                    $.each(users.month, function(index, value) {
                        data_target_august.push(value.target);
                        data_actual_august.push(value.actual);
                        lable_2.push(value.team);

                        tableData2.push([
                            value.target,
                            value.actual,
                            value.rate,
                        ]);

                    });
                    var data = [];
                    for (var i = 0; i < tableData1.length; i++) {
                        data.push(tableData1[i].concat(tableData2[i]));
                    }
                    // console.log(tableData2);
                    var ctx1 = document.getElementById('chart_best_luy_ke_team');
                    var Chart_luy_ke_team = new Chart(ctx1, {
                        type: 'bar',

                        data: {
                            labels: lable_1,
                            datasets: [{
                                    type: 'bar',
                                    data: data_target_2023,
                                    label: 'Target',
                                    backgroundColor: '#00b050',
                                    borderWidth: 1,
                                    borderColor: '#00b050',
                                    hoverBorderWidth: 2,
                                    hoverBorderColor: '#000',
                                    barThickness: 35,
                                    datalabels: {
                                        anchor: 'center',
                                        align: 'center',
                                    },


                                },
                                {
                                    type: 'bar',
                                    data: data_actual_2023,
                                    label: 'Actual',
                                    backgroundColor: '#0066FF',
                                    borderWidth: 2,
                                    borderColor: '#0066FF',
                                    hoverBorderWidth: 2,
                                    hoverBorderColor: '#000',
                                    barThickness: 35,
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'end',
                                        font: {
                                            size: 14,
                                            weight: 'bold'

                                        },

                                    }
                                }
                            ],
                        },

                        options: {
                            plugins: {
                                datalabels: {
                                    display: true,
                                    anchor: 'end',
                                    align: 'end',
                                    color: 'black',
                                    font: {
                                        size: 12
                                    },
                                    formatter: function(value_person) {
                                        return value_person.toLocaleString();
                                    },
                                },
                            },
                            layout: {
                                padding: {
                                    top: 10,
                                    left: 15,
                                    right: 15,
                                    bottom: 10
                                }

                            },
                            title: {
                                display: true,
                                text: text_1,
                                fontSize: 22,
                                padding: 30,
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            elements: {
                                line: {
                                    fill: false
                                },
                                point: {
                                    hoverRadius: 7,
                                    radius: 5
                                }
                            },
                            scales: {

                                yAxes: [{
                                    display: false,
                                    gridLines: {
                                        display: false,
                                    },
                                    // stacked:true,
                                    beginAtZero: true,
                                    ticks: {
                                        min: 0,
                                        max: Math.max(...data_actual_2023) +
                                            (Math.max(...data_actual_2023) /
                                                6),
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false,
                                    },
                                    // stacked:true,
                                }],
                            },
                            legend: {
                                display: true,
                                position: 'bottom',
                            }
                        }
                    });
                    var ctx2 = document.getElementById('chart_best_lever_team');
                    var Chart_lever_team = new Chart(ctx2, {
                        type: 'bar',

                        data: {
                            labels: lable_1,
                            datasets: [{
                                    type: 'bar',
                                    data: data_target_august,
                                    label: 'Target',
                                    backgroundColor: '#00b050',
                                    borderWidth: 1,
                                    borderColor: '#00b050',
                                    hoverBorderWidth: 2,
                                    hoverBorderColor: '#000',
                                    barThickness: 35,
                                    datalabels: {
                                        anchor: 'center',
                                        align: 'center',
                                    },


                                },
                                {
                                    type: 'bar',
                                    data: data_actual_august,
                                    label: 'Actual',
                                    backgroundColor: '#0066FF',
                                    borderWidth: 2,
                                    borderColor: '#0066FF',
                                    hoverBorderWidth: 2,
                                    hoverBorderColor: '#000',
                                    barThickness: 35,
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'end',
                                        font: {
                                            size: 14,
                                            weight: 'bold'

                                        },

                                    }

                                },
                            ],
                        },

                        options: {
                            plugins: {
                                datalabels: {
                                    display: true,
                                    anchor: 'end',
                                    align: 'end',
                                    color: 'black',
                                    font: {
                                        size: 12
                                    },
                                    formatter: function(data) {
                                        return data.toLocaleString();
                                    },
                                },
                            },
                            layout: {
                                padding: {
                                    top: 10,
                                    left: 15,
                                    right: 15,
                                    bottom: 10
                                }

                            },
                            title: {
                                display: true,
                                text: text_2,
                                fontSize: 22,
                                padding: 30,
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            elements: {
                                line: {
                                    fill: false
                                },
                                point: {
                                    hoverRadius: 7,
                                    radius: 5
                                }
                            },
                            scales: {

                                yAxes: [{
                                    display: false,
                                    gridLines: {
                                        display: false,
                                    },
                                    beginAtZero: true,
                                    stick: {
                                        min: 0,
                                        max: 25000,
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false,
                                    },
                                }],
                            },
                            legend: {
                                display: true,
                                position: 'bottom',
                            }
                        }
                    });
                    $('#best-team').DataTable().destroy();
                    $('#best-team').DataTable({
                        data: data,
                        "searching": false,
                        "paging": false,
                        "info": false,

                        "order": [2, 'desc'],
                        "columnDefs": [{
                                "targets": [3, 6],
                                "render": function(data, type, row) {
                                    if (type == 'display') {
                                        return data + '%';
                                    }
                                    return data;
                                }
                            },

                            {
                                "targets": [1, 2, 4, 5],
                                "render": $.fn.DataTable.render.number(',', '.', 0,
                                    ''),
                            }
                        ],

                        columns: [{
                                data: "0"
                            },
                            {
                                data: "1"
                            },
                            {
                                data: "2"
                            },
                            {
                                data: "3"
                            },
                            {
                                data: "4"
                            },
                            {
                                data: "5"
                            },
                            {
                                data: "6"
                            }
                        ]
                    });
                }
            });
        }

    });
</script>
