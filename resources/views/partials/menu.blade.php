<li><a href="{{ url('welcome') }}">Početna</a></li>
@role('Admin')
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="{!! url('admin/operateri') !!}">Operateri</a></li>
			<li><a href="{!! url('admin/uloge') !!}">Uloge</a></li>
			<li><a href="{!! url('admin/dozvole') !!}">Dozvole</a></li>
			<li><a href="{!! url('log-viewer') !!}">Logovi</a></li>
		</ul>
	</li>
@endrole
@if(Auth::user())
	<li><a href="{!! url('klijenti?manual=true') !!}">Klijenti</a></li>

	@if(Session::has('klijentId'))
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Predlošci<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{!! url('klijenti/'.Session::get('klijentId').'/predlosci') !!}">Sve vrste</a></li>
				@foreach($vrsteNaloga as $vrstaNaloga)
					<li><a href="{!! url('klijenti/'.Session::get('klijentId').'/predlosci?vrstaNaloga='.$vrstaNaloga->id) !!}">{{$vrstaNaloga->Naziv}}</a></li>
				@endforeach
			</ul>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nalozi<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{!! url('klijenti/'.Session::get('klijentId').'/nalozi') !!}">Sve vrste</a></li>
				@foreach($vrsteNaloga as $vrstaNaloga)
					<li><a href="{!! url('klijenti/'.Session::get('klijentId').'/nalozi?vrstaNaloga='.$vrstaNaloga->id) !!}">{{$vrstaNaloga->Naziv}}</a></li>
				@endforeach
			</ul>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Zbrojni Nalozi<span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{!! url('klijenti/'.Session::get('klijentId').'/zbrojniNalog') !!}">Sve vrste</a></li>
				@foreach($vrsteNaloga as $vrstaNaloga)
					<li><a href="{!! url('klijenti/'.Session::get('klijentId').'/zbrojniNalog?vrstaNaloga='.$vrstaNaloga->id) !!}">{{$vrstaNaloga->Naziv}}</a></li>
				@endforeach
			</ul>
		</li>
	@endif
@endif