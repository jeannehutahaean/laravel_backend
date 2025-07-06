<div class="notification-card p-4 hover:bg-gray-50 transition" 
     data-driver="{{ strtolower($note->driver_name) }}" 
     data-order="{{ strtolower($note->order_id) }}">
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-md font-semibold text-gray-800">
                Pengiriman #{{ $note->order_id }}
                @if($note->status === 'late')
                    <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Terlambat</span>
                @elseif($note->status === 'deviation')
                    <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Penyimpangan</span>
                @endif
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                Driver: <span class="font-medium">{{ $note->driver_name }}</span> <br>
                Lokasi terakhir: {{ $note->last_position ?? '-' }} <br>
                Berangkat: {{ \Carbon\Carbon::parse($note->departure_time)->format('d M Y H:i') }} <br>
                Estimasi Tiba: {{ \Carbon\Carbon::parse($note->planned_time)->format('d M Y H:i') }}
            </p>
            @if($note->message)
                <p class="mt-2 text-sm text-red-600 italic">{{ $note->message }}</p>
            @endif
        </div>
        <div class="text-right text-sm text-gray-500">
            Dibuat: {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
        </div>
    </div>
</div>
