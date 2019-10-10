<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\file;
use App\privateFile;
use App\publicFile;
use App\specifiedFile;
use Auth;


class FileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','google2fa']);
    }
    public function publicBrows()
    {
    	 $files= DB::table('publicFiles')
            ->join('users', 'users.id', '=', 'publicFiles.user_id')
            ->join('files', 'files.id', '=', 'publicFiles.File_Id')          
            ->select('users.name as userName', 'files.*','publicFiles.id as pubId','publicFiles.created_at')
            ->get();
            return view('publicFiles')->with('files',$files);   
    }
     public function publicResult(Request $request)
     {

        $users1= DB::table('publicFiles')
            ->join('users', 'users.id', '=', 'publicFiles.user_id')
            ->join('files', 'files.id', '=', 'publicFiles.File_Id')
            ->where('files.name','like',"%". $request->input('search')."%" )
            ->orwhere('users.name','like',"%". $request->input('search')."%" )
            ->select('users.name as userName', 'files.*','publicFiles.id as pubId','publicFiles.created_at')
            ->get();               
        return View("publicFilesResults")->with('files',$users1);
     }        
    public function publicUpload(Request $req)
    {
    	$id=  file::orderBy('id', 'desc')->first()->id+1;
        if($req->hasFile('image'))
        {

                $fileholder=$req->file('image');
                $ext=$fileholder->getClientOriginalExtension();
                $name=$fileholder->getClientOriginalName();
                $mime=$fileholder->getClientMimeType();
                $size=$fileholder->getClientSize();
                $path=$fileholder->store('signfiles');     
                $file=new file ();
                $file->name=$fileholder->getClientOriginalName();
                $file->size=$fileholder->getClientSize();
                $file->mime=$fileholder->getClientMimeType();
                $file->path=$path;
                $file->extension=$fileholder->getClientOriginalExtension();
                $file->save();
                $publicFile=new publicFile();
                $publicFile->File_Id=$id;
                $publicFile->user_id=Auth::user()->id;                           
                $publicFile->save(); 
               return redirect()->back();
            }
            else
            {
            	$str="you have to choose file to upload !.";
            	return redirect()->back()->with('str',$str);
            }
    }
     public function privateBrows()
    {
        $userId=Auth::user()->id;
        $files= DB::table('privateFiles')
            ->join('users', 'users.id', '=', 'privateFiles.user_id')
            ->join('files', 'files.id', '=', 'privateFiles.File_Id')    
            ->where('user_id',$userId)      
            ->select('users.name as userName','files.*','privateFiles.id as pubId','privateFiles.created_at')
            ->get();
            return view('privateFiles')->with('files',$files);
    }
     public function specifiedBrows()
    {
        $userId=Auth::user()->id;
        $files= DB::table('specifiedFiles as sf')
            ->join('users  as u1', 'u1.id', '=', 'sf.owner_id')
             ->join('users as u2', 'u2.id', '=', 'sf.receiver_id')
             ->join('files', 'files.id', '=', 'sf.File_Id')    
            ->where('owner_id',$userId)      
            ->orwhere('receiver_id',$userId)
            ->select('u1.name as userName','u2.name as recName','files.*','sf.id as pubId','sf.created_at')    
            ->get();          
            return view('specifiedFiles')->with('files',$files);
    }
    public function PrivateUpload(Request $req)
    {
        $id=  file::orderBy('id', 'desc')->first()->id+1;
        if($req->hasFile('image'))
        {

                $fileholder=$req->file('image');
                $ext=$fileholder->getClientOriginalExtension();
                $name=$fileholder->getClientOriginalName();
                $mime=$fileholder->getClientMimeType();
                $size=$fileholder->getClientSize();
                $path=$fileholder->store('privatefiles');     
                $file=new file ();
                $file->name=$fileholder->getClientOriginalName();
                $file->size=$fileholder->getClientSize();
                $file->mime=$fileholder->getClientMimeType();
                $file->path=$path;
                $file->extension=$fileholder->getClientOriginalExtension();
                $file->save();
                $privateFile=new privateFile();
                $privateFile->File_Id=$id;
                $privateFile->user_id=Auth::user()->id;                           
                $privateFile->save(); 
               return redirect()->back();
            }
            else
            {
                $str="you have to choose file to upload !.";
                return redirect()->back()->with('str',$str);
            }
    }
    public function specifiedUpload(request $req)
    {
        $id=  file::orderBy('id', 'desc')->first()->id+1;
        $email=DB::table('users')  
            ->where('email',$req->input('email'))  
            ->select('id') ->   first()   ;
        
        if(count($email)){
        if($req->hasFile('image'))
        {

                $fileholder=$req->file('image');
                $ext=$fileholder->getClientOriginalExtension();
                $name=$fileholder->getClientOriginalName();
                $mime=$fileholder->getClientMimeType();
                $size=$fileholder->getClientSize();
                $path=$fileholder->store('privatefiles');     
                $file=new file ();
                $file->name=$fileholder->getClientOriginalName();
                $file->size=$fileholder->getClientSize();
                $file->mime=$fileholder->getClientMimeType();
                $file->path=$path;
                $file->extension=$fileholder->getClientOriginalExtension();
                $file->save();
                $specifiedFile=new specifiedFile();
                $specifiedFile->File_Id=$id;
                $specifiedFile->owner_id=Auth::user()->id; 
                $specifiedFile->receiver_id= $email->id;          
                $specifiedFile->save(); 
               return redirect()->back();
            }
            else
            {
                $str="you have to choose file to upload !.";
                return redirect()->back()->with('strr',$str);
            }
        }
        else
        {
            $str="receiver email not found !.";
                return redirect()->back()->with('str',$str);
        }
    }
}
