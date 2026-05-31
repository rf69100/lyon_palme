@extends('layouts.app')

@section('title', 'Annuaire')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                &larr; Retour au tableau de bord
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Annuaire des nageurs</h1>
            <p class="text-slate-600">{{ $adherents->count() }} nageur(s) ont choisi d'y figurer.</p>
        </div>

        @if($adherents->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-8 border border-slate-200 text-slate-600">
                Aucun nageur ne figure dans l'annuaire pour le moment.
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold text-slate-600">Nom</th>
                            <th class="px-6 py-3 text-sm font-semibold text-slate-600">Email</th>
                            <th class="px-6 py-3 text-sm font-semibold text-slate-600">Téléphone</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($adherents as $adherent)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $adherent->prenom }} {{ $adherent->nom }}</td>
                                <td class="px-6 py-4 text-slate-700">
                                    @if($adherent->email)
                                        <a href="mailto:{{ $adherent->email }}" class="text-purple-600 hover:text-purple-700">{{ $adherent->email }}</a>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-700">{{ $adherent->mobile ?: ($adherent->telephone ?: '—') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
