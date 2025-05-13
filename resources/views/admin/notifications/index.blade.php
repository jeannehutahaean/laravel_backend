@extends('admin.layouts.app')

@section('title', 'Notifikasi')

@section('content')
    <h1>Notifikasi Keterlambatan / Penyimpangan</h1>
    <ul>
        @foreach ($notifications as $note)
            <li>{{ $note->message }} - <strong>{{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}</strong></li>
        @endforeach
    </ul>
@endsection
