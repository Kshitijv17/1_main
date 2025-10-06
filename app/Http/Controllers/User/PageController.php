<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function aboutUs()
    {
        return view('user.pages.about-us');
    }

    public function privacyPolicy()
    {
        return view('user.pages.privacy-policy');
    }

    public function termsConditions()
    {
        return view('user.pages.terms-conditions');
    }

    public function shippingPolicy()
    {
        return view('user.pages.shipping-policy');
    }

    public function returnPolicy()
    {
        return view('user.pages.return-policy');
    }

    public function refundCancellation()
    {
        return view('user.pages.refund-cancellation');
    }
}
