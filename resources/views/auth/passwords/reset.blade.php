@extends('layouts.app_login')

@section('content')      
        
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <legend>Cambiar contraseña</legend>
                    <br>

                    <form method="POST" action="{{ route('password.update') }}" name="formLogin" id="formLogin" class="formGen formLogin">

                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <fieldset>
                            <label for="email" style="width:30%;margin-top: 17px;">{{ __('Correo') }}</label>
                            <input id="email" type="email" name="email" class="form-control input-login @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" autocomplete="email" autofocus required style="width:50%" readonly />

                            <br><br>
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        
                            <br><br>
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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

                            @error('password')
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
                                {{ __('Cambiar contraseña') }}
                            </button>
                        </div><br>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection