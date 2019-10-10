<?php

namespace App\Http\Controllers;

use App\PassworddSecurity;
use Illuminate\Http\Request;
use Auth;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\DB;

class PassworddSecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PassworddSecurity  $passworddSecurity
     * @return \Illuminate\Http\Response
     */
    public function show(PassworddSecurity $passworddSecurity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PassworddSecurity  $passworddSecurity
     * @return \Illuminate\Http\Response
     */
    public function edit(PassworddSecurity $passworddSecurity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PassworddSecurity  $passworddSecurity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PassworddSecurity $passworddSecurity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PassworddSecurity  $passworddSecurity
     * @return \Illuminate\Http\Response
     */
    public function destroy(PassworddSecurity $passworddSecurity)
    {
        //
    }
     public function show2faForm ()
    {   
        if(Auth::guest())
            {
                return;
            }
        $user=Auth::user();
        $google2faUrl='';
        if(count($user->passwordSecurity))
        {
            $google2fa= new Google2FA();
            $google2fa->setAllowInsecureCallToGoogleApis(true);
            $google2faUrl=$google2fa->getQRCodeGoogleUrl('com',   
                   $user->name,
                   $user->google2fa_secrete
                 //  $user->email
 
                    );

        }
        $data=array(
            'user'=>$user,
            'google2FaUrl'=>$google2faUrl
        );
        return view('Auth.google2fa')->with('data',$data);
    }
    public function generate2faSecreteCode(Request $request)
    {
        $user=Auth::user();
         $google2fa= new Google2FA();
         $s= $google2fa->generateSecretKey(16);    
         $new =new PassworddSecurity();
         $new->user_id=$user->id;
         $new->google2fa_enable=0;
         $new->google2fa_secrete=$s;
         $new->save();
        return redirect('/2fa')->with('success','success your secret key has been generated. please verify to enable');
       
    }
    public function enable2fa(Request $request)
    {
        $user=Auth::user();
        $google2fa= new Google2FA();
        $secret=$request->input('verifyCode');
        $sec = DB::table('passwordd_securities')->where('user_id', $user->id)->first();
        $var=$sec->google2fa_secrete;
       $valid = $google2fa->verifyKey($var,$secret);
        if($valid)
        {
            
            $sec = DB::table('passwordd_securities')->where('user_id', $user->id)->update(['google2fa_enable' => 1]);
            return redirect('/')->with('success','success 2FA is enabled');
        }
        else
        {
             return redirect('/2fa')->with('error','invalid code,please try again.');
        }
    }
    public function disable2fa(Request $request)
    {
        $user=Auth::user();
        if(!(Hash::check($request->input('currentPassword'),$user->password)))
             return redirect('/2fa')->with('error','your password does not match ');

             $user->passworddSecurity->google2fa_enable=0;
             $user->passworddSecurity->save();
              return redirect('/2fa')->with('success','success 2FA is disabled');
    }
}
