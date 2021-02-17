@extends('layouts/templateAdmin')
@section('title','Sistem / Sistem Log HRIS')
@section('content-title','Laporan Log HRIS')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('content')
{{-- <form action="/admin/achievement/" method="post"></form>
@foreach ($data as $item)
<label for="customRange-{{$item->id}}" class="form-label">{{$item->name}}</label>
<input type="range" class="form-range" min="0" max="100" id="customRange-{{$item->id}}" name="score-{{$item->id}}"> --}}
@endforeach

@endsection