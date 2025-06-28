@extends('layouts.admin')

@section('content')
    <livewire:admin.asset-pinjam :id="$asset->id" />
@endsection
