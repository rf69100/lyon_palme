<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HelpController extends Controller
{
    /**
     * Display the management guide
     */
    public function guideGestion(): View
    {
        return view('help.guide-gestion');
    }

    /**
     * Display the secretary FAQ
     */
    public function faq(): View
    {
        return view('help.faq');
    }

    /**
     * Display the contact admin form
     */
    public function contactAdmin(): View
    {
        return view('help.contact-admin');
    }
}
