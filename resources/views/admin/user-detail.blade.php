@extends('layouts.admin')

@section('content')
    
    <livewire:admin.user-detail :id="$user->id" />
@endsection
