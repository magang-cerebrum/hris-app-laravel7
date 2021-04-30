@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
@section('url')
<div class="position" style="position: absolute; bottom: 5%">
    <a href="{{url('/logout')}}" style="text-decoration: none">Klik disini untuk kembali ke halaman login!</a>
</div>
@endsection
