@extends('admin::layouts.master')

@section('content')
    <h1>Hello Reagan!!!</h1>

    <p>
        This view is loaded from module: {!! config('admin.name') !!}
    </p>
@endsection
