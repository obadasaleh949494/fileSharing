@extends('layouts.Publiclayout')
@section('pageTitle', 'private files')
@section('content')

            
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Add icon library -->

<style>
label{
  color: blue;
  cursor: pointer;
}

label:hover{
  text-decoration: underline;
}

#file_input_id{
  display:none;
}
</style>
</head>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">                               
              
                     <table class='table'>
                        <form action="/publicFile/results" method="post"> 
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
                            <div class="card-header" ><font size="6pt" color="green"><bold>Uploud File</bold></font></div> 
              <form action="/files/uploadPrivate" method="post" enctype="multipart/form-data">  
                @csrf
                 <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">  
                                                         
                               <input id="file-5" name="image" class="btn btn-default" type="file" multiple data-preview-file-type="any" data-upload-url="#">
                                            <br><br>
                            
                                <button type="submit" class="btn btn-primary">
                                   upload
                                </button>

                            </div>
                        </div>
                </form>
                {{$str or ''}}
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                </div>
            </div>
            <br>  
            <div class="card">
                            <div class="card-header" ><font size="6pt" color="green"><bold>Public Files</bold></font></div>                       
               <table class='table'>
                <tr>
                <th>Publisher</th>
                <th>File Name</th>
                <th>Size</th>                
                <th>Extension</th>
                <th>Uploded at</th>
                
               </tr>
                @foreach($files as $file)                                
                <tr>            
                <td>{{$file->userName}}</td>
                <td>{{$file->name}}</td>
                <td>{{$file->size/1000}}kb</td>              
                <td>{{$file->extension}}</td>
                <td>{{$file->created_at}}</td>
                <td><a href="/storage/{{$file->path}}" target="_blank" download>
                    <img src="/storage/Download.png" height="42" width="42">
            </a></td>
                @if(Auth::user()->admin)
                <td><a href="">Delete</a></td>
                @endif
                
                
                </tr>                             
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
