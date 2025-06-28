@extends('layouts.admin')

@section('content')
    <livewire:admin.kategori-subkategori :kategoriId="$kategoriId" :subkategoriId="$subkategoriId" />
@endsection
