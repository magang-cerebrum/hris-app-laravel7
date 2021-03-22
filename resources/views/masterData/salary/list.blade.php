@extends('layouts/templateAdmin')
@section('content-title','Master Data / Tunjangan Gaji / Tambah Tunjangan Gaji')
@section('content-subtitle','HRIS PT. Cerebrum Edukanesia Nusantara')
@section('title','Master Data')
@section('content')
    <form action="/admin/salary/processed" method="POST">
        @csrf
        <button type="submit">Get Salary Data</button>
    </form>
    <form action="/admin/salary/reset" method="POST">
        @csrf
        <button type="submit">Reset Log Salary</button>
    </form>
@endsection