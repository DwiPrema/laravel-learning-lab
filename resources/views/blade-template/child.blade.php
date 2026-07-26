@extends('blade-template.parent')

@section('title', 'Home')

@section('header')
    <h1>Deskripsi Header</h1>
    @parent
@endsection

@section('content')
    <p>ini adalah konten deskripsi</p>
@endsection