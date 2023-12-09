@extends('layouts.emensalayout')

@section('header')
    <nav>
        <div class="grid-container" id="mytopnav">
            <div class="grid-item logo"><a href="#logogroß"><img src="IMG/logo-studentenwerk.png" alt="Logo"></a></div>
            <div class="grid-item"><a href="#ankündigung">Ankündigung</a></div>
            <div class="grid-item"><a href="#speisen">Speisen</a></div>
            <div class="grid-item"><a href="#zahlen">Zahlen</a></div>
            <div class="grid-item"><a href="#newsletter">Newsletter</a></div>
            <div class="grid-item"><a href="#wichtig">Wichtig für uns</a></div>
        </div>
     </nav>
@endsection

@section('main')

    <div class="main">

        <img id="logogroß" src="IMG/banner.jpg" alt="Logo">

        <div id="ankündigung">
            <h2>Bald gibt es Essen auch Online ;)</h2>

            <p style="border:2px solid #a0a0a0">
                Wir freuen uns, Ihnen mitteilen zu können, dass wir unser Angebot um
                eine köstliche Auswahl an Frühstücksoptionen erweitert haben. Beginnen
                Sie Ihren Tag mit frischen und energiereichen Speisen, die von unserem
                erfahrenen Team zubereitet werden. Von herzhaften Frühstücksburritos bis
                hin zu gesunden Müsli-Bowls - wir haben für jeden Geschmack etwas dabei.
                Kommen Sie vorbei und starten Sie Ihren Morgen bei uns in der Mensa!
            </p>
        </div>

        <div class="speisen">
            <h2 id="speisen">Köstlichkeiten, die Sie erwarten</h2>
           <table >
                {{--if $show brauchen wir zusätzliche spalte für allergene--}}
               @if($show) <tr><th>Name</th><th>Preis intern</th><th>Preis extern</th><th>Allergencode</th></tr>
               @else <tr><th>Name</th><th>Preis intern</th><th>Preis extern</th></tr>
               @endif
               @foreach($meals as $meal)
                   <tr>
                       <td>{{ $meal['name'] }}</td>
                       <td>{{ $meal['preisintern'] }}</td>
                       <td>{{ $meal['preisextern'] }}</td>
                       @if($show)<td>{{ $meal['Code'] }}</td>@endif
                   </tr>
               @endforeach
           </table>
            <ul>
                @if($show)
                    <h3>Liste der Allergene</h3>
                    @foreach($codes as $code)
                        <li>{{$code['code']}} = {{$code['name']}}</li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div>
            <h2 id="zahlen">E-Mensa in Zahlen</h2>
            <div class="platzhalter">
                <span class="zahl">{{ $visitorcount }}</span> Besuche
                <span class="zahl">{{ $newslettercount }}</span> Anmeldungen zum Newsletter
                <span class="zahl">{{ $mealcount }}</span> Speisen
            </div>
        </div>

        <div class="newsletter">
            <h2 id="newsletter">Interesse geweckt? Wir informieren Sie!</h2>
            <form method="POST" >
                <div class="newsletter-grid">
                    <div class="textfelder">
                        <div>
                            <label for="name">Ihr Name:</label><br>
                            <input type="text" name="name" id="name" placeholder="Vorname" required><br><br>
                        </div>
                        <div>
                            <label for="email">Ihre E-Mail:</label><br>
                            <input type="email" name="email" id="email" required><br><br>
                        </div>
                    </div>

                    <div class="sprache">
                        <label for="sprache">Newsletter bitte in: </label><br>
                        <select name="sprache" id="sprache">
                            <option value="de" selected>Deutsch</option>
                            <option value="en">Englisch</option>
                        </select><br><br>
                    </div>

                    <div class="datenschutz">
                        <input type="checkbox" name="datenschutz" id="datenschutz" required>
                        <label for="datenschutz">Den Datenschutzbestimmungen stimme ich zu</label><br><br>
                    </div>

                    <input type="submit" value="Zum Newsletter anmelden" class="submit">
                </div>
            </form>
        </div>



        <div class="listewichtig">
            <h2 id="wichtig">Das ist uns wichtig</h2>
            <ul class="liste">
                <li>Beste frische saisonale Zutaten</li>
                <li>Ausgewogene abwechslungsreiche Gerichte</li>
                <li>Sauberkeit</li>
            </ul>
        </div>
        <h2>Haben sie noch Wunschgerichte?</h2>

        <a href="/wunschgericht">Hier können sie etwas vorschlagen.</a>

        <h2 id="abschied">Wir freuen uns auf Ihren Besuch!</h2>





        @endsection

@section('footer')
    (c)E-Mensa Gmbh | Jeremy Mainka, Philip Engels, Bol Daudov | <a href="#impressum">Impressum</a>
@endsection