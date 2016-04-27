<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Početna', route('home'));
});

// Home > Welcome
Breadcrumbs::register('welcome', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Dobrodošli', route('welcome'));
});

// Klijent
Breadcrumbs::register('klijenti.index', function($breadcrumbs)
{
    $breadcrumbs->push('Klijenti', route('klijenti.index','manual=true'));
});

// Klijent > Partner
Breadcrumbs::register('klijenti.partneri.index', function($breadcrumbs, $klijent)
{
    $breadcrumbs->parent('klijenti.index');
    $breadcrumbs->push($klijent->Naziv, route('klijenti.partneri.index', $klijent->id));
});

// Klijent > Partner > Računi
Breadcrumbs::register('klijenti.partneri.ziro.index', function($breadcrumbs, $klijent, $partner)
{
    $breadcrumbs->parent('klijenti.partneri.index', $klijent);
    $breadcrumbs->push($partner->Naziv, route('klijenti.partneri.ziro.index', $partner->id));
});

// Klijent > Predlosci
Breadcrumbs::register('klijenti.predlosci.index', function($breadcrumbs, $klijent)
{
    $breadcrumbs->parent('klijenti.index');
    $breadcrumbs->push('Predlošci: '.$klijent->Naziv, route('klijenti.predlosci.index', $klijent->id));
});
// Klijent > Nalozi
Breadcrumbs::register('klijenti.nalozi.index', function($breadcrumbs, $klijent)
{
    $breadcrumbs->parent('klijenti.index');
    $breadcrumbs->push('Nalozi: '.$klijent->Naziv, route('klijenti.nalozi.index', $klijent->id));
});
// Klijent > ZbrojniNalozi
Breadcrumbs::register('klijenti.zbrojniNalog.index', function($breadcrumbs, $klijent)
{
    $breadcrumbs->parent('klijenti.index');
    $breadcrumbs->push('Zbrojni nalozi: '.$klijent->Naziv, route('klijenti.zbrojniNalog.index', $klijent->id));
});
// Klijent > ZbrojniNalozi > Nalozi
Breadcrumbs::register('klijenti.zbrojniNalog.nalozi.index', function($breadcrumbs, $klijent, $zbrojniNalog)
{
    $breadcrumbs->parent('klijenti.zbrojniNalog.index', $klijent);
    $breadcrumbs->push($zbrojniNalog->Naziv, route('klijenti.zbrojniNalog.nalozi.index', $zbrojniNalog->id));
});

// Klijent > Vrste Naloga
Breadcrumbs::register('klijenti.vrsteNaloga.index', function($breadcrumbs, $klijent )
{
    $breadcrumbs->parent('klijenti.index');
    $breadcrumbs->push($klijent->Naziv, route('klijenti.vrsteNaloga.index', $klijent->id));
});
// Klijent > Vrste Naloga > Zbrojni nalozi
Breadcrumbs::register('klijenti.vrsteNaloga.zbrojniNalog.index', function($breadcrumbs, $klijent, $vrstaNaloga)
{
    $breadcrumbs->parent('klijenti.vrsteNaloga.index', $klijent);
    $breadcrumbs->push($vrstaNaloga->Naziv, route('klijenti.vrsteNaloga.zbrojniNalog.index', $vrstaNaloga->id));
});
// Klijent > Vrste Naloga > Predlosci
Breadcrumbs::register('klijenti.vrsteNaloga.predlosci.index', function($breadcrumbs, $klijent, $vrstaNaloga)
{
    $breadcrumbs->parent('klijenti.vrsteNaloga.index', $klijent);
    $breadcrumbs->push($vrstaNaloga->Naziv, route('klijenti.vrsteNaloga.predlosci.index', $vrstaNaloga->id));
});
//Admin -> Operateri
Breadcrumbs::register('admin.operateri.index', function($breadcrumbs)
{
    $breadcrumbs->push('Admin / Operateri', route('admin.operateri.index'));
});
//Admin -> Uloge
Breadcrumbs::register('admin.uloge.index', function($breadcrumbs)
{
    $breadcrumbs->push('Admin / Uloge', route('admin.uloge.index'));
});
//Admin -> Dozvole
Breadcrumbs::register('admin.uloge.dozvole.index', function($breadcrumbs)
{
    $breadcrumbs->push('Admin / Dozvole', route('admin.dozvole.index'));
});

Breadcrumbs::register('log-viewer::dashboard', function($breadcrumbs){
    $breadcrumbs->push('Log', route('log-viewer::dashboard'));
});

Breadcrumbs::register('log-viewer::logs.list', function($breadcrumbs){
    $breadcrumbs->parent('log-viewer::dashboard');
    $breadcrumbs->push('Lista ', route('log-viewer::logs.list'));
});

Breadcrumbs::register('log-viewer::logs.show', function($breadcrumbs, $log){
    $breadcrumbs->parent('log-viewer::logs.list');
    $breadcrumbs->push($log , route('log-viewer::logs.show'));
});


// Home > Blog > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('blog');
    $breadcrumbs->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});