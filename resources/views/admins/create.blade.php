@extends('admins.layout')

@section('content')

    <div class="card" style="margin:20px;">
        <div class="card-header">Create Headers</div>
        <div class="card-body">
            @foreach ($errors->all() as $message)
                {{ $message }}
            @endforeach
            <form action="{{ url('header') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <label for="name">Tittle</label></br>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror"
                    autofocus value="{{ old('judul') }}"></br>

                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <label>Description</label></br>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                    autofocus value="{{ old('deskripsi') }}"></br>

                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mb3">
                    <label for="photo">Photo</label>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="photo" id="photo"
                            aria-describedby="inputGroupFileAddon04">
                    </div>
                </div>
                <input type="submit" value="Save" class="btn btn-success"></br>
            </form>

        </div>
    </div>
@stop
