@extends('layouts.Publiclayout')
@section('pageTitle', 'welcome')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-8">
                    
                               <font color="green">      {{$str or ''}}</font>
    
            <br><br>
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
