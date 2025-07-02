@extends('layouts.user')

@section('content')
<livewire:user.search-result :keyword="$nama" />
@endsection