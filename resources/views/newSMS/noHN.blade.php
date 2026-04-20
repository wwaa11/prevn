@extends('layouts.app')
@section('content')
    <style>
        .bg-praram9 {
            border-radius: 10px;
            color: #fff;
            background: #37beaf;
            background: linear-gradient(117deg, rgba(55, 190, 175, 1) 0%, rgba(11, 162, 171, 1) 91%);
        }
    </style>
    <div class="mb-3 mt-6 text-center text-2xl font-bold">
        <div>{{ $text->checkup }}</div>
    </div>
    <div class="flex p-3">
        <div class="m-auto mt-6 shadow-lg p-6 mb-6 w-full md:w-3/4 bg-praram9 text-center">
            <div class="mb-3">{{ $text->name }}</div>
            <div class="mb-3">{{ $hnDetail->name }} ( {{ $hnDetail->HN }} )</div>
            <div class="mb-3">{{ $text->app_no }}</div>
            <div class="mb-3">{{ $hnDetail->appNo }}</div>
            <div class="mb-3">{{ $text->app_date }}</div>
            <div class="mb-3">{{ $hnDetail->appDate }}</div>
            <div class="mb-3">{{ $text->app_time }}</div>
            <div class="mb-3">{{ $hnDetail->appTime }}</div>
            <div class="m-auto flex-grow mt-6" id="checkLo">
                <div class="text-center cursor-pointer p-3 font-bold rounded border-blue-600 text-yellow-300 mt-3 text-3xl">
                    {{ $text->range_check }}
                </div>
            </div>
            <div class="hidden m-auto flex-grow mt-6">
                <div class="text-center cursor-pointer p-3 mt-3">
                    <button type="button" class="rounded text-yellow-300 bg-[#37beaf] p-3 w-full md:w-1/2 shadow text-4xl font-bold">TEST</button>
                </div>
            </div>
            {{-- <div class="text-5xl">&nbsp;</div> --}}
        </div>
    </div>
@endsection