@extends('layouts.public')

@section('title', 'Contacter le support - Lyon Palme')

@section('content')

<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-20">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-white mb-6">Contacter le support</h1>
            <p class="text-xl text-slate-300 max-w-3xl mx-auto">
                Notre équipe est là pour vous aider
            </p>
        </div>
    </div>
</div>

<div class="container mx-auto px-6 py-16">
    <div class="max-w-2xl mx-auto">
        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 mb-6">
                <p class="text-green-600 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-8 mb-8">
            <form action="{{ route('support.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="subject" class="block text-slate-700 font-medium mb-2">Sujet</label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        value="{{ old('subject') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 @error('subject') border-red-500 @enderror"
                        required
                        placeholder="Décrivez brièvement votre demande"
                    >
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-slate-700 font-medium mb-2">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 @error('message') border-red-500 @enderror"
                        required
                        placeholder="Détaillez votre demande..."
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-cyan-500 text-white rounded-lg hover:from-purple-700 hover:to-cyan-600 font-medium">
                        Envoyer le message
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex-1 px-6 py-3 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-medium text-center">
                        Retour
                    </a>
                </div>
            </form>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-3">Email</h3>
                <p class="text-slate-600 mb-2">
                    <a href="mailto:support@lyonpalme.fr" class="text-purple-600 hover:text-purple-700">support@lyonpalme.fr</a>
                </p>
                <p class="text-slate-500 text-sm">Réponse sous 24-48h</p>
            </div>

            <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-xl p-6">
                <h3 class="text-xl font-bold text-slate-900 mb-3">Téléphone</h3>
                <p class="text-slate-600 mb-2">
                    <a href="tel:+33123456789" class="text-purple-600 hover:text-purple-700">01 23 45 67 89</a>
                </p>
                <p class="text-slate-500 text-sm">Lun-Ven: 9h-18h</p>
            </div>
        </div>
    </div>
</div>

@endsection
