<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Információ - {{ $title }}</title>
</head>
 
<body>
Kedves Kolléga!
<br/>
Örömmel értesítelek, hogy kiválasztottunk {{ $role == "referee" ? "döntnökként" : "játékvezetőként" }} a tárgyban jelölt versenyre.
Az egyenruha a szokásos fekete, a kötelező felszerelés: stopper, érme, lapok, toll, tábla.
A verseny adtai:

{{ $title }}<br/>
{{ $venue }} ({{ $courts }} pálya)<br/>
{{ $address }}<br/>
<br/>
Jó munkát kívánunk!<br/>
<br/>
Üdvözlettel<br/>
<br/>
Magyar Tollaslabda Szövetség<br/>
Játékvezetői és Versenybírói Bizottság
</body>
</html>