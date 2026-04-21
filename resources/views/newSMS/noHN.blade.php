@extends('newSMS.layout')

@section('title', 'CheckUP - Praram 9 Hospital')

@section('content')
<div class="container mx-auto px-6 pt-10 pb-16 flex flex-col items-center">
    
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
            {{ $text->checkup }}
        </h1>
        <div class="h-1.5 w-20 bg-teal-500 rounded-full mx-auto mt-4"></div>
    </div>

    <div class="w-full max-w-lg transition-all hover:scale-[1.01]">
        <div class="gradient-card p-10 text-white shadow-2xl relative group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
            
            <div class="relative z-10">
                <div class="bg-black/10 border border-white/20 rounded-2xl py-8 px-4 text-center backdrop-blur-sm">
                    <span class="text-xl font-medium opacity-90 tracking-wide italic">
                        ไม่พบข้อมูลผู้ป่วย
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection