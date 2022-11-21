@extends('layouts.backend.app')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">{{ __('field.voter') }}</h4>
        <div class="card-header-action">
            <a target="_blank" href="{{ route('backend.pemilih.export') }}" class="btn btn-success">Export</a>
            <a target="_blank" href="{{ route('backend.pemilih.export-kelas') }}" class="btn btn-info">Export Kelas</a>
            <a href="{{ route('backend.pemilih.create') }}" class="btn btn-primary">{{ __('button.add') }}</a>
        </div>
    </div>
    <div class="card-body">
       <div class="table-responsive">
        {!! $dataTable->table(['class' => 'table table-striped table-bordered']) !!}
       </div>
    </div>
</div>
@endsection
@push('js')
{!! $dataTable->scripts() !!}
@endpush