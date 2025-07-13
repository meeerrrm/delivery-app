@php
$logs = $record->logs;
@endphp

<ul class="relative border-l border-gray-300 mt-4 space-y-4">
    @forelse($logs as $log)
        <li class="ml-4">
            <div class="absolute w-3 h-3 bg-primary-500 rounded-full -left-1.5 top-1.5"></div>
            <div class="flex flex-col gap-1">
                <div class="text-sm font-semibold text-primary-700">
                    {{ $log->status }}
                    <span class="text-xs text-gray-500">[{{ $log->created_at->format('d M Y H:i') }}]</span>
                </div>
                @if ($log->note)
                    <div class="text-sm text-gray-700">{{ $log->note }}</div>
                @endif
                @if ($log->document_url)
                    <a href="{{ $log->document_url }}" target="_blank" class="text-xs text-blue-600 underline">
                        📎 Lihat Dokumen
                    </a>
                @endif
                @if ($log->assessedBy)
                    <div class="text-xs text-gray-400">🧑‍⚖️ Input oleh: {{ $log->assessedBy->name }}</div>
                @endif
            </div>
        </li>
    @empty
        <li class="ml-4 text-sm text-gray-500">Belum ada log pengiriman.</li>
    @endforelse
</ul>
