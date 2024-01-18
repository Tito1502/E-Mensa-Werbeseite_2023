@extends("layouts.meinebewertungenlayout")

@section("main")
    <table>
        <tr>
            <th>Bemerkung</th>
            <th>Sternbewertung</th>
            <th>Bewertungszeitpunkt</th>
            <th>Gericht</th>
        </tr>
    @foreach($myrts as $myrt)
            <tr>
                <td>{{$myrt["bemerkung"]}}</td>
                <td>{{$myrt["sternbewertung"]}}</td>
                <td>{{$myrt["bewertungszeitpunkt"]}}</td>
                <td>{{$myrt["gericht_name"]}}</td>
            </tr>
        @endforeach
    </table>
@endsection