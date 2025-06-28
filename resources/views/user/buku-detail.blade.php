@extends('layouts.user')

@section('content')
    <livewire:user.buku-detail :id="$bukuId" />
@endsection
 