@extends('layouts.publiclayout')
@section('pageTitle', 'Login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">2fa</div>
                    <div class="panel-body">
                     @if(session('error'))
                     <div class="alert alert-danger" >
                     {{session('error')}} 
                    </div>
                    @endif
                    @if(session('success'))
                     <div class="alert alert-danger" >
                     {{session('success')}} 
                    </div>
                    @endif
                    @if(!count($data['user']->passwordSecurity))
                     <p>Enable 2fa on your account.</p>
                        <p>click the generate secrete button to generate your code </p>
                        <p>enter this into google authintecator app</p>
                    <form class="form-horizontal" method="POST" action="/generate2faSecreteCode">
                        {{csrf_field()}}
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-info">generate secret key</button>
                        </div>
                    </form>
                    @elseif (!$data['user']->passwordSecurity->google2fa_enable)
                    
                    <p>scan this barcode with the google authenticator app</p>

                    <img src="{{$data['google2FaUrl']}}">
                    <br><br>
                    <form class="form-horizontal" method="POST" action="/enable2fa">
                        {{csrf_field()}}
                    <div class="form-group">
                        <input type="password" class="form-control" id="verifyCode" name="verifyCode" required="">
                    </div>
                    <div class="form-group">
                         <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-success">enable 2fa</button>
                        </div>
                    </div>
                    </form>
               
                    @endif
                </div>
             </div>
         </div>
    </div>
</div>


@endsection
