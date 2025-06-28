@extends('layouts.admin')

@section('content')
    <livewire:admin.buku-detail :id="$buku->id" />
@endsection
