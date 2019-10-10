@extends('layouts.Publiclayout')
@section('pageTitle', 'Requests')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">                                         
            <div class="card">
                <div class="card-header"><h3>Inbox<h3></div>
                <table class='table'>
                <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Password</th>
                </tr>
                @foreach($demands as $demand)
                <form action="/user/created/{{$demand->id}}" method='post'>
                @csrf

                <tr>
             
                <td>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$demand->name}}" required autofocus disabled>
 
                </td>
                <td>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$demand->email}} " required disabled>
 
                </td>
                <td>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="password" value=" {{$demand->password}} " required autofocus disabled>
               </td>
               <td>
               <button type="submit" class="btn btn-success"name="create">Create</button>
               </td>
               <td>
                <button type="submit" class="btn btn-danger" name="delete" >Delete</button>
               </td>
                </tr>
                
                </form>
                @endforeach
                <table>
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
