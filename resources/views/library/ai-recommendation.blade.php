@extends('layouts.app')

@section('content')
<div class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-cyan-800 p-6 text-white shadow-lg sm:p-8">
    <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
        <div>
            <p class="mb-3 inline-flex rounded-full border border-white/20 px-3 py-1 text-xs font-medium">Groq AI Workspace</p>
            <h2 class="text-2xl font-semibold sm:text-3xl">AI Chat Assistant</h2>
            <p class="mt-3 max-w-2xl text-sm text-slate-200 sm:text-base">Ajukan pertanyaan, minta rekomendasi koleksi, dan dapatkan insight perpustakaan secara instan.</p>
        </div>
        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 text-sm backdrop-blur">
            <p class="text-xs uppercase tracking-wider text-slate-200">Model</p>
            <p class="mt-1 font-semibold">llama-3.1-8b-instant</p>
        </div>
    </div>
</div>

@livewire('groq-chat')
@endsection
