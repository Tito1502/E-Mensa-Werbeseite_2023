@extends("layouts.meinebewertungenlayout")

@section("main")
    <div><a href ="/">Homepage</a></div>
    <form method="post" action = "/meinebewertungen">
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
                <td><button type="submit" name="delete_id" value="{{$myrt['id']}}">Löschen</button></td>
            </tr>
        @endforeach
    </table>
    </form>
@endsection