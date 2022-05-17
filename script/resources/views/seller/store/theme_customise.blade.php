@extends('layouts.app')
@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/file-manager/css/file-manager.css') }}">
@endpush
@section('head')
@include('layouts.partials.headersection',['title'=>'Theme Customise'])
@endsection
@section('content')
<div class="row">
    <div class="col-12 text-right">
        <a href={{ route('seller.theme.index') }} class="btn btn-primary">Go to list</a>
    </div>
</div>
<div class="row mt-2"> 
	<div class="col-12">
	    <div id="fm"></div>
	</div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/vendor/file-manager/js/file-manager.js') }}"></script>
@endpush