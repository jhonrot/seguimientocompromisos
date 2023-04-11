@extends('layouts.app_login')

@section('content')      
        
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <legend>Login</legend>
                    <br>

                    <form method="POST" action="{{ route('login') }}" name="formLogin" id="formLogin" class="formGen formLogin">

                        @csrf
                        <fieldset>
                            <label for="num_document" style="width:30%;margin-top: 17px;">{{ __('Cédula') }}</label>
                            <input class="form-control input-login @error('num_document') is-invalid @enderror" id="num_document" type="text" name="num_document" value="{{ old('num_document') }}" autocomplete="num_document" minlength="3" maxlength="20" autofocus required style="width:50%" onkeypress="return soloNumeros(event)" />

                            <br><br>

                            <label for="password" style="width:30%;margin-top: 17px;">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control input-login @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="width:50%" minlength="5" maxlength="45">

                        </fieldset> 

                        <div align="center">
                            @error('num_document')
                                <div class="alert alert-danger" style="width:70%;" >
                                    <strong>Estas credenciales no coinciden con nuestros registros activos.</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                            @error('password')
                                <div class="alert alert-danger" style="width:70%;" >
                                    <strong>Estas credenciales no coinciden con nuestros registros activos.</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="botones">
                            <button type="submit" class="btn btn-primary  input-login" id="submit_formLogin">
                                {{ __('Ingresar') }}
                            </button>
                        </div><br>

                        <div class="form-group row" align="center">
                            <div class="col-md-12">
                                
                                @if (Route::has('password.request'))
                                    <a class="btn btn-primary" href="{{ route('password.request') }}">
                                        <b>¿ Olvidaste tú contraseña ?</b>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection