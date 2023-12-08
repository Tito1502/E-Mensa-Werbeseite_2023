@extends(".layouts.layout")

@section("content")

    @unless(count($data) == 0)
        <ul>
            @foreach($data as $gericht)
                <li>
                    <strong>Name:</strong> {{ $gericht['name'] }},
                    <strong>Interner Preis:</strong> {{ $gericht['preisintern'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Es sind keine Gerichte vorhanden.</p>
    @endunless

@endsection
