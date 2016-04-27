<nav class="navbar-default navbar-static-side navbar-collapse collapse" role="navigation" id="left_menu">
	<ul class="nav nav-pills nav-stacked" id="stacked-menu">
		<li><a href="{{ url('welcome') }}">Početna</a></li>
		@role('Admin')
		<li class="nav {{ Route::is('admin.*') ||  Route::is('log-viewer.*') ? 'active' : '' }}">
			<a class="nav-container first-menu" data-toggle="collapse" data-parent="#stacked-menu" href="#dropAdmin">Admin<div class="caret-container"><span class="caret arrow"></span></div></a>
			<ul class="nav nav-pills nav-stacked collapse {{ Route::is('admin.*') ? 'in' : '' }}" id="dropAdmin">
				<li class="{{ Route::is('admin.operateri.*') ? 'active' : '' }}"><a href="{!! url('admin/operateri') !!}">Operateri</a></li>
				<li class="{{ Route::is('admin.uloge.*') ? 'active' : '' }}"><a href="{!! url('admin/uloge') !!}">Uloge</a></li>
				<li class="{{ Route::is('admin.dozvole.*') ? 'active' : '' }}"><a href="{!! url('admin/dozvole') !!}">Dozvole</a></li>
				<li class="{{ Route::is('log-viewer.*') ? 'active' : '' }}"><a href="{!! url('log-viewer') !!}">Logovi</a></li>

			</ul>
		</li>
		@endrole

		@if(Auth::user())

			<li class="nav {{ Route::is('klijenti.index') ? 'active' : '' }}"><a href="{!! url('klijenti?manual=true') !!}">Klijenti</a></li>

			@if(Session::has('klijentId'))
				<li class="{{ Route::is('klijenti.predlosci.*') ? 'active' : '' }}">
					<a class="nav-container first-menu" data-toggle="collapse" data-parent="#stacked-menu" href="#dropPredlosci">Predlošci<div class="caret-container"><span class="caret arrow"></span></div></a>
					<ul class="nav nav-pills nav-stacked collapse {{ Route::is('klijenti.predlosci.*') ? 'in' : '' }}" id="dropPredlosci">
						<li class="{{ Route::is('klijenti.predlosci.*') && !Request::has('vrstaNaloga') ? 'active' : '' }}"><a href="{!! url('klijenti/'.Session::get('klijentId').'/predlosci') !!}">Sve vrste</a></li>
						@foreach($vrsteNaloga as $vrstaNaloga)
							<li class="{{ Route::is('klijenti.predlosci.*') && Request::input('vrstaNaloga') == $vrstaNaloga->id ? 'active' : '' }}"><a href="{!! url('klijenti/'.Session::get('klijentId').'/predlosci?vrstaNaloga='.$vrstaNaloga->id) !!}">{{$vrstaNaloga->Naziv}}</a></li>
						@endforeach
					</ul>
				</li>
				<li class="nav {{ Route::is('klijenti.nalozi.*') ? 'active' : '' }}">
					<a class="nav-container first-menu" data-toggle="collapse" data-parent="#stacked-menu" href="#dropNalozi">Nalozi<div class="caret-container"><span class="caret arrow"></span></div></a>
					<ul class="nav nav-pills nav-stacked collapse {{ Route::is('klijenti.nalozi.*') ? 'in' : '' }}" id="dropNalozi">
						<li class="{{ Route::is('klijenti.nalozi.*') && !Request::has('vrstaNaloga') ? 'active' : '' }}"><a href="{!! url('klijenti/'.Session::get('klijentId').'/nalozi') !!}">Sve vrste</a></li>
						@foreach($vrsteNaloga as $vrstaNaloga)
							<li class="{{ Route::is('klijenti.nalozi.*') && Request::input('vrstaNaloga') == $vrstaNaloga->id ? 'active' : '' }}"><a href="{!! url('klijenti/'.Session::get('klijentId').'/nalozi?vrstaNaloga='.$vrstaNaloga->id) !!}">{{$vrstaNaloga->Naziv}}</a></li>
						@endforeach
					</ul>
				</li>
				<li class="nav {{ Route::is('klijenti.zbrojniNalog.*') ? 'active' : '' }}">
					<a class="nav-container first-menu" data-toggle="collapse" data-parent="#stacked-menu" href="#dropZbrojniNalozi">Zbrojni Nalozi<div class="caret-container"><span class="caret arrow"></span></div></a>
					<ul class="nav nav-pills nav-stacked collapse {{ Route::is('klijenti.zbrojniNalog.*') ? 'in' : '' }}" id="dropZbrojniNalozi">
						<li class="{{ Route::is('klijenti.zbrojniNalog.*') && !Request::has('vrstaNaloga') ? 'active' : '' }}"><a href="{!! url('klijenti/'.Session::get('klijentId').'/zbrojniNalog') !!}">Sve vrste</a></li>
						@foreach($vrsteNaloga as $vrstaNaloga)
							<li class="{{ Route::is('klijenti.zbrojniNalog.*') && Request::input('vrstaNaloga') == $vrstaNaloga->id ? 'active' : '' }}"><a href="{!! url('klijenti/'.Session::get('klijentId').'/zbrojniNalog?vrstaNaloga='.$vrstaNaloga->id) !!}">{{$vrstaNaloga->Naziv}}</a></li>
						@endforeach
					</ul>
				</li>
			@endif
		@endif
	</ul>
	@yield('leftMenu')
</nav>
