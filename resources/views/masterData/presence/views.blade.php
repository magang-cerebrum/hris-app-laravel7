@extends('layouts/templateAdmin')
@section('content-title','Master Data / Tunjangan Gaji / Tambah Tunjangan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
    <form action="/admin/presence/processed" method="POST">
        @csrf
        <button type="submit">Get Processed Data</button>
    </form>
    <form action="/admin/presence/reset" method="POST">
        @csrf
        <button type="submit">Reset Log presence</button>
    </form>
@endsection