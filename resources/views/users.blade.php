@extends('layouts.Publiclayout')
@section('pageTitle', 'Users')
@section('content')

&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

   
 
  

    
                    
  
<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">                               
              
                     <table class='table'>
                        <form action="/user/results" method="post"> 
                            @csrf
                         <tr>    
                       <td> <input type="text" name="search" placeholder="Search" class="form-control input-sm"> </td>
                        <td><button type="submit" class="btn btn-success">
                       
                          Search
                          </button>
                          </td>
                        </tr>                   
                    </form>
                </table>
            <div class="card">
                            <div class="card-header" ><font size="6pt" color="green"><bold><i>Users</i></bold></font></div>
                        
               <table class='table'>
                <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Sign File Download</th>
                
               </tr>
                @foreach($users1 as $user)
                <form action="/user/deleted/{{$user->id}}" method='post'>
                @csrf

                <tr>
             
                <td>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}" required autofocus disabled>
 
                </td>
                <td>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}} " required disabled>
 
                </td>  
                <td>
                    <a href="/storage/{{$user->path}}" target="_blank" download>
                    <img src="/storage/down.png" height="42" width="42">
            </a>
               </td>                         
               <td>
                <button type="submit" class="btn btn-danger" name="delete" >Delete</button>
               </td>

                </tr>
                
                </form>
                @endforeach
                 @foreach($users2 as $user2)
                <form action="/user/deleted/{{$user2->id}}" method='post'>
                @csrf

                <tr>              
                <td>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user2->name}}" required autofocus disabled>
 
                </td>
                <td>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user2->email}} " required disabled>
 
                </td>  
                <td>
                    
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
