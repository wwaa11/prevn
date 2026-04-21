@extends('newSMS.layout')

@section('title', 'Appointment Detail - Praram 9')

@section('content')
<div class="container mx-auto max-w-lg px-6 py-10">
    
    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            {{ $text->checkup }}
        </h1>
        <div class="h-1 w-12 bg-teal-500 rounded-full mx-auto mt-3"></div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-slate-50 overflow-hidden transition-all">
        
        <div class="bg-slate-900 p-8 text-white">
            <div class="flex justify-between items-start">
                <div class="space-y-1">
                    <p class="text-teal-400 text-[10px] uppercase font-black tracking-[0.2em]">{{ $text->name }}</p>
                    <h2 class="text-xl font-bold leading-tight">{{ $patient['name'] }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-slate-500 text-[10px] uppercase font-black tracking-widest">HN</p>
                    <p class="text-lg font-mono font-bold text-teal-400">{{ $patient['hn'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            @if($patient['appointment'])
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">{{ $patient['appointment_service'] }}</p>
                        <p class="text-lg font-bold text-slate-800">{{ $patient['appointment_time'] ?? '-' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-right">
                        <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">Check-in</p>
                        <p class="text-sm font-bold text-slate-700">
                            {{ date('H:i', strtotime($patient['checkin'])) ?? '-' }}
                        </p>
                    </div>
                </div>
                @if(!$patient['is_checkin'])
                <div id="action-container" class="space-y-4">
                    <div class="flex flex-col items-center justify-center py-10">
                        <div class="w-10 h-10 border-4 border-teal-500 border-t-transparent rounded-full animate-spin"></div>
                        <p class="mt-4 text-slate-400 text-sm font-medium animate-pulse italic">
                            Verifying your location...
                        </p>
                    </div>
                </div>
                @else
                <div class="py-10 text-center">
                    <h3 class="text-slate-800 font-bold text-5xl leading-tight">
                        {{ $patient['number'] }}
                    </h3>
                    <p class="text-slate-400 text-sm mt-2">
                        {{ $text->wait_queue }}
                    </p>
                </div>
                @endif
            @else
                <div class="py-10 text-center">
                    <h3 class="text-slate-800 font-bold text-lg leading-tight">
                        {!! $text->noAppointment !!}
                    </h3>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let userLat = null;
    let userLog = null;

    $(document).ready(function() {
        @if($patient['appointment'] && !$patient['is_checkin'])
            initGeolocation();
        @endif
    });

    function initGeolocation() {
        if (!navigator.geolocation) {
            updateUI('error_location');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                userLat = pos.coords.latitude;
                userLog = pos.coords.longitude;
                validateLocation();
            },
            (err) => {
                Swal.fire({
                    title: "Location Access Required",
                    text: "Please enable location to check-in.",
                    icon: "error",
                    confirmButtonColor: '#37beaf'
                });
                updateUI('error_location');
            },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    }

    async function validateLocation() {
        try {
            const formData = new FormData();
            formData.append('hn', '{{ $patient["hn"] }}');
            formData.append('lat', userLat);
            formData.append('log', userLog);

            const response = await axios.post("{{ env('APP_URL') }}/checkLocationNew", formData);
            updateUI(response.data.status, response.data.distance);
        } catch (error) {
            updateUI('error');
        }
    }

    function updateUI(status, distance = null) {
        const container = $('#action-container');
        let html = '';

        switch(status) {
            case 'eligible':
                html = `
                    <button onclick="issueQueue()" class="gradient-card w-full text-white font-bold py-5 shadow-xl shadow-teal-100 hover:scale-[1.02] active:scale-95 transition-all text-xl tracking-tight">
                        Get Queue
                    </button>
                `;
                break;
            case 'out_of_range':
                html = `
                    <div class="bg-orange-50 border border-orange-100 rounded-3xl p-6 text-center">
                        <p class="text-orange-800 font-black tracking-tight">NOT IN RANGE</p>
                        <p class="text-orange-600 text-xs mt-1 font-medium">Distance: ${distance} km from center</p>
                        <button onclick="validateLocation()" class="mt-4 bg-orange-100 text-orange-800 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">Retry check</button>
                    </div>
                `;
                break;
            default:
                html = `<div class="bg-red-50 text-red-600 p-4 rounded-2xl text-center font-bold text-sm">An error occurred. Please refresh.</div>`;
        }

        container.html(html);
    }

    async function issueQueue() {
        Swal.fire({
            title: 'Please wait...',
            didOpen: () => { Swal.showLoading() },
            allowOutsideClick: false
        });

        try {
            const formData = new FormData();
            formData.append('hn', '{{ $patient["hn"] }}');
            const res = await axios.post("{{ env('APP_URL') }}/getNumber", formData);
            if (res.status === 200) {
                window.location.reload();
            }
        } catch (error) {
            Swal.fire('Error', 'Failed to generate queue.', 'error');
        }
    }
</script>
@endpush