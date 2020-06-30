@extends('layouts.app')

@section('content')
<video-upload :url="'{{ config('app.url') }}'"></video-upload>
@endsection