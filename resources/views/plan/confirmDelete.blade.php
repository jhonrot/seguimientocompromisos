
    <form class='row' action="{{ route('planes.destroy',['plane'=>$plan->id]) }}" method='POST' onclick="loader_function()" >
        @csrf 
        @method('delete') 
        
        <input type="text" id="url" name="url" class="form-control" value="{{$select_search}};{{$data_search}};{{$page}}" style="display:none;">

        <div class='col-sm-2'>
            <span style='font-size: 45px;color: red;' class='glyphicon glyphicon-question-sign'></span>
        </div>
        
        <div class='col-sm-10'><h3 id='mensaje'></h3></div><br><br><br>
        <div class='col-sm-12'>
            <center>
                <button type='submit' class='btn btn-success' style="color: white;border: green;" ><b> <span class='glyphicon glyphicon-floppy-saved' onclick='loader_function()' ></span> Aceptar</b></button>  
                <a type='button' class='btn btn-danger' style="color: white;border: red;" href='javascript:cerrar_ventana_medium()'><b> <span class='glyphicon glyphicon-remove'></span> Cancelar</b></a>
            </center>
        </div>
    </form>
