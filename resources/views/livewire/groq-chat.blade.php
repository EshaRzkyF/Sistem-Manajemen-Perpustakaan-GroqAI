<div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(16,185,129,0.14),_transparent_30%),linear-gradient(180deg,_#07111d_0%,_#0d1726_45%,_#111827_100%)] px-4 py-10 text-slate-100 sm:px-6 lg:px-8">
    <div class="mx-auto flex w-full max-w-6xl flex-col gap-6 lg:flex-row">
        <section class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/8 p-8 shadow-2xl shadow-emerald-950/20 backdrop-blur-xl lg:w-[42%]">
            <div class="absolute right-0 top-0 h-40 w-40 translate-x-8 -translate-y-8 rounded-full bg-emerald-400/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-32 w-32 -translate-x-10 translate-y-10 rounded-full bg-cyan-400/10 blur-3xl"></div>

            <div class="relative">
                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-400/10 px-3 py-1 text-xs font-medium tracking-[0.2em] text-emerald-200 uppercase">
                    Groq AI Console
                </span>

                <h1 class="mt-5 text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                    Chat cerdas untuk analisis, ide, dan jawaban cepat.
                </h1>

                <p class="mt-4 max-w-md text-sm leading-7 text-slate-300 sm:text-base">
                    Gunakan model Groq untuk menjawab pertanyaan, membuat analisis, atau membantu alur kerja perpustakaan dan produktivitas harian.
                </p>

                <div class="mt-8 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-slate-400">Status</div>
                        <div class="mt-1 font-semibold text-emerald-300">Realtime</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-slate-400">Model</div>
                        <div class="mt-1 font-semibold text-white">llama-3.1-8b-instant</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-slate-400">Respons</div>
                        <div class="mt-1 font-semibold text-white">Ringkas & jelas</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="text-slate-400">Mode</div>
                        <div class="mt-1 font-semibold text-white">Percakapan</div>
                    </div>
                </div>

                <div class="mt-8 space-y-3">
                    <div class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Contoh prompt cepat</div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" wire:click="$set('prompt', 'Buatkan analisis singkat tentang buku paling populer berdasarkan data peminjaman.')" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-slate-200 transition hover:border-emerald-400/40 hover:bg-emerald-400/10">Analisis buku populer</button>
                        <button type="button" wire:click="$set('prompt', 'Berikan saran pengelolaan stok buku agar koleksi perpustakaan tetap efisien.')" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-slate-200 transition hover:border-emerald-400/40 hover:bg-emerald-400/10">Saran stok</button>
                        <button type="button" wire:click="$set('prompt', 'Tolong bantu saya merapikan strategi layanan perpustakaan berbasis data.')" class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-slate-200 transition hover:border-emerald-400/40 hover:bg-emerald-400/10">Strategi layanan</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-white/10 bg-slate-950/60 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl lg:flex-1 lg:p-8">
            <div class="flex items-start justify-between gap-4 border-b border-white/10 pb-5">
                <div>
                    <h2 class="text-xl font-semibold text-white sm:text-2xl">Ruang Percakapan</h2>
                    <p class="mt-1 text-sm text-slate-400">Ketik pertanyaan, lalu tekan Enter untuk mengirim. Shift+Enter untuk baris baru.</p>
                </div>

                <div class="hidden rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1 text-xs font-medium text-emerald-200 sm:block">
                    Ready
                </div>
            </div>

            <div class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-4">
                <label for="groq-prompt" class="mb-2 block text-sm font-medium text-slate-300">Prompt</label>
                <textarea
                    id="groq-prompt"
                    wire:model="prompt"
                    wire:keydown.enter.prevent="$event.shiftKey || $wire.sendRequest()"
                    class="min-h-[180px] w-full resize-none rounded-2xl border border-white/10 bg-slate-950/80 p-4 text-sm leading-7 text-slate-100 placeholder:text-slate-500 focus:border-emerald-400/50 focus:outline-none focus:ring-2 focus:ring-emerald-400/20"
                    placeholder="Tulis pertanyaan Anda di sini..."
                ></textarea>

                @error('prompt')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror

                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-slate-500">Tip: gunakan prompt spesifik agar jawaban lebih fokus dan relevan.</p>

                    <button
                        wire:click="sendRequest"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-500 to-cyan-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-900/30 transition hover:from-emerald-400 hover:to-cyan-400 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3.105 2.289a.75.75 0 0 0-.977.923l2.116 6.348H9.25a.75.75 0 0 1 0 1.5H4.244L2.128 17.408a.75.75 0 0 0 .977.923 59.82 59.82 0 0 0 11.818-5.33 59.817 59.817 0 0 0 2.084-1.257.75.75 0 0 0 0-1.284 59.847 59.847 0 0 0-2.084-1.257 59.82 59.82 0 0 0-11.818-5.33Z" />
                        </svg>
                        <svg wire:loading xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4l3.5-3.5L12 1V5a7 7 0 1 0 7 7h5a12 12 0 1 1-12-12v4a8 8 0 0 0-8 8Z"></path>
                        </svg>
                        <span wire:loading.remove>Kirim ke Groq</span>
                        <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            </div>

            @if($response)
                <div class="mt-6 overflow-hidden rounded-3xl border border-emerald-400/20 bg-gradient-to-br from-emerald-400/10 via-slate-900/80 to-cyan-400/10 p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-white/10 pb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Hasil AI</h3>
                            <p class="text-sm text-slate-400">Respons dari Groq AI ditampilkan di bawah ini.</p>
                        </div>

                        <div class="flex gap-2 text-xs text-slate-300">
                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1">Status {{ $statusCode }}</span>
                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1">{{ $latency }} detik</span>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl border border-white/10 bg-slate-950/70 p-5">
                        <p class="whitespace-pre-line text-sm leading-7 text-slate-100">{{ $response }}</p>
                    </div>
                </div>
            @else
                <div class="mt-6 rounded-3xl border border-dashed border-white/10 bg-white/5 p-6 text-center text-sm text-slate-400">
                    Belum ada jawaban. Kirim prompt untuk mulai percakapan.
                </div>
            @endif
        </section>
    </div>
</div>
