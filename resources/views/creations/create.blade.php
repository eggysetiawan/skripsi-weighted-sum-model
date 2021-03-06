@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('photographers.index') }}">Pilih Fotografer</a></li>
    <li class="breadcrumb-item active">Tambah Foto</li>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col md-10">
            <x-alert />
            <form action="{{ route('creations.store') }}" method="post" enctype="multipart/form-data" novalidate
                autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        @include('creations.partials._form-control')
                        <div class="form-group">
                            <label for="photos">{{ __('Foto') }}</label>
                            <input type="file" name="photos[]" multiple id="photos" class="form-control-file"
                                accept=".jpeg,.jpg,.png">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
