<?php

namespace App\User\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Support\Controller;

final class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }
}
