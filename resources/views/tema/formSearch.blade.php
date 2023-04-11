
    <form action="javascript: url_new_tab('{{ route('temas.printForm',['item1'=>0,'item2'=>0,'item3'=>0]) }}')" class="row" >
        <div class="col-sm-12" >
            <div class="form-group">
                <label class="glyphicon glyphicon-search"><b> Buscar por</b></label>
                <select class="form-control" id="select_search_item" name="select_search_item" onchange="change_select_item('{{ route('temas.formSearch')}}')" required>
                    <option value="1">Descripción de compromiso</option>
                    <option value="2">Rango fecha inicio</option>
                    <option value="3">Rango fecha cumplimiento</option>
                </select>
            </div>
        </div><br><br>
        <span id="input_search_item">
            <div class="col-sm-12" >
                <div class="form-group">
                    <label class="glyphicon glyphicon-list-alt"><b> Descripción de compromiso </b></label>
                    <select class='form-control js-example-basic-single' id='data_search_item_1' name='data_search_item_1' required >
                    </select>
                </div>
            </div>
        </span>
        <br><br><br>
        <div class='col-sm-12'>
            <center>
                <button type='submit' class='btn btn-success' style="color: white;border: green;" ><b> <span class='glyphicon glyphicon-print' onclick='loader_function()' ></span> Imprimir</b></button>  
                <a type='button' class='btn btn-danger' style="color: white;border: red;" href='javascript:cerrar_ventana_medium()'><b> <span class='glyphicon glyphicon-remove'></span> Cancelar</b></a>
            </center>
        </div>
    </form>

    <script>
        $(document).ready(function() {    
			$('#data_search_item_1').select2({
				placeholder: "Seleccione...",
				allowClear: true,
			});
		});
    </script>