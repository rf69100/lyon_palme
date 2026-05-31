@extends('layouts.app')

@section('title', 'Trombinoscope')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                &larr; Retour au tableau de bord
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Trombinoscope</h1>
            <p class="text-slate-600">{{ $adherents->count() }} nageur(s) ont choisi d'apparaître.</p>
        </div>

        @if($adherents->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200 text-slate-600">
                Aucun nageur n'apparaît dans le trombinoscope pour le moment.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($adherents as $adherent)
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-200 text-center">
                        <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-purple-600 to-cyan-500 text-white flex items-center justify-center text-2xl font-bold mb-4">
                            {{ $adherent->initiales }}
                        </div>
                        <div class="font-semibold text-slate-900">{{ $adherent->prenom }} {{ $adherent->nom }}</div>
                        @if($adherent->roles->isNotEmpty())
                            <div class="mt-2 flex flex-wrap justify-center gap-1">
                                @foreach($adherent->roles as $role)
                                    <span class="px-2 py-0.5 bg-purple-50 text-purple-700 rounded text-xs font-semibold">{{ $role->nom_affichage ?? $role->nom }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
