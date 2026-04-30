<div class="grid gap-6 xl:grid-cols-[360px_1fr]">
    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="text-lg font-semibold text-slate-900">Quick Prompts</h3>
        <p class="mt-1 text-sm text-slate-500">Gunakan template agar analisis lebih cepat.</p>

        <div class="mt-5 grid gap-3 text-sm">
            <button type="button" wire:click="$set('prompt', 'Buatkan analisis singkat tentang buku paling populer berdasarkan data peminjaman.')" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-left text-slate-700 transition hover:border-slate-500 hover:bg-slate-50">Analisis buku populer</button>
            <button type="button" wire:click="$set('prompt', 'Berikan saran pengelolaan stok buku agar koleksi perpustakaan tetap efisien.')" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-left text-slate-700 transition hover:border-slate-500 hover:bg-slate-50">Saran pengelolaan stok</button>
            <button type="button" wire:click="$set('prompt', 'Buat rekomendasi peningkatan layanan perpustakaan berbasis data peminjaman.')" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-left text-slate-700 transition hover:border-slate-500 hover:bg-slate-50">Peningkatan layanan</button>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3 text-xs">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <p class="text-slate-500">Status</p>
                <p class="mt-1 font-semibold text-slate-900">Ready</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <p class="text-slate-500">Model</p>
                <p class="mt-1 font-semibold text-slate-900">llama-3.1-8b-instant</p>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">AI Chat</h3>
                <p class="text-sm text-slate-500">Tekan Enter untuk kirim, Shift+Enter untuk baris baru.</p>
            </div>
            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Online</span>
        </div>

        <div class="mt-5">
            <label for="groq-prompt" class="mb-2 block text-sm font-medium text-slate-700">Prompt</label>
            <textarea
                id="groq-prompt"
                wire:model="prompt"
                wire:keydown.enter.prevent="$event.shiftKey || $wire.sendRequest()"
                class="min-h-[170px] w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
                placeholder="Contoh: Berikan rekomendasi buku yang perlu ditambah berdasarkan tren peminjaman minggu ini."
            ></textarea>

            @error('prompt')
                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
            @enderror

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                <p class="text-xs text-slate-500">Gunakan pertanyaan spesifik untuk hasil yang lebih akurat.</p>

                <button
                    wire:click="sendRequest"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove>Kirim ke Groq</span>
                    <span wire:loading>Mengirim...</span>
                </button>
            </div>
        </div>

        @if($response)
            <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                <div class="mb-3 flex flex-wrap gap-2 text-xs">
                    <span class="rounded-full bg-white px-2.5 py-1 font-medium text-slate-700">Status {{ $statusCode }}</span>
                    <span class="rounded-full bg-white px-2.5 py-1 font-medium text-slate-700">{{ $latency }} detik</span>
                </div>
                <p class="whitespace-pre-line text-sm leading-7 text-slate-800">{{ $response }}</p>
            </div>
        @else
            <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500">
                Belum ada respons. Tulis prompt untuk memulai percakapan.
            </div>
        @endif
    </section>
    </div>
</div>
