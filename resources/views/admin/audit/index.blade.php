@extends('layouts.app')

@section('title', "Journaux d'audit")

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-4 font-semibold transition">
                &larr; Retour au tableau de bord
            </a>
            <h1 class="text-4xl font-bold text-slate-900 mb-2">Journaux d'audit</h1>
            <p class="text-slate-600">Traçabilité des accès et actions sensibles (non-répudiation).</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-600">Date</th>
                            <th class="px-4 py-3 font-semibold text-slate-600">Utilisateur</th>
                            <th class="px-4 py-3 font-semibold text-slate-600">Action</th>
                            <th class="px-4 py-3 font-semibold text-slate-600">Ressource</th>
                            <th class="px-4 py-3 font-semibold text-slate-600">IP</th>
                            <th class="px-4 py-3 font-semibold text-slate-600">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-700 whitespace-nowrap">{{ optional($log->created_at)->format('d/m/Y H:i') ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $log->utilisateur?->email ?? 'Système / anonyme' }}</td>
                                <td class="px-4 py-3"><span class="px-2 py-0.5 bg-purple-50 text-purple-700 rounded text-xs font-semibold">{{ $log->action }}</span></td>
                                <td class="px-4 py-3 text-slate-700">{{ $log->resource_type }}{{ $log->resource_id ? ' #'.$log->resource_id : '' }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $log->ip_address ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if($log->success)
                                        <span class="inline-flex items-center gap-1 text-green-700 text-xs font-semibold">● Succès</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-red-700 text-xs font-semibold" title="{{ $log->error_message }}">● Échec</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">Aucune entrée d'audit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
