@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Attend
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <div class="form-group">
                        <label for="name">ID:</label>
                        <p>{{ $attend->id }}</p>
                    </div>
                    @include('admin.attends.show_fields')
                    <a href="{{ route('admin.attends.index') }}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
