<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;

use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
  /**
   * REGISTRATION
   * Needs to get fixed...
   */
  public function register(AuthRequest $request) {
    $fn = function () use ($request) {
      $creds = $request->only('name', 'email', 'password');
      $creds['id'] = Str::uuid();
      $creds['password'] = bcrypt($creds['password']);

      $user = User::create($creds);

      $token = $user->createToken($user->email);

      // Send verification email
      // $user->notify(new VerifyEmailNotification);
      $user->sendEmailVerificationNotification();

      $data = [
        'user' => $user,
        'access_token' => explode('|', $token->plainTextToken)[1]
      ];

      return response()->json(res('User has been created.', $data, 201), 201);
    };

    return catcher($fn);
  }

  /**
   * LOGIN
   * Needs to get fixed...
   */
  public function login(AuthRequest $request) {
    // dd($request->path());
    $fn = function () use ($request) {
      $creds = $request->only('email', 'password');

      if (Auth::attempt($creds, $request->remember_me)) {
        $user = Auth::user(); 

        // Create fresh token
        if ($user->tokens) {
          $user->tokens()->delete();
        }

        $token = $user->createToken($user->email);

        $data = [
          'access_token' => explode('|', $token->plainTextToken)[1]
        ];

        return response()->json(res('Successfully logged in.', $data));
      }

      throw new \Exception("Invalid credentials.", 401);
    };
    
    return catcher($fn);
  }

  public function verifyEmail(EmailVerificationRequest $request) {
    $fn = function () use ($request) {
      $request->fulfill();

      $data = $request->user()->only('id', 'email', 'email_verified_at');

      return response()->json(res('Successfully verify email.', $data));
    };

    return catcher($fn);
  }

  public function forgotPassword(AuthRequest $request) {
    // Generate reset token
    $fn = function () use ($request) {
      $email = $request->only('email');

      $status = Password::sendResetLink($email);
  
      if ($status === Password::RESET_LINK_SENT) {
        return response()->json(res('Password reset link has been sent.'));
      }
  
      throw new \Exception("Failed sending reset link.", 500);
    };

    return catcher($fn);
  }

  public function resetPassword(AuthRequest $request) {
    // Change password using reset token
    $fn = function () use ($request) {
      $creds = $request->only('email', 'password', 'token');

      $status = Password::reset($creds, function($user, $password) use ($creds) {
        $user->forceFill([
          'password' => bcrypt($password)
        ])->save();
  
        // Supposed to have event(new PasswordReset($user)); on docs. Maybe to notify via email.
      });
  
      if ($status == Password::PASSWORD_RESET) {
        return response()->json(res('Password has been reset.'));
      }
  
      throw new \Exception("Failed resetting password.", 500);
    };

    return catcher($fn);
  }
}
