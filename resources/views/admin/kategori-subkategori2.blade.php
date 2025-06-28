@extends('layouts.admin')

@section('content')
    <livewire:admin.kategori-subkategori2 
        :kategoriId="$kategoriId" 
        :subkategori1Id="$subkategori1Id" 
        :subkategori2Id="$subkategori2Id" />
@endsection
