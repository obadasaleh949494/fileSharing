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
{{$str or ''}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Account</div>
                    {{$str or ''}}
                <div class="card-body">
                    <form method="POST" action="/user/account/update" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{auth::user()->name}}" required autofocus>

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
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{auth::user()->email}}" required>
                              
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if( ! empty($str))
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            &nbsp&nbsp&nbsp&nbsp&nbsp
                         @endif
                           <font color ="red">  {{ $str or ''}}</font>
                        <div class="form-group row">           
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">           
                        <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
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
                              <label for="password" class="col-md-4 col-form-label text-md-right">Upload Signature file</label> 
                            <div class="col-md-6 offset-md-4">  
                               @if(auth::user()->upSignFile==0)    

                               <input id="file-5" name="image" class="btn btn-default" type="file" multiple data-preview-file-type="any" data-upload-url="#">
                                            <br><br>
                                @endif
                                <button type="submit" class="btn btn-primary">
                                   Update
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
