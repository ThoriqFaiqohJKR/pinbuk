@extends('layouts.user')

@section('content')
    <livewire:user.katalog-buku :kategoriId="$kategoriId" />
@endsection
