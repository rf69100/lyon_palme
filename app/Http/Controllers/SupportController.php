<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ], [
            'subject.required' => 'Le sujet est obligatoire.',
            'subject.max' => 'Le sujet ne peut pas dépasser 255 caractères.',
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
        ]);

        // TODO: Implémenter l'envoi d'email ou l'enregistrement dans une base de données
        // Pour l'instant, on simule l'envoi avec un message de succès

        return redirect()->route('support.index')->with('success', 'Votre message a été envoyé avec succès. Notre équipe vous répondra dans les plus brefs délais.');
    }
}
