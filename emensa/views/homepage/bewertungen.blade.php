@extends("layouts.bewertungenlayout")

@section("main")
        <table>
            @if($_SESSION['admin'])
                <tr><th>Bemerkung</th><th>Sternbewertung</th><th>Bewertungszeitpunkt</th><th>Gericht</th><th>User</th><th>highlight?</th></tr>
            @else
                <tr><th>Bemerkung</th><th>Sternbewertung</th><th>Bewertungszeitpunkt</th><th>Gericht</th><th>User</th></tr>
            @endif
    @foreach($rs as $r)
        <tr @if($r['hervorheben'] == 1) style="background-color: #dc3545" @endif >
            <td>{{$r["bemerkung"]}}</td>
            <td>{{$r["sternbewertung"]}}</td>
            <td>{{$r["bewertungszeitpunkt"]}}</td>
            <td>{{$r["gericht_name"]}}</td>
            <td>{{$r["benutzer_name"]}}</td>
            @if($_SESSION['admin'] == 1)
                @if($r['hervorheben'] == 0)
                    <td><a href="/bewertungen?HL={{$r['id']}}">Hervorheben</a></td>
                    {{--<td><button type="submit" name="hervorheben" value="{{$r['id']}}">Hervorheben</button></td>--}}
                @else
                    <td><a href="/bewertungen?HL={{$r['id']}}">Hervorhebung abwählen</a></td>
                    {{--<td><button type="submit" name="hervorhebung" value="{{$r['id']}}">Hervorhebung abwählen</button></td>--}}

                @endif
            @endif
        </tr>
    @endforeach
        </table>
@endsection