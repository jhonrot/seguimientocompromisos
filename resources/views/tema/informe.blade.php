    
@extends('layouts.app')

@section('libraries_add')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('js/select2.min.js')}}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{asset('js/functions_dinamics.js')}}"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="{{asset('js/drilldown.js')}}"></script>
    <script src="{{asset('js/exporting.js')}}"></script>
    <script src="{{asset('js/export-data.js')}}"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12" >
            <a href="{{ route('temas.data_inform',['item1'=>0,'item2'=>0,'item3'=>0]) }}" id="lia_page_inform" onclick="loader_function()" >/Informe</a>
        </div>
    </div><br>

    <div class="row">
        <div class="col-sm-12" align="center" >
            <h1><b>Informe</b></h1>
        </div>
    </div><br>

    <form class="row" action="javascript:search_inform_graphic('{{ route('temas.data_inform',['item1'=>0,'item2'=>0,'item3'=>0]) }}')" method="GET">
        <div class="col-sm-12" >
            <div class="form-group">
                <label class="glyphicon glyphicon-search"><b> Buscar por </b></label>
                <select class="form-control" id="select_search_item" name="select_search_item" onchange="change_select_item('{{ route('temas.formSearch')}}')">
                    <option value="4">General</option>
                    <option value="1">Por Descripción de compromiso</option>
                    <option value="5">Por Responsable</option>
                    <option value="6">Por Clasificación</option>
                    <option value="2">Por fecha inicio</option>
                    <option value="3">Por fecha cumplimiento</option>
                </select>
            </div>
        </div><br><br>

        <span id="input_search_item"></span><br><br>

        <div class="row">
            <center>
                <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Generar</b></button>
            </center>
        </div>
    </form><br><br>

    <div class="row" id="content_table_data">
        <div class="col-sm-12" align="center"><h1><b>Estado descripción de compromiso<b></h1></div>
        <div class="col-sm-12">
            <a class="btn" style="float:right;" id="btnExportar_tabla_estado_temas" ><span class="glyphicon glyphicon-download-alt"></span> Exportar</a>
        </div><br>
        <div class="col-sm-12 table-responsive table-striped" >
            <table class="table table-bordered tablas" id="tabla_estado_temas">
                <thead>
                    <tr style="background-color: #b5b0b0;" >
                        <th>Estado descripción de compromiso</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($state) <=0)
                        <tr>
                            <td align="center" colspan="2"><b>No hay registros</b></td>
                        </tr>
                    @else
                        @php $total_temas_estado = 0; $i=-1; @endphp
                        @foreach($state as $st)
                            @php $total_temas_estado = ($total_temas_estado + $st['y']); $i++; @endphp
                            <tr>
                                <td><b>{{$st['name']}}</b></td>
                                <td>
                                    @if($st['y'] > 0)
                                        <a href="javascript:show_table({{$i}},1)"><b>{{$st['y']}}</b></a>
                                    @else
                                        {{$st['y']}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr style="background-color: #dbd7d7;">
                            <td><b>Total</b></td>
                            <td><b>{{$total_temas_estado}}</b></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" id="content_table_data0" style="display:none;">
        <div class="col-sm-12" align="center"><h1><b>Temas Cumplidos<b></h1></div>
        <div class="col-sm-12">
            <a class="btn" style="float:right;" id="atras0" href="javascript:show_table(0,0)" ><span class="glyphicon glyphicon-arrow-left"></span> Volver</a>
            <a class="btn" style="float:right;" id="btnExportar_tabla_cumplidos" ><span class="glyphicon glyphicon-download-alt"></span> Exportar</a>
        </div><br>
        <div class="col-sm-12 table-responsive table-striped" >
            <table class="table table-bordered tablas" id="tabla_estado_cumplidos">
                <thead>
                    <tr style="background-color: #55b940;" >
                        <th>Tema</th>
                        <th>Fecha inicio</th>
                        <th>Fecha maxima finalización</th>
                        <th>Clasificación</th>
                        <th>Organismo</th>
                        <th>Responsable(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($temas[0]['data'] as $them)
                        <tr>
                            <td><b>{{$them[0]}}</b></td>
                            <td><b>{{$them[2]}}</b></td>
                            <td><b>{{$them[3]}}</b></td>
                            <td><b>{{$them[4]}}</b></td>
                            <td><b>{{$them[5]}}</b></td>
                            <td><b>{{$them[6]}}</b></td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #55b940;">
                        <td colspan="5"><b>Total</b></td>
                        <td><b>{{count($temas[0]['data'])}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" id="content_table_data1" style="display:none;" >
        <div class="col-sm-12" align="center"><h1><b>Temas Cumplidos fuera de la fecha<b></h1></div>
        <div class="col-sm-12">
            <a class="btn" style="float:right;" id="atras1" href="javascript:show_table(1,0)" ><span class="glyphicon glyphicon-arrow-left"></span> Volver</a>
            <a class="btn" style="float:right;" id="btnExportar_tabla_cumplidos_fuera" ><span class="glyphicon glyphicon-download-alt"></span> Exportar</a>
        </div><br>
        <div class="col-sm-12 table-responsive table-striped" >
            <table class="table table-bordered tablas" id="tabla_estado_cumplidos_fuera">
                <thead>
                    <tr style="background-color: #ef6f6f;" >
                        <th>Tema</th>
                        <th>Fecha inicio</th>
                        <th>Fecha maxima finalización</th>
                        <th>Clasificación</th>
                        <th>Organismo</th>
                        <th>Responsable(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($temas[1]['data'] as $them)
                        <tr>
                            <td><b>{{$them[0]}}</b></td>
                            <td><b>{{$them[2]}}</b></td>
                            <td><b>{{$them[3]}}</b></td>
                            <td><b>{{$them[4]}}</b></td>
                            <td><b>{{$them[5]}}</b></td>
                            <td><b>{{$them[6]}}</b></td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #ef6f6f;">
                        <td colspan="5"><b>Total</b></td>
                        <td><b>{{count($temas[1]['data'])}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" id="content_table_data2" style="display:none;" >
        <div class="col-sm-12" align="center"><h1><b>Temas Incumplidos<b></h1></div>
        <div class="col-sm-12">
            <a class="btn" style="float:right;" id="atras2" href="javascript:show_table(2,0)" ><span class="glyphicon glyphicon-arrow-left"></span> Volver</a>
            <a class="btn" style="float:right;" id="btnExportar_tabla_incumplidos" ><span class="glyphicon glyphicon-download-alt"></span> Exportar</a>
        </div><br>
        <div class="col-sm-12 table-responsive table-striped" >
            <table class="table table-bordered tablas" id="tabla_estado_incumplidos">
                <thead>
                    <tr style="background-color: red;" >
                        <th>Tema</th>
                        <th>Fecha inicio</th>
                        <th>Fecha maxima finalización</th>
                        <th>Clasificación</th>
                        <th>Organismo</th>
                        <th>Responsable(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($temas[2]['data'] as $them)
                        <tr>
                            <td><b>{{$them[0]}}</b></td>
                            <td><b>{{$them[2]}}</b></td>
                            <td><b>{{$them[3]}}</b></td>
                            <td><b>{{$them[4]}}</b></td>
                            <td><b>{{$them[5]}}</b></td>
                            <td><b>{{$them[6]}}</b></td>
                        </tr>
                    @endforeach
                    <tr style="background-color: red;">
                        <td colspan="5"><b>Total</b></td>
                        <td><b>{{count($temas[2]['data'])}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" id="content_table_data3" style="display:none;" >
        <div class="col-sm-12" align="center"><h1><b>Temas Pendientes<b></h1></div>
        <div class="col-sm-12">
            <a class="btn" style="float:right;" id="atras3" href="javascript:show_table(3,0)" ><span class="glyphicon glyphicon-arrow-left"></span> Volver</a>
            <a class="btn" style="float:right;" id="btnExportar_tabla_pendientes" ><span class="glyphicon glyphicon-download-alt"></span> Exportar</a>
        </div><br>
        <div class="col-sm-12 table-responsive table-striped" >
            <table class="table table-bordered tablas" id="tabla_estado_pendientes">
                <thead>
                    <tr style="background-color: #fbb83c;" >
                        <th>Tema</th>
                        <th>Fecha inicio</th>
                        <th>Fecha maxima finalización</th>
                        <th>Clasificación</th>
                        <th>Organismo</th>
                        <th>Responsable(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($temas[3]['data'] as $them)
                        <tr>
                            <td><b>{{$them[0]}}</b></td>
                            <td><b>{{$them[2]}}</b></td>
                            <td><b>{{$them[3]}}</b></td>
                            <td><b>{{$them[4]}}</b></td>
                            <td><b>{{$them[5]}}</b></td>
                            <td><b>{{$them[6]}}</b></td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #fbb83c;">
                        <td colspan="5"><b>Total</b></td>
                        <td><b>{{count($temas[3]['data'])}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><br><br>

    <div class="row">
        <div class="col-sm-12 table-responsive table-striped" id="content_space" >
        </div>
    </div>

    <script>
        $(".li_base").removeClass("active");
        document.getElementById("li_seguimiento_temas").className = "active";

        document.getElementById("lia_page_inform").className = "li_drown";
        document.getElementById('lia_page_inform').style.color = 'white';

        $("#loading").html("<div class='pre_carga' id='modal_carga' ></div>");

        $(window).on('load', function(){
            $("#loading").html("");
        });

        order_select_item('{{$item1}}','{{$item2}}','{{$item3}}','{{ route('temas.formSearch')}}');

        const $btnExportar = document.querySelector("#btnExportar_tabla_estado_temas"),
            $tabla_estado_temas = document.querySelector("#tabla_estado_temas");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla_estado_temas, {
                exportButtons: false, // No queremos botones
                filename: "EstadoTemas", //Nombre del archivo de Excel
                sheetname: "EstadoTemas", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla_estado_temas.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });

        const $btnExportar2 = document.querySelector("#btnExportar_tabla_cumplidos"),
            $tabla_estado_cumplidos = document.querySelector("#tabla_estado_cumplidos");
        
        $btnExportar2.addEventListener("click", function() {
            let tableExport = new TableExport($tabla_estado_cumplidos, {
                exportButtons: false, // No queremos botones
                filename: "TemasCumplidos", //Nombre del archivo de Excel
                sheetname: "TemasCumplidos", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla_estado_cumplidos.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });

        const $btnExportar3 = document.querySelector("#btnExportar_tabla_cumplidos_fuera"),
            $tabla_estado_cumplidos_fuera = document.querySelector("#tabla_estado_cumplidos_fuera");
        
        $btnExportar3.addEventListener("click", function() {
            let tableExport = new TableExport($tabla_estado_cumplidos_fuera, {
                exportButtons: false, // No queremos botones
                filename: "TemasCumplidosPorFuera", //Nombre del archivo de Excel
                sheetname: "TemasCumplidosPorFuera", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla_estado_cumplidos_fuera.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });

        const $btnExportar4 = document.querySelector("#btnExportar_tabla_incumplidos"),
            $tabla_estado_incumplidos = document.querySelector("#tabla_estado_incumplidos");
        
        $btnExportar4.addEventListener("click", function() {
            let tableExport = new TableExport($tabla_estado_incumplidos, {
                exportButtons: false, // No queremos botones
                filename: "TemasIncumplidos", //Nombre del archivo de Excel
                sheetname: "TemasIncumplidos", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla_estado_incumplidos.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });

        const $btnExportar5 = document.querySelector("#btnExportar_tabla_pendientes"),
            $tabla_estado_pendientes = document.querySelector("#tabla_estado_pendientes");
        
        $btnExportar5.addEventListener("click", function() {
            let tableExport = new TableExport($tabla_estado_pendientes, {
                exportButtons: false, // No queremos botones
                filename: "TemasPendientes", //Nombre del archivo de Excel
                sheetname: "TemasPendientes", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla_estado_pendientes.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
        
        // Create the chart
        Highcharts.chart('content_space', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Informe Temas'
            },
            subtitle: {
                text: 'Click en la columnas para ver los detalles</a>'
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
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> temas<br/>'
            },

            series: [
                {
                    name: "Estado tema",
                    colorByPoint: true,
                    data: <?= json_encode($state) ?>
                }
            ],
            drilldown: {
                series: <?= json_encode($temas) ?>
            }
        });
    </script>
        
@endsection