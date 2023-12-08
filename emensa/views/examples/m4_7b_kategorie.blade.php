@extends(".layouts.layout")

@section("content")
    @foreach($data as $index => $category)
        <li class="{{ $index % 2 == 1 ? 'bold' : '' }}">{{ $category['name'] }}</li>
    @endforeach


@endsection

@section("cssextra")
    <style>
        .bold {
            font-weight: bold;
        }
    </style>
@endsection