@extends('layouts.app')

@section('title', 'Filemanager')

@section('content')
    <content-bank-index></content-bank-index>
@endsection

@section('vue')
    <script src="{{ asset('js/content-bank.js') }}" defer></script>
@endsection

@section('scripts')

@endsection
