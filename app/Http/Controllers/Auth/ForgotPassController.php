<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;




class ForgotPassController extends Controller
{
    public function forgotPassword()
	{
		$title = 'Lupa Password';
		return view('auth.forgot-password', [
			'title' => $title
		]);
	}
	public function forgotPasswordPost(Request $r) {
        $users = User::where('email' , '=', $r->email)->first();
        $date = Carbon::now();
        if(isset($users)){
			$token = Str::random(64);
			$existingToken = ResetPassword::where('email', $users->email)->where('status', '1')->first();

			if ($existingToken) {
				ResetPassword::where('email', $users->email)->where('status', '1')->update([
					'status' => 0
				]);
			}

			ResetPassword::create([
				'email' => $users->email,
				'token' => Hash::make($token),
				'status' => 1 // Ensure status is explicitly set
			]);

	        $address = $users->email;
	        $subject = "Forgot Password";
	        $data = "email=". $users->email ."&tokenPas=" . $token;

	        $mailSend = Mail::send('auth.email.forgot-password', compact('users','data', 'date'), function ($message) use ($subject, $address){
	            $message->subject($subject);
	            $message->to($address);
	        });

			return redirect()->to(route('forgot-password'))->with('success', 'Kami Telah Mengirimkan Email untuk Reset Password');
		}
		return redirect()->to(route('forgot-password'))->withErros('Gagal Kirim Email Reset Password');
	}
	public function resetPassword(Request $r) {
		$title = 'Reset Password';
		if(isset($r)){				
			$token = $r->tokenPas;
			$email = $r->email;

			$existingToken = ResetPassword::where('email', $email)->where('status', '1')->first();

			if(isset($existingToken)){
				if(Hash::check($token, $existingToken->token)){
					return view('auth.new-password', compact('token', 'email', 'title'));
				}
			}
		}
		return redirect()->route('home');
	}
	
	public function resetPasswordPost(Request $r)
	{
        $users = User::where('email' , '=', $r->email)->first();
		$newPass = $r->password;
		$confirmPassword = $r->confirm;

        if(isset($users)){
			if($newPass == $confirmPassword){
				$userChange = User::where('id', '=', $users->id)->update([
					'password' => Hash::make($newPass)
				]);

				if($userChange){
					$existingToken = ResetPassword::where('email', $users->email)->where('status', '1')->first();
					if ($existingToken) {
						ResetPassword::where('email', $users->email)->where('status', '1')->update([
							'status' => 0
						]);
					}
					return redirect()->route('login')->with('success', 'Password berhasil direset!');
				}
			}
		}
		return redirect()->back()->withErros('fail change password');
	}


}
