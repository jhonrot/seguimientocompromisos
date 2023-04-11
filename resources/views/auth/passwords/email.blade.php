@extends('layouts.app_login')

@section('content')      
        
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <legend>Recuperar contraseña</legend>
                    <br>

                    <form method="POST" action="{{ route('password.email') }}" name="formLogin" id="formLogin" class="formGen formLogin">

                        @csrf
                        <fieldset>
                            <label for="email" style="width:30%;margin-top: 17px;">{{ __('Correo') }}</label>
                            <input class="form-control input-login @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required style="width:50%" />
                            <br><br>
                        </fieldset> 

                        <div align="center">
                            @error('email')
                                <div class="alert alert-danger" style="width:70%;" >
                                    <strong>{{ $message }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="botones">
                            <button type="submit" class="btn btn-primary  input-login" id="submit_formLogin">
                                {{ __('Recuperar contraseña') }}
                            </button>
                        </div><br>

                        <div class="form-group row" align="center">
                            <div class="col-md-12">
                                
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                        </div>  
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection