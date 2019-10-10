<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Demand;
use Mail;
use App\Mail\MyEmail;
use App\User;
use App\file;
use App\signaturefile;

use Illuminate\Support\Facades\DB;
use Auth;
use Hash;
class UserController extends Controller
{
    //
  public function __construct()
    {
   
    }
    public function createView() {

    return view('userCreate');                                                                      

  }
    public function register(Request $request)
    {
        $demand= DB::table('demands')->where('email', $request->input('email'))->first();
        $user= DB::table('users')->where('email', $request->input('email'))->first();
        
        
        if($demand==null && $user==null){
        $Demand=new Demand(); 
         $Demand->name=$request->input('name');
         $Demand->email=$request->input('email');
         $Demand->password=UserController::generateRandomString(6);   
         $Demand->save();   
         $str= "your request was registered";
         return View("welcome")->with('str',$str);
         }
       else 
                     {
                            $str="your email is registered ";
      return view("auth/register")->with('str',$str);
}
           
    }
    public function results(Request $request)
    { 
       $id= auth::user()->id;
        $users2 = DB::table('users')
        ->where([['email','like',"%". $request->input('search')."%"] ,['upSignFile',0 ] ,
              ['id','<>', $id]])
        ->orwhere([['name','like',"%". $request->input('search')."%"],['upSignFile',0 ], 
               ['id','<>', $id]] )
        ->get()  ;
        $users1= DB::table('signaturefiles')
            ->join('users', 'users.id', '=', 'signaturefiles.user_id')
            ->join('files', 'files.id', '=', 'signaturefiles.File_Id')
            ->where('users.id','<>', $id)
            ->where('users.email','like',"%". $request->input('search')."%" )
            ->orwhere('users.name','like',"%". $request->input('search')."%" )
            ->select('users.*', 'files.path')
            ->get();                   
        return View("users")->with('users2',$users2)->with('users1',$users1);

    }
    public function browse()
    {
       $id= auth::user()->id;
       $users1 = DB::table('signaturefiles')
            ->join('users', 'users.id', '=', 'signaturefiles.user_id')
            ->join('files', 'files.id', '=', 'signaturefiles.File_Id')
            ->where('users.id','<>', $id)
            ->select('users.*', 'files.path')
            ->get();                        
           $users2 =  DB::table('users')->where('id','<>', $id)->
           where('upSignFile', 0)->
           get();        
          return View("users")->with('users1',$users1)->with('users2',$users2);
    }
    public function sendmail()
    {
       
       $user = Auth::User() ;
        Mail::send('mailView', ['user' => 'hamza'], function ($m){
            $m->to('hamza962569325@gmail.com', 'some guy')->subject('Your Reminder!');
        });
        return View('welcome    ');
      

    }
    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function demand()
    {
        $demands=Demand::all(); 
        return View("inbox")->with('demands',$demands);
        

    }
    public function deleted ($id,Request $request)
    {         
       $user=DB::table('users')->where('id','=',$id)->first();
       if($user->upSignFile==1)
       {
              $signfile=DB::table('signaturefiles')->where('user_id','=',$id)->first();
              $fileId= $signfile->File_Id;
              DB::table('files')->where('id','=',$fileId)->delete();
              DB::table('signaturefiles')->where('user_id','=',$id)->delete();
             
       }

       DB::table('users')->where('id','=',$id)->delete();
       return redirect()->back();   
    }
    public function created($id,Request $request)
    {
       $demand= DB::table('demands')->where('id', $id)->first();     
       $user = new User();
       $user->name=$demand->name;
       $user->password = Hash::make( $demand->password);
       $user->email = $demand->email;
       $user->save();  
       DB::table('demands')->where('id', $id)->delete();
       return redirect()->back();
       
    }
    public function createUser (Request $request )
    {
       $eml = DB::table('users')->where('email', $request->input('email'))->first();
       if($eml ==null){
       $user = new User();
       $user->name=$request->input('name');
       $user->password = Hash::make( $request->input('newpassword'));
       $user->email = $request->input('email');
       $user->save();  
       $str="successful registration !";
       return view('userCreate')->with('strr',$str);
     }
     else
     {
      $str="this email have an account !";
       return view('userCreate')->with('str',$str);
     }

    }
    public function account ()
    {
        return View('account');
    }
    public function accountUpdate(Request $request)
    {
      $id=  file::orderBy('id', 'desc')->first()->id+1;
      $user=Auth::user();       
       $oldpassword=Auth::user()->password;       
        if (Hash::check($request->input('password'),$oldpassword )) {
            // valid
            $user->name=$request->input('name');
            $user->email=$request->input('email');
            if ($request->input('newpassword')!=null){
               if(auth::user()->confirmed==0 && Hash::check($request->input('newpassword'),$oldpassword ) ==0)
                     {
                         auth::user()->firstChangePassword=1;
                        
                     }
               $user->password = Hash::make($request->input('newpassword'));
                $user->save();

            }
       
            if($request->hasFile('image'))
        {
                $fileholder=$request->file('image');
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
                $signFile=new Signaturefile();
                $signFile->File_Id=$id;
                $signFile->user_id=Auth::user()->id;
                auth::user()->upSignFile=1;   
                $user->save();               
                $signFile->save(); 
            }
        }
        else{
           $str ="incorrect password ";
         return View("account")->with('str',$str);            
        }
                    if(auth::user()->upSignFile && auth::user()->firstChangePassword)
                            auth::user()->confirmed=1;
                             $user->save();

                          return redirect()->back();

        
    }
    

   
}
