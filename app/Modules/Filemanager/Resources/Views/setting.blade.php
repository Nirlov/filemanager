@extends('layouts.app')

@section('title', 'Setting')

@section('content')
    <setting-index
    data="{{ $data }}"></setting-index>
@endsection

@section('vue')
    <script src="{{ asset('js/setting.js') }}" defer></script>
@endsection

@section('scripts')

@endsection
