@extends("layouts.bewertunglayout")

@section("main")
    <form method="post" action="/bewertung">
        <label>Ihre bewertung</label>
        <br>
        <input type="radio" name="sternbewertung" value="sehr schlecht">sehr schlecht</input>
        <br>
        <input type="radio" name="sternbewertung" value="schlecht">schlecht</input>
        <br>
        <input type="radio" name="sternbewertung" value="gut">gut</input>
        <br>
        <input type="radio" name="sternbewertung" value="sehr gut">sehr gut</input>
        <br>
        <label for="bemerkung">Bemerkung:</label>
        <br>
        <textarea rows="5" cols = "50" id="bemerkung" name="bemerkung" minlength="5" required></textarea>
        <br>
        <input type="submit" value="Absenden">
        <br>
    </form>
@endsection