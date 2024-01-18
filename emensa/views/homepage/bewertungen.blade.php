@extends("layouts.bewertungenlayout")

@section("main")
    <table>
        <tr><th>Bemerkung</th><th>Sternbewertung</th><th>Bewertungszeitpunkt</th><th>Gericht</th><th>User</th></tr>
@foreach($rs as $r)
    <tr>
        <td>{{$r["bemerkung"]}}</td>
        <td>{{$r["sternbewertung"]}}</td>
        <td>{{$r["bewertungszeitpunkt"]}}</td>
        <td>{{$r["gericht_name"]}}</td>
        <td>{{$r["benutzer_name"]}}</td>
    </tr>
@endforeach
    </table>
@endsection