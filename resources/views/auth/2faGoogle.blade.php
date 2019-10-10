@extends('layouts.publiclayout')
@section('pageTitle', 'Login')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">2FA Authentication</div>
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
                    
                    
                    <p>Enter The PIN from the google authenticator App</p>
               
                    <form class="form-horizontal" method="POST" action="/2faVerify">
                        {{csrf_field()}}
                    <div class="form-group">
                        <input type="password" class="form-control" id="one_time_password" name="one_time_password" required="">
                    </div>
                    <div class="form-group">
                         <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-success">Porceed </button>
                        </div>
                    </div>
                    </form>
                   
                </div>
             </div>
         </div>
    </div>
</div>


@endsection
