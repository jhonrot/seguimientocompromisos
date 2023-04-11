
    <div class="row">
        <div class="col-sm-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::get('status'))
                <div class="alert alert-success">
                    {{Session::get('status')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div><br>

        <div class="col-sm-12">

            <form action="{{ route('sub_clasificaciones.form_store') }}" method="POST" id="form_submit" name="form_submit">
                @csrf

                <span id="input_datos"></span>
                
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Nombre </b><span class="text-danger hint--top hint--primary" data-hint="Campo obligatorio" title="Campo obligatorio" style="cursor: pointer;">*</span></label>
                            <textarea id="name" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" required minlength="4" maxlength="100" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ old('name') }}</textarea>
                        </div>
                    </div>
                </div>
                <br>
                
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="glyphicon glyphicon-pencil"><b> Descripción </b></label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" minlength="4" maxlength="45" rows="4" onkeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" >{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div><br><br>

                <div class="row">
                    <center>
                        <button type="submit" class="btn btn-primary"><b> <span class="glyphicon glyphicon-floppy-saved"></span> Guardar</b></button>
                        <a type="button" class="btn btn-secondary" href="javascript:cerrar_ventana_medium()" ><b> <span class="glyphicon glyphicon-circle-arrow-left"></span> Cancelar</b></a>
                    </center>
                </div>
            </form>
        </div>
	</div>