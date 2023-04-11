@extends('layouts.app')

<style>
    .embed-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }
    .embed-container iframe {
        position: absolute;
        top:0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
    
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->

@section('content')
@php
    $cont_tiempo = 0;
    $cont_proximo = 0;
    $cont_vencido = 0;
    $a_tiempo = [];
    $proximo_vencer = [];
    $vencido = [];
@endphp



@foreach($compromisos as $tema)
    @php
        $date1 = new DateTime(date('Y-m-d'));
        $date2 = new DateTime($tema->fecha_cumplimiento);
        $dias_cant = ($date1->diff($date2))->format("%r%a");
    @endphp
    <!-- a tiempo -->
    @if($tema->estado_id == 1 && $dias_cant > 15)
        @php
            $a_tiempo[] = ['name'=>$tema['tema'], 'y'=>intval(10)];
            $cont_tiempo++;
        @endphp
    @endif
    <!-- proximo a vencer -->
    @if($tema->estado_id == 1 && $dias_cant < 15)
        @php
            $proximo_vencer[] = ['name'=>$tema['tema'], 'y'=>intval(10)];
            $cont_proximo++;
        @endphp
    @endif
    <!-- vencidos -->
    @if($tema->estado_id == 1 && $dias_cant < 0)
        @php
            $vencido[] = ['name'=>$tema['tema'], 'y'=>intval(10)];
            $cont_vencido++;
        @endphp
    @endif
@endforeach

@php
    $totalCom = $cont_tiempo + $cont_proximo + $cont_vencido + $estado3;
@endphp

<div class="row">
    <div class="col-sm-12">
        <a>/Temas</a><a href="{{ route('seguimientos.index') }}" id="lia_page_seguimiento" onclick="loader_function()"></a>
    </div>
</div>
<br>

<script type="text/javascript">
    function mostrar(id) {
        if (id == "container1") {
            $("#container1").show();
            $("#container2").hide();
            $("#container3").hide();
            $("#container5").hide();
        }

        if (id == "container2") {
            $("#container1").hide();
            $("#container2").show();
            $("#container3").hide();
            $("#container5").hide();
        }

        if (id == "container3") {
            $("#container1").hide();
            $("#container2").hide();
            $("#container3").show();
            $("#container5").hide();
        }

        if (id == "container5") {
            $("#container1").hide();
            $("#container2").hide();
            $("#container3").hide();
            $("#container5").show();
        }
    }
</script>
<br><br>

<div class="row">
    <div class="col-sm-12 embed-container" align="center">
        <iframe id="iframe_dashboard1" src="https://app.powerbi.com/view?r=eyJrIjoiN2M1MzNlOGUtNTcxYi00NzM4LTlhYzgtNTk1YjAxNDFkMzYwIiwidCI6ImY1MGQxZTE3LTlkODItNGVlZi1hMTdmLWFkNWY1ZjljZjJiNCJ9" frameborder="0" allowFullScreen ></iframe>
    </div>
</div>
<br>

<h5 style="font-weight: bold;">Reporte Por:</h5>
<div class="col-sm-4" id="div_select_search">
    <select class="form-control" id="select_section" name="select_section" onchange="mostrar(this.value)" ;>
        <option value="container1">Compromisos</option>
        <option value="container2">Organismos</option>
        <option value="container3">Responsables</option>
        <option value="container5">Equipos de trabajo</option>
    </select>
</div>
<br>

<div class="row">
    <div class="col-sm-12" align="center">
        <h1><b>Dashboard</b></h1>
    </div>
</div>
<br>

    
<div id="container1" style="display: show;">
    <div class="row">
        <div class="col-sm-12" align="center">
            <h1><b>Estado Compromisos</b></h1>
        </div>
    </div>
    <br>

    <table class="table table-responsive table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col">Estado</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Cumplidos</th>
                <td>{{$estado3}}</td>
            </tr>
            <tr>
                <th scope="row">A tiempo</th>
                <td>{{$cont_tiempo}}</td>

            </tr>
            <tr>
                <th scope="row">Proximo a vencer</th>
                <td>{{$cont_proximo}}</td>
            </tr>
            <tr>
                <th scope="row">Vencidos</th>
                <td>{{$cont_vencido}}</td>
            </tr>
            <tr>
                <th scope="row">Total</th>
                <td>{{$totalCom}}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-responsive table-bordered table-sm" style="display:none">
        <thead>
            <tr>
                <th scope="col">Estado</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">Cumplidos</th>
                <td>{{$estado3}}</td>
            </tr>
            <tr>
                <th scope="row">Cumplidos fuera de la fecha</th>
                <td>{{$fueraFecha}}</td>

            </tr>
            <tr>
                <th scope="row">Incumplidos</th>
                <td>{{$estado1}}</td>
            </tr>
            <tr>
                <th scope="row">Pendientes</th>
                <td>{{$estado2}}</td>
            </tr>
            <tr>
                <th scope="row">Total</th>
                <td>{{$total}}</td>
            </tr>
        </tbody>
    </table>

    <!-- Incluimos el grafico -->

    <div class="container mt-10">
        <div class="row">
            <div class="col">
                <div id="container"></div>
            </div>
        </div>
    </div>

    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Estadisticas de Compromisos'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> de total<br/>'
            },

            series: [{
                name: "Estados",
                colorByPoint: true,
                data: [{
                        name: "Cumplidos",
                        y: <?= $estado3 ?>,
                        drilldown: "Cumplidos"
                    },
                    {
                        name: "A tiempo",
                        y: <?= $cont_tiempo ?>,
                        drilldown: "A tiempo"
                    },
                    {
                        name: "Proximo a vencer",
                        y: <?= $cont_proximo ?>,
                        drilldown: "Proximo a vencer"
                    },
                    {
                        name: "Vencidos",
                        y: <?= $cont_vencido ?>,
                        drilldown: "Vencidos"
                    },
                    {
                        name: "Total",
                        y: <?= $totalCom ?>,
                        drilldown: "Total"
                    },

                ]
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [{
                        name: "Cumplidos",
                        id: "Cumplidos",
                        data: <?= $cumplidos ?>
                    },
                    {
                        name: "A tiempo",
                        id: "A tiempo",
                        data: <?= json_encode($a_tiempo) ?>
                    },
                    {
                        name: "Proximo a vencer",
                        id: "Proximo a vencer",
                        data: <?= json_encode($proximo_vencer) ?>
                    },
                    {
                        name: "Vencidos",
                        id: "Vencidos",
                        data: <?= json_encode($vencido) ?>
                    }
                ]
            }
        });
        
        /*Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Estadisticas de Compromisos'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cantidad'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> de total<br/>'
            },

            series: [{
                name: "Estados",
                colorByPoint: true,
                data: [{
                        name: "Cumplidos",
                        y: <?= $estado3 ?>,
                        drilldown: "Cumplidos"
                    },
                    {
                        name: "Cumplidos fuera de la fecha",
                        y: <?= $fueraFecha ?>,
                        drilldown: "Cumplidos fuera de la fecha"
                    },
                    {
                        name: "Incumplidos",
                        y: <?= $estado1 ?>,
                        drilldown: "Incumplidos"
                    },
                    {
                        name: "Pendientes",
                        y: <?= $estado2 ?>,
                        drilldown: "Pendientes"
                    },
                    {
                        name: "Total",
                        y: <?= $total ?>,
                        drilldown: "Total"
                    },

                ]
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [{
                        name: "Cumplidos",
                        id: "Cumplidos",
                        data: <?= $cumplidos ?>
                    },
                    {
                        name: "Cumplidos fuera de la fecha",
                        id: "Cumplidos fuera de la fecha",
                        data: <?= $fechaFuera ?>
                    },
                    {
                        name: "Incumplidos",
                        id: "Incumplidos",
                        data: <?= $incumplidos ?>
                    },
                    {
                        name: "Pendientes",
                        id: "Pendientes",
                        data: <?= $pendientes ?>
                    }
                ]
            }
        });*/
    </script>
</div>

<div id="container2" style="display: none;">
    <div class="row">
        <div class="col-sm-12" align="center">
            <h1><b>Organismos</b></h1>
        </div>
    </div>
    <br>
    <table class="table table-responsive table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col">Organismo</th>
                <th scope="col">Cantidad de compromisos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organismos as $organismo)
                @php
                    $cantCompromisos = 0;
                @endphp
                @foreach($organismo->users as $userOrg)
                    @php
                        $cantCompromisos =($cantCompromisos+count($userOrg->temas));
                    @endphp
                @endforeach
            <tr>
                <td>{{$organismo->name}}</td>
                <td>{{$cantCompromisos}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Incluimos el grafico -->

    <div class="container mt-10">
        <div class="row">
            <div class="col">
                <div id="containerOrg"></div>
            </div>
        </div>
    </div>

    <script>
        Highcharts.chart('containerOrg', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Estadisticas de Responsables'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Compromisos Asignados'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> de total<br/>'
            },

            series: [{
                name: "Organismo",
                colorByPoint: true,
                data: <?= $organismosCol ?>
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: <?= $temasUser?>   
            }
        });
        
    </script>
</div>

    
<div id="container3" style="display: none;">
    <div class="row">
        <div class="col-sm-12" align="center">
            <h1><b>Responsables</b></h1>
        </div>
    </div>
    <br>
    <table class="table table-responsive table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col">Responsable</th>
                <th scope="col">Cantidad de compromisos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cantCompUser as $user)
            @if(count($user->temas)>0)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{count($user->temas)}}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <!-- Incluimos el grafico -->

    <div class="container mt-10">
        <div class="row">
            <div class="col">
                <div id="containerRes"></div>
            </div>
        </div>
    </div>

    <script>
        Highcharts.chart('containerRes', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Estadisticas de Responsables'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Compromisos Asignados'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> de total<br/>'
            },

            series: [{
                name: "Responsables",
                colorByPoint: true,
                data: <?= $responsables ?>
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: <?= $temasUser?>   
            }
        });
        
    </script>
</div>

<div id="container5" style="display: none;">
    <div class="row">
        <div class="col-sm-12" align="center">
            <h1><b>Equipos de trabajo</b></h1>
        </div>
    </div>
    <br>
    <table class="table table-responsive table-bordered table-sm">
        <thead>
            <tr>
                <th scope="col">Equipo de trabajo</th>
                <th scope="col">Cantidad de usuarios</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipotrabajo as $equipo)
            <tr>
                <td>{{$equipo->descripcion}}</td>
                <td>{{count($equipo->users)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Incluimos el grafico -->

    <div class="container mt-10">
        <div class="row">
            <div class="col">
                <div id="containerEquipo"></div>
            </div>
        </div>
    </div>

    <script>
        Highcharts.chart('containerEquipo', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Estadisticas de Responsables'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Compromisos Asignados'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        // format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> de total<br/>'
            },

            series: [{
                name: "Equipo de trabajo",
                colorByPoint: true,
                data: <?= $equipos ?>
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: <?= $userEquipos?>   
            }
        });
        
        function zoom(){ 
            document.getElementById("iframe_dashboard1").contentWindow.document.getElementById("fitToPageButton").click();
            //.contentWindow.document.
            //document.getElementById('fitToPageButton').click();
            console("Hola");
        }
        zoom();
    </script>
    
    <script type="text/javascript" language="JavaScript" >
    $(document).ready( function () {
        $('#iframe_dashboard1').load( function () {
            //var iframe_dos = document.getElementById('iframe_dashboard1');
            //var button_dos = iframe.contents().find('#zoomOutButton');
            //button_dos.trigger("click");
            //zoom();
            console("Hola");
            //$(this).contents().find(".fondo").css({'background-color':'#fff','background-image':'none'});
        });
    });
    </script>
    
</div>

@endsection