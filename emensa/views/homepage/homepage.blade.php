@extends(".layouts.layouthomepage")

@section('cssextra')
    <link rel="stylesheet" href="./css/style.css">
@endsection

@section('header')
    <div class="grid-container" id="mytopnav">
        <div class="grid-item logo"><a href="#logogroß"><img src="IMG/logo-studentenwerk.png" alt="Logo"></a></div>
        <div class="grid-item"><a href="#ankündigung">Ankündigung</a></div>
        <div class="grid-item"><a href="#speisen">Speisen</a></div>
        <div class="grid-item"><a href="#zahlen">Zahlen</a></div>
        <div class="grid-item"><a href="#newsletter">Newsletter</a></div>
        <div class="grid-item"><a href="#wichtig">Wichtig für uns</a></div>
    </div>
@endsection
