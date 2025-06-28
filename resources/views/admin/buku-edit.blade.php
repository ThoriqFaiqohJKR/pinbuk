@extends('layouts.admin')

@section('content')
    <livewire:admin.buku-edit :id="$buku->id" />
@endsection
