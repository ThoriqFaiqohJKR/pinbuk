@extends('layouts.admin')

@section('content')
    <livewire:admin.buku-pinjam :id="$buku->id" />
@endsection
