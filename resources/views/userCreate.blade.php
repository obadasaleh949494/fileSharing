@extends('layouts.Publiclayout')
@section('pageTitle', 'Account Settings')
@section('content')

<script>
    
var check = function() {
  if (document.getElementById('newpassword').value ==
    document.getElementById('confirm_password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
  }
}

</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Account</div>

                <div class="card-body">
                    <form method="POST" action="/user/created" enctype="multipart/form-data">
                        @csrf
                         <font color ="red">  {{ $str or ''}}</font>
                          <font color ="green">  {{ $strr or ''}}</font>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"  required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right" onchange='validate();'>{{ __('E-Mail Address') }} </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>
                              
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                      
                    <div class="form-group row">           
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                    <input name="newpassword" id="newpassword" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" onkeyup='check();' />
                    
                    @if ($errors->has('newpassword'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('newpassword') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

               <div class="form-group row">           
                        <label for="password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                        <div class="col-md-6">
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  type="password" name="confirm_password" id="confirm_password"  onkeyup='check();' /> 
                    <span id='message'></span>  
                    @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                           
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">                               
                                <button type="submit" class="btn btn-primary">
                                   Create
                                </button>

                            </div>
                        </div>
                        <div class="form-group">
                             </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
