@extends('app')

@section('content')
<div class="row">
	{!! Breadcrumbs::render('welcome') !!}
	<div class="col-md-12">
		<h1>Dobrodošli u aplikaciju za kreiranje platnih naloga</h1>
		<h2>Ova aplikacija omogučuje vam izradu predložaka pospremanje istih i kreiranje zbrojnih naloga za slanje bankama</h2>

		<p>
		@if(Session::has('flash_notification.message'))
				<p>{{Session::get('flash_notification.tip')}}</p>
		@endif

		</p>

		<h2>Korištenje aplikacija</h2>
		<ul>
			<li>
				<h3>Prijava u aplikaciju</h3>
				<ul>
					<li>
						- korisnik se prijavljuje u aplikaciju unosom e-mail adrese i lozinke
					</li>
				</ul>
			</li>
			<li>
				<h3>Klijenti : Odabir klijenta s kojim želimo raditi</h3>
				<ul>
					<h3>Rad s klijentima</h3>
					<li>ako imamo jednog pridruženog klijenta, vrši se se automatski odabir klijenta i nastavljamo raditi s tim klientom</li>
					<li>ako imamo više pridruženih klijenata, preusmjerava se na odabir klijenta s kojim želimo raditi</li>
					<ul>
						<li>ovdje je moguče odabrati s kojih računa želimo vršiti plaćanja</li>
					</ul>
				</ul>
				<ul>
					<li>ako imamo jednog pridruženog klijenta, vrši se se automatski odabir klijenta i nastavljamo raditi s tim klientom</li>
					<li>ako imamo više pridruženih klijenata, preusmjerava se na odabir klijenta s kojim želimo raditi</li>
					<ul>
						<li>ovdje je moguče odabrati s kojih računa želimo vršiti plaćanja</li>
					</ul>
				</ul>
			</li>
			<li>
				<h3>Partneri : Odabir klijenta s kojim želimo raditi</h3>
				<ul>
					<h3>Rad s partnerima</h3>
					<li>ako imamo jednog pridruženog klijenta, vrši se se automatski odabir klijenta i nastavljamo raditi s tim klientom</li>
					<li>ako imamo više pridruženih klijenata, preusmjerava se na odabir klijenta s kojim želimo raditi</li>
					<ul>
						<li>ovdje je moguče odabrati s kojih računa želimo vršiti plaćanja</li>
					</ul>
				</ul>
			</li>
			<li>
				<h3>Korak 3: Kreiranje predložaka</h3>
				<ul>
					<li>u ovom izborniku kreiramo predloške koje čemo kasnije koristiti kod naloga</li>
				</ul>
			</li>
			<li>
				<h3>Korak 5: Dodavanje zbrojnih naloga</h3>
				<ul>
					<li>lista</li>
					<li>lista</li>
				</ul>
			</li>
		</ul>

	</div>
</div>
@endsection

