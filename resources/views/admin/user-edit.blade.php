@extends('layouts.admin')

@section('content')
    <livewire:admin.user-edit :userId="$id" />
@endsection
