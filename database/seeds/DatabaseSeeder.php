<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Post;
use App\Klijent;
use App\VrstaOsobnihPrimanja;
use App\SifraNamjene;
use App\Partner;
use App\VrstaNaloga;
use App\NacinIzvrsenja;
use App\Nalog;
use App\TipParametra;
use App\ZiroRacun;
use App\Parametar;
use App\Valuta;
use App\Predlozak;
use App\ZbrojniNalog;
use App\ModelPlacanja;
use App\Permission;
use App\Role;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		/*$this->call('ModeliPlacanja');
		$this->call('NacinIzvrsenja2');
		$this->call('SifreNamjene');
		$this->call('Valute');
		$this->call('VrsteNaloga');
		$this->call('VrsteOsobnihPrimanja');
		$this->call('UsersTableSeeder');
		$this->call('permissionsTableSeeder');
		$this->call('rolesTableSeeder');
		$this->call('permission_roleTableSeeder');
		$this->call('role_userTableSeeder');
		$this->call('TipParametraTableSeeder');
		$this->call('KlijentiTableSeeder');
		$this->call('PartneriTableSeeder');
		$this->call('ZiroRacuniTableSeeder');
		$this->call('KlijentiPartneriTableSeeder');
		$this->call('ParametriTableSeeder');
		$this->call('PredlosciTableSeeder');
		$this->call('NaloziTableSeeder');*/
		$this->call('ZbrojniNalogTableSeeder');
		/*$this->call('ZbrojniNaloziNaloziTableSeeder');
		$this->call('NaloziKlijentiTbleSeeder');
		$this->call('OperateriKlijentiTbleSeeder');
		$this->call('PostsTableSeeder');*/
	}

}

class ModeliPlacanja extends Seeder {

	public function run()
	{

		DB::table('ModeliPlacanja')->delete();

		$data = [
			["00","NULL",1,1],
			["01","NULL",1,1],
			["02","NULL",1,1],
			["03","NULL",1,1],
			["04","NULL",1,1],
			["05","NULL",1,1],
			["06","NULL",1,1],
			["07","NULL",1,1],
			["08","NULL",1,1],
			["09","NULL",1,1],
			["10","NULL",1,1],
			["11","NULL",1,1],
			["12","NULL",1,1],
			["13","NULL",1,1],
			["14","NULL",1,1],
			["15","NULL",1,1],
			["16","NULL",1,1],
			["17","NULL",1,1],
			["18","NULL",1,1],
			["19","NULL",1,1],
			["21","NULL",1,1],
			["22","NULL",1,1],
			["23","NULL",1,1],
			["24","NULL",1,1],
			["26","NULL",1,1],
			["27","NULL",1,1],
			["28","NULL",1,1],
			["29","NULL",1,1],
			["30","NULL",1,1],
			["31","NULL",1,1],
			["32","NULL",1,1],
			["33","NULL",1,1],
			["34","NULL",1,1],
			["35","NULL",1,1],
			["40","NULL",1,1],
			["41","NULL",1,1],
			["42","NULL",1,1],
			["43","NULL",1,1],
			["55","NULL",1,1],
			["60","NULL",1,1],
			["61","NULL",1,1],
			["62","NULL",1,1],
			["63","NULL",1,1],
			["64","NULL",1,1],
			["65","NULL",1,1],
			["66","NULL",1,1],
			["67","NULL",1,1],
			["68","NULL",1,1],
			["69","NULL",1,1],
			["83","NULL",1,1],
			["99","NULL",1,1]
		];

		foreach ($data as $key => $value) {
			$ModeliPlacanja = new ModelPlacanja();
			$ModeliPlacanja->Vrijednost = $value[0];
			$ModeliPlacanja->regex = $value[1];
			$ModeliPlacanja->Odobrenje = $value[2];
			$ModeliPlacanja->Zaduzenje = $value[3];
			$ModeliPlacanja->save();
		}

	}

}
class NacinIzvrsenja2 extends Seeder {

	public function run()
	{

		DB::table('NacinIzvrsenja')->delete();

		$data = [
			['Specifikacija'],
			['Zbrojni nalog']
		];

		foreach ($data as $key => $value) {
			$NacinIzvrsenja = new NacinIzvrsenja();
			$NacinIzvrsenja->Naziv = $value[0];
			$NacinIzvrsenja->save();
		}

	}

}
class SifreNamjene extends Seeder {

	public function run()
	{

		DB::table('SifreNamjene')->delete();

		$data = [
			[1, 'ACCT', 'Upravljanje sredstvima - unutar banke', 'Transakcija prenošenja sredstava između dva računa istog vlasnika računa kod iste banke.', 'Upravljanje sredstvima (Cash Management)'],
			[2, 'ADVA', 'Predujam', 'Transakcija predstavlja plaćanje predujma/ avansa.', 'Općenito'],
			[3, 'AEMP', 'Aktivne politike zapošljavanja', 'Plaćanje se odnosi na aktivne politike zapošljavanja.', 'Plaća & naknade'],
			[4, 'AGRT', 'Poljoprivredni transfer', 'Transakcija se odnosi na plaćanje u poljoprivredi.', 'Komercijalna plaćanja'],
			[5, 'AIRB', 'Zračni', 'Transakcija predstavlja plaćanje za poslove vezane uz zračni prijevoz.', 'Prijevoz'],
			[6, 'ALMY', 'Plaćanje alimentacije', 'Transakcija predstavlja plaćanje alimentacije.', 'Plaća & naknade'],
			[7, 'ANNI', 'Anuitet', 'Transakcija se odnosi na plaćanje auniteta kredita, osiguranja, ulaganja i dr.', 'Ulaganje'],
			[8, 'ANTS', 'Usluge anestezije', 'Transakcija predstavlja plaćanje za usluge anestezije.', 'Zdravstvo'],
			[9, 'AREN', 'Knjiženje potraživanja', 'Transakcija se odnosi na knjiženje potraživanja', 'Komercijalna plaćanja'],
			[10, 'BECH', 'Dječji doplatak', 'Transakcija se odnosi na plaćanje kojim se pomaže roditelju/staratelju u uzdržavanju djeteta.', 'Plaća & naknade'],
			[11, 'BENE', 'Naknada za nezaposlenost/invaliditet', 'Transakcija se odnosi na plaćanje osobi koja je nezaposlena/invalid.', 'Plaća & naknade'],
			[12, 'BEXP', 'Poslovni troškovi', 'Transakcija se odnosi na plaćanje poslovnih troškova.', 'Komercijalna plaćanja'],
			[13, 'BOCE', 'Knjiženje konverzije u Back Office-u', 'Transakcija se odnosi na plaćanje koje je povezano sa knjiženjem konverzije u Back Office-u', 'Komercijalna plaćanja'],
			[14, 'BONU', 'Novčana nagrada [bonus)', 'Transakcija se odnosi na plaćanje novčane nagrade [bonusa].', 'Plaća & naknade'],
			[15, 'BUSB', 'Autobusni', 'Transakcija predstavlja plaćanje za poslove vezane uz autobusni prijevoz.', 'Prijevoz'],
			[16, 'CAFI', 'Naknada za skrbništvo', 'Transakcija je plaćanje naknade za upravljanje skrbniku računa gdje su skrbnički račun i tekući u istoj banci.', 'Ulaganje'],
			[17, 'CASH', 'Upravljanje sredstvima ? izvan banke', 'Transakcija predstavlja opću instrukciju za upravljanje sredstvima.', 'Upravljanje sredstvima [Cash Management]'],
			[18, 'CBFF', 'Kapitalna štednja', 'Transakcija se odnosi na kapitalnu štednju, odnosno štednju za umirovljenje.', 'Općenito'],
			[19, 'CBLK', 'Razmjena zbirnog kartičnog', 'Usluga koja je namirenje za zbirne kartične transakcije', 'Kartična namira'],
			[20, 'CBTV', 'Račun za kabelsku TV', 'Transakcija se odnosi na plaćanje računa za kabelsku TV.', 'Komunalne usluge'],
			[21, 'CCRD', 'Plaćanje kreditnom karticom', 'Transakcija se odnosi na plaćanje kreditnom karticom.', 'Općenito'],
			[22, 'CDBL', 'Plaćanje troškova učinjenih kreditnom karticom', 'Transakcija se odnosi na plaćanje računa za troškove učinjene kreditnom karticom.', 'Općenito'],
			[23, 'CDCB', 'Kartično plaćanje uz gotovinski povrat (Cashback)', 'Kupovina roba i usluga uz dodatnu isplatu gotovine na prodajnom mjestu', 'Kartična namira'],
			[24, 'CDCD', 'Gotovinska isplata', 'Isplata gotovine na bankomatu ili na šalteru banke', 'Kartična namira'],
			[25, 'CDOC', 'Originalno odobrenje', 'Transakcija koja omogućuje primatelju kartice izvršenje odobrenja u korist računa vlasnika kartice. Za razliku od trgovačkog povrata, originalnom odobrenju nije prethodilo plaćanje karticom. Koristi se kod odobrenj [...]', ''],
			[26, 'CDQC', 'Zamjenska gotovina', 'Kupovina roba koje su jednake gotovini poput kupona u kockarnicama.', 'Kartična namira'],
			[27, 'CFDI', 'Interna kapitalna ulaganja', 'Transakcija je plaćanje naknade za kapitalna ulaganja gdje su skrbnički račun i tekući u istoj banci.', 'Ulaganje'],
			[28, 'CFEE', 'Naknada za opoziv/storno', 'Transakcija se odnosi na plaćanje naknade za opoziv/storno.', 'Općenito'],
			[29, 'CHAR', 'Plaćanje u dobrotvorne svrhe', 'Transakcija predstavlja plaćanje u dobrotvorne svrhe.', 'Potrošač'],
			[30, 'CLPR', 'Otplata glavnice kredita za automobil', 'Transakcija predstavlja plaćanje otplate glavnice kredita za automobil.', 'Financije'],
			[31, 'CMDT', 'Plaćanje roba', 'Transakcija predstavlja plaćanje roba.', 'Ulaganje'],
			[32, 'COLL', 'Naplata', 'Transakcija predstavlja prikupljanje sredstava temeljem priljeva na račun ili izravnog terećenja', 'Upravljanje sredstvima (Cash Management)'],
			[33, 'COMC', 'Komercijalno plaćanje', 'Transakcija se odnosi na plaćanje komercijalnog kredita ili duga po kreditu', 'Komercijalna plaćanja'],
			[34, 'COMM', 'Provizija', 'Transakcija predstavlja plaćanje provizije.', 'Plaća & naknade'],
			[35, 'COMT', 'Konsolidirano plaćanje treće strane za račun potrošača', 'Transakcija predstavlja plaćanje koje obavlja treća strana ovlaštena za prikupljanje sredstava radi plaćanja u ime i za račun potrošača.', 'Potrošač'],
			[36, 'COST', 'Troškovi', 'Transakcija se odnosi na plaćanje troškova.', 'Općenito'],
			[37, 'CPYR', 'Autorsko pravo', 'Transakcija se odnosi na plaćanje autorskog prava.', 'Komercijalna plaćanja'],
			[38, 'CSDB', 'Gotovinska isplata', 'Transakcija se odnosi na gotovinsku isplatu.', 'Upravljanje sredstvima (Cash Management)'],
			[39, 'CSLP', 'Isplata socijalnih zajmova društava banci', 'Transakcija predstavlja plaćanje društva banci u svrhu financiranja socijalnih zajmova zaposlenicima.', 'Plaća & naknade'],
			[40, 'CVCF', 'Usluge skrbi za rekonvalescente', 'Transakcija predstavlja plaćanje za usluge skrbi za rekonvalescente.', 'Zdravstvo'],
			[41, 'DBTC', 'Plaćanje putem terećenja', 'Plaćanje temeljem naloga za terećenje', 'Financije'],
			[42, 'DCRD', 'Plaćanje troškova učinjenih debitnom karticom', 'Transakcija se odnosi na plaćanje troškova učinjenih debitnom karticom.', 'Općenito'],
			[43, 'DEPT', 'Depozit', 'Transakcija se odnosi na uplatu depozita.', 'Upravljanje sredstvima (Cash Management)'],
			[44, 'DERI', 'Derivativi (izvedenice)', 'Transakcija se odnosi na poslove sderivativima.', 'Ulaganje'],
			[45, 'DIVI', 'Dividenda', 'Transakcija predstavlja plaćanje dividendi.', 'Ulaganje'],
			[46, 'DMEQ', 'Medicinska oprema', 'Transakcija predstavlja plaćanje za nabavu trajne medicinske opreme', 'Zdravstvo'],
			[47, 'DNTS', 'Zubarske usluge', 'Transakcija predstavlja plaćanje za zubarske usluge.', 'Zdravstvo'],
			[48, 'ELEC', 'Račun za električnu energiju', 'Transakcija se odnosi na plaćanje računa za električnu energiju.', 'Komunalne usluge'],
			[49, 'ENRG', 'Energija', 'Transakcija se odnosi na plaćanje energije.', 'Komunalne usluge'],
			[50, 'ESTX', 'Porez na nasljedstvo', 'Transakcija se odnosi na plaćanje poreza na nasljedstvo.', 'Porez'],
			[51, 'FAND', 'Financijska pomoć u slučaju elementarnih nepogoda.', 'Financijska pomoć u slučaju elementarnih nepogoda.', 'Općenito'],
			[52, 'FERB', 'Trajektni', 'Transakcija predstavlja plaćanje za poslove vezane uz trajektni prijevoz.', 'Prijevoz'],
			[53, 'FREX', 'Kupoprodaja deviza', 'Transakcija se odnosi na poslove deviznog tržišta.', 'Ulaganje'],
			[54, 'GASB', 'Račun za plin', 'Transakcija se odnosi na plaćanje računa za plin.', 'Komunalne usluge'],
			[55, 'GDDS', 'Kupoprodaja roba', 'Transakcija se odnosi na kupovinu ili prodaju roba.', 'Komercijalna plaćanja'],
			[56, 'GDSV', 'Kupoprodaja roba i usluga', 'Transakcija se odnosi na kupovinu i prodaju roba i usluga.', 'Komercijalna plaćanja'],
			[57, 'GFRP', 'Naknada za nezaposlene', 'Naknada za nezaposlene osobe tijekom postupka insolventnosti.', 'Plaća & naknade'],
			[58, 'GOVI', 'Državno osiguranje', 'Transakcija se odnosi na plaćanje državnog osiguranja.', 'Financije'],
			[59, 'GOVT', 'Plaćanje državi/države', 'Transakcija predstavlja plaćanje državnom tijelu ili plaćanje od strane državnog tijela.', 'Općenito'],
			[60, 'GSCB', 'Kupoprodaja roba i usluga uz gotovinski povrat', 'Transakcija se odnosi na kupovinu i prodaju roba i usluga uz gotovinski povrat.', 'Komercijalna plaćanja'],
			[61, 'GVEA', 'Austrijski državni službenici, Kategorija A', 'Transakcija predstavlja plaćanje kategoriji A austrijskih državnih službenika.', 'Plaća & naknade'],
			[62, 'GVEB', 'Austrijski državni službenici, Kategorija B', 'Transakcija predstavlja plaćanje kategoriji B austrijskih državnih službenika', 'Plaća & naknade'],
			[63, 'GVEC', 'Austrijski državni službenici, Kategorija C', 'Transakcija predstavlja plaćanje kategoriji C austrijskih državnih službenika', 'Plaća & naknade'],
			[64, 'GVED', 'Austrijski državni službenici, Kategorija D', 'Transakcija predstavlja plaćanje kategoriji D austrijskih državnih službenika', 'Plaća & naknade'],
			[65, 'GWLT', 'Transfer Ministarstva branitelja', 'Plaćanje žrtvama ratnog nasilja i ratnim vojnim invalidima.', 'Plaća & naknade'],
			[66, 'HEDG', 'Hedging', 'Transakcija se odnosi na operaciju hedginga.', 'Ulaganje'],
			[67, 'HLRP', 'Otplata stambenog kredita', 'Transakcija se odnosi na otplatu stambenog kredita.', 'Financije'],
			[68, 'HLTC', 'Kućna njega bolesnika', 'Transakcija predstavlja plaćanje za usluge kućne njege bolesnika.', 'Zdravstvo'],
			[69, 'HLTI', 'Zdravstveno osiguranje', 'Transakcija predstavlja plaćanje zdravstvenog osiguranja.', 'Zdravstvo'],
			[70, 'HSPC', 'Bolnička njega', 'Transakcija predstavlja plaćanje za usluge bolničke njege.', 'Zdravstvo'],
			[71, 'HSTX', 'Porez na stambeni prostor', 'Transakcija se odnosi na plaćanje poreza na stambeni prostor.', 'Porez'],
			[72, 'ICCP', 'Neopozivo plaćanje kreditnom karticom', 'Transakcija predstavlja povrat plaćanja s izvršenog kreditnom karticom.', 'Općenito'],
			[73, 'ICRF', 'Ustanova socijalne skrbi', 'Transakcija predstavlja plaćanje usluga ustanove socijalne skrbi.', 'Zdravstvo'],
			[74, 'IDCP', 'Neopozivo plaćanje debitnom karticom', 'Transakcija predstavlja povrat plaćanja Izvršenog debitnom karticom.', 'Općenito'],
			[75, 'IHRP', 'Plaćanje rate pri kupnji na otplatu', 'Transakcija predstavlja otplatu rate kod kupnje na otplatu.', 'Općenito'],
			[76, 'INPC', 'Premija osiguranja za vozilo', 'Transakcija predstavlja plaćanje premije osiguranja za vozilo.', 'Financije'],
			[77, 'INSM', 'Rata', 'Transakcija se odnosi na plaćanje rate/obroka.', 'Općenito'],
			[78, 'INSU', 'Premija osiguranja', 'Transakcija predstavlja plaćanje premije osiguranja.', 'Financije'],
			[79, 'INTC', 'Plaćanje unutar Grupe', 'Transakcija se odnosi na plaćanje unutar Grupe Odnosno na plaćanje između dva društava koja pripadaju istoj Grupi.', 'Upravljanje sredstvima (Cash Management)'],
			[80, 'INTE', 'Kamata', 'Transakcija predstavlja plaćanje kamate.', 'Financije'],
			[81, 'INTX', 'Porez na dohodak', 'Transakcija se odnosi na plaćanje poreza na dohodak.', 'Porez'],
			[82, 'LBRI', 'Osiguranje od ozljede na radu', 'Transakcija predstavlja plaćanje osiguranja od ozljede na radu.', 'Financije'],
			[83, 'LICF', 'Naknada za licencu', 'Transakcija predstavlja plaćanje naknade za licencu.', 'Komercijalna plaćanja'],
			[84, 'LIFI', 'Životno osiguranje', 'Transakcija predstavlja plaćanje životnog osiguranja.', 'Financije'],
			[85, 'LIMA', 'Upravljanje likvidnošću', 'Prijenos s računa iniciran radi pražnjenja računa ili svođenja stanja na nulu, cashpoolinga ili sweepinga', 'Upravljanje sredstvima (Cash Management)'],
			[86, 'LOAN', 'Zajam', 'Transakcija se odnosi na odobrenje zajma zajmoprimcu.', 'Financije'],
			[87, 'LOAR', 'Otplata zajma', 'Transakcija se odnosi na otplatu zajma zajmodavcu.', 'Financije'],
			[88, 'LTCF', 'Ustanova dugoročne zdravstvene skrbi', 'Transakcija predstavlja plaćanje usluga ustanove dugoročne zdravstvene skrbi.', 'Zdravstvo'],
			[89, 'MDCS', 'Zdravstvene usluge', 'Transakcija predstavlja plaćanje za zdravstvene usluge.', 'Zdravstvo'],
			[90, 'MSVC', 'Višenamjenske usluge', 'Transakcija se odnosi na plaćanje višenamjenskih usluga.', 'Općenito'],
			[91, 'NETT', 'Saldiranje (netiranje)', 'Transakcija se odnosi na izvršavanje saldiranja (netiranja).', 'Upravljanje sredstvima (Cash Management)'],
			[92, 'NITX', 'Porez na neto dohodak', 'Transakcija se odnosi na plaćanje poreza na neto dohodak', 'Porez'],
			[93, 'NOWS', 'Nenavedeno', 'Transakcija se odnosi na plaćanje za usluge koje nisu drugdje navedene.', 'Općenito'],
			[94, 'NWCH', 'Troškovi za mrežu', 'Transakcija se odnosi na plaćanje troškova za korištenje mreže.', 'Komunalne usluge'],
			[95, 'NWCM', 'Mrežna komunikacija', 'Transakcija se odnosi na plaćanje mrežne komunikacije.', 'Komunalne usluge'],
			[96, 'OFEE', 'Početna naknada (Opening Fee)', 'Transakcija se odnosi na plaćanje početne naknade.', 'Općenito'],
			[97, 'OTHR', 'Ostalo', 'Druga vrsta plaćanja.', 'Općenito'],
			[98, 'OTLC', 'Račun za ostale telekomunikacijske usluge', 'Transakcija se odnosi na plaćanje računa za ostale telekomunikacijske usluge.', 'Komunalne usluge'],
			[99, 'PADD', 'Unaprijed odobreno terećenje', 'Transakcija se odnosi na unaprijed odobreni nalog za terećenje.', 'Općenito'],
			[100, 'PAYR', 'Platni spisak', 'Transakcija se odnosi na isplatu plaća prema platnom spisku.', 'Plaća & naknade'],
			[101, 'PENS', 'Mirovine', 'Transakcija predstavlja isplatu mirovine.', 'Plaća & naknade'],
			[102, 'PHON', 'Račun za telefon', 'Transakcija se odnosi na plaćanje računa za telefon.', 'Komunalne usluge'],
			[103, 'POPE', 'Knjiženje prodajnog mjesta', 'Transakcija se odnosi na plaćanje vezano prodajno mjesto', 'Komercijalna plaćanja'],
			[104, 'PPTI', 'Osiguranje imovine', 'Transakcija predstavlja plaćanje osiguranja imovine.', 'Financije'],
			[105, 'PRCP', 'Plaćanje troškova', 'Transakcija se odnosi na plaćanje troškova.', 'Plaća & naknade'],
			[106, 'PRME', 'Plemeniti metali', 'Transakcija se odnosi na poslovanje s plemenitim metalima.', 'Ulaganje'],
			[107, 'PTSP', 'Uvjeti plaćanja', 'Transakcija se odnosi na specifikaciju uvjeta plaćanja.', 'Općenito'],
			[108, 'RCKE', 'Ponovna prezentacija čeka', 'Transakcija se odnosi na plaćanje vezano za ponovnu prezentaciju čeka.', 'Općenito'],
			[109, 'RCPT', 'Plaćanje potvrde', 'Transakcija se odnosi na izdavanje potvrde o provedenom plaćanju.', 'Općenito'],
			[110, 'REFU', 'Povrat', 'Transakcija predstavlja povrat sredstava.', 'Općenito'],
			[111, 'RENT', 'Najam', 'Transakcija predstavlja plaćanje najma.', 'Općenito'],
			[112, 'RHBS', 'Potpora za rehabilitaciju', 'Potpora za vrijeme rehabilitacije', 'Plaća & naknade'],
			[113, 'RINP', 'Obročno plaćanje', 'Transakcija se odnosi na plaćanje ponavljajućih rata u redovitim intervalima.', 'Financije'],
			[114, 'RLWY', 'Željeznički', 'Transakcija predstavlja plaćanje za poslove vezane uz željeznički prijevoz.', 'Prijevoz'],
			[115, 'ROYA', 'Tantijemi / Prihodi od autorskog prava', 'Transakcija predstavlja plaćanje tantijema /prihoda s osnova autorskog prava.', 'Komercijalna plaćanja'],
			[116, 'SALA', 'Plaće', 'Transakcija predstavlja isplatu plaće.', 'Plaća & naknade'],
			[117, 'SAVG', 'Štednja', 'Prijenos na račun štednje/mirovine.', 'Ulaganje'],
			[118, 'SCVE', 'Kupoprodaja usluga', 'Transakcija se odnosi na kupovinu i prodaju usluga.', 'Komercijalna plaćanja'],
			[119, 'SECU', 'Vrijednosni papiri', 'Transakcija predstavlja plaćanje vrijednosnih papira.', 'Ulaganje'],
			[120, 'SEPI', 'Kupnja vrijednosnih papira interno.', 'Transakcija je plaćanje vrijednosnih papira gdje su skrbnički račun i tekući u istoj banci.', 'Ulaganje'],
			[121, 'SSBE', 'Socijalna pomoć', 'Transakcija predstavlja naknadu za socijalnu pomić odnosno plaćanje kojeg izvršava država kao socijalnu potporu pojedincima.', 'Plaća & naknade'],
			[122, 'STDY', 'Studiranje', 'Transakcija se odnosi na plaćanje troškova studiranja/školarine.', 'Općenito'],
			[123, 'SUBS', 'Pretplata', 'Transakcija se odnosi na plaćanje informacije ili pretplate', 'Komercijalna plaćanja'],
			[124, 'SUPP', 'Plaćanje dobavljaču', 'Transakcija se odnosi na plaćanje dobavljaču.', 'Komercijalna plaćanja'],
			[125, 'TAXR', 'Povrat poreza', 'Transakcija se odnosi na povrat poreza ili zakonskih obveza.', 'Porez'],
			[126, 'TELI', 'Plaćanje putem telefona', 'Transakcija se odnosi na plaćanje koje je inicirano telefonom.', 'Općenito'],
			[127, 'TRAD', 'Trgovačke usluge', 'Transakcija se odnosi na plaćanje trgovačkih usluga.', 'Komercijalna plaćanja'],
			[128, 'TREA', 'Riznični transferi', 'Transakcija se odnosi na riznično poslovanje.', 'Ulaganje'],
			[129, 'TRFD', 'Zaklada', 'Transakcija koja se odnosi na plaćanje zaklade.', 'Financije'],
			[130, 'UBIL', 'Komunalne naknade', 'Transakcija se odnosi na plaćanje komunalnih usluga za plin, vodu i/ili električnu energiju.', 'Komunalne usluge'],
			[131, 'VATX', 'Plaćanje poreza na dodanu vrijednost', 'Transakcija predstavlja plaćanje poreza na dodanu vrijednost.', 'Porez'],
			[132, 'VIEW', 'Oftalmološke/okulističke usluge', 'Transakcija predstavlja plaćanje za oftamološke/okulističke usluge.', 'Zdravstvo'],
			[133, 'WEBI', 'Plaćanje putem interneta', 'Transakcija se odnosi na plaćanje koje je inicirano internetom.', 'Općenito'],
			[134, 'WHLD', 'Porez po odbitku', 'Transakcija se odnosi na plaćanje poreza po odbitku.', 'Porez'],
			[135, 'WTER', 'Račun za vodu', 'Transakcija se odnosi na plaćanje računa za vodu.', 'Komunalne usluge'],
			[136, 'TAXS', 'Plačanje poreza', 'Transakcija predstavlja plaćanje poreza.', 'Porez']
		];

		foreach ($data as $key => $value) {
			$SifraNamjene = new SifraNamjene();
			$SifraNamjene->id = $value[0];
			$SifraNamjene->Sifra = $value[1];
			$SifraNamjene->Naziv = $value[2];
			$SifraNamjene->Definicija = $value[3];
			$SifraNamjene->Klasifikacija = $value[4];
			$SifraNamjene->save();
		}

	}

}
class Valute extends Seeder {

	public function run()
	{

		DB::table('Valute')->delete();

		$data = [
			['HRK', 191, 'Hrvatska kuna']
		];

		foreach ($data as $key => $value) {
			$Valuta = new Valuta();
			$Valuta->Alfa = $value[0];
			$Valuta->Numericka = $value[1];
			$Valuta->Naziv = $value[2];
			$Valuta->save();
		}

	}

}
class VrsteNaloga extends Seeder {

	public function run()
	{

		DB::table('VrstaNaloga')->delete();

		$data = [
			[1, 'Nacionalna(kn)'],
			[2, 'Nacionalna(strVal)'],
			[3, 'Međunarodna'],
			[4, 'Plaće']
		];

		foreach ($data as $key => $value) {
			$VrstaNaloga = new VrstaNaloga();
			$VrstaNaloga->id = $value[0];
			$VrstaNaloga->Naziv = $value[1];
			$VrstaNaloga->save();
		}

	}
}
class VrsteOsobnihPrimanja extends Seeder {

	public function run()
	{

		DB::table('VrsteOsobnihPrimanja')->delete();

		$data = [
			[1, 100, 'Osobno primanje isplačeno u cijelosti'],
			[2, 110, 'Isplata dijela osobnog primanja'],
			[3, 120, 'Osobno primanje umanjeno za zaštičeni dio'],
			[4, 130, 'Ugovor o dijelu'],
			[5, 140, 'Rad za vrijeme školovanja'],
			[6, 150, 'Isplata dividende'],
			[7, 160, 'Naknada članova Upravnog vijeća, Skupština, Nadzornih odbora'],
			[8, 170, 'Primanja od iznajmljivanja turističkih kapaciteta'],
			[9, 180, 'Najam'],
			[10, 190, 'Prijevoz'],
			[11, 200, 'Službeni put'],
			[12, 210, 'Terenski dodatak'],
			[13, 220, 'Naknada za odvojeni život'],
			[14, 230, 'Naknada za bolovanje'],
			[15, 240, 'Naknada za korištenje privatnog automobila u službene svrhe'],
			[16, 250, 'Naknada za prekovremeni rad, bonusi, stimulacije, ostale nagrade'],
			[17, 260, 'Regres'],
			[18, 270, 'Božičnica, uskrsnica'],
			[19, 280, 'Dječji dar'],
			[20, 290, 'Stipendije, pomoć studentima/u?enicima za opremu, knjige i ostalo'],
			[21, 300, 'Pomoć u slučaju stupanja u brak, smrti zaposlenika/člana obitelji zaposlenika'],
			[22, 310, 'Pomoć u slučaju rođenja djeteta'],
			[23, 320, 'Otpremnina'],
			[24, 399, 'Ostala osobna primanja']
		];

		foreach ($data as $key => $value) {
			$VrstaOsobnihPrimanja = new VrstaOsobnihPrimanja();
			$VrstaOsobnihPrimanja->id = $value[0];
			$VrstaOsobnihPrimanja->Sifra = $value[1];
			$VrstaOsobnihPrimanja->Naziv = $value[2];
			$VrstaOsobnihPrimanja->save();
		}

	}
}
class UsersTableSeeder extends Seeder {

	public function run()
	{

		DB::table('Operateri')->delete();

		$faker = Faker\Factory::create();
		for ($i=0; $i < 200; $i++) {
			$user = new User;
			$user->name = $faker->name;
			$user->email = $faker->unique()->email;
			$user->password = Hash::make('secret');
			$user->save();
		}

	}

}
class permissionsTableSeeder extends Seeder {

	public function run()
	{

		DB::table('permissions')->delete();

		$data = [
			['create','Dodavanje', 'Dodavanje zapisa u bazu'],
			['read','Pregledavanje', 'Pregledavanje zapisa iz baze'],
			['edit','Uređivanje', 'Uređivanje zapisa u bazi'],
			['delete','Brisanje', 'Brisanje zapisa iz baze'],
		];

		foreach ($data as $key => $value) {
			$Permission = new Permission();
			$Permission->name = $value[0];
			$Permission->display_name = $value[1];
			$Permission->description = $value[2];
			$Permission->save();
		}

	}
}
class rolesTableSeeder extends Seeder {

	public function run()
	{

		DB::table('roles')->delete();

		$data = [
			['SuperAdmin','Super Administrator', 'Osoba sa najvišim privilegijama u sustavu'],
			['Admin','Administrator', 'Osoba koja upravlja korisnicima'],
			['Moderator','Moderator', 'Osoba koja upravlja sadržajem'],
			['Operater','Operater', 'Korisnik sustava'],
		];

		foreach ($data as $key => $value) {
			$Role = new Role();
			$Role->name = $value[0];
			$Role->display_name = $value[1];
			$Role->description = $value[2];
			$Role->save();
		}

	}
}
class permission_roleTableSeeder extends Seeder{
	public function run()
	{
		DB::table('permission_role')->delete();

		$faker = Faker\Factory::create();
		$permission = Permission::lists('id')->all();
		$role = Role::lists('id')->all();
		foreach ($role as $key=>$value) {
			DB::table('permission_role')->insert([
				'permission_id' => $faker->randomElement($permission),
				'role_id' => $value
			]);
		}
	}
}
class role_userTableSeeder extends Seeder{
	public function run()
	{
		DB::table('role_user')->delete();

		$faker = Faker\Factory::create();
		$role = Role::lists('id')->all();
		$user = User::lists('id')->all();
		foreach ($user as $key=>$value) {
			DB::table('role_user')->insert([
				'user_id' => $value,
				'role_id' => $faker->randomElement($role)
			]);
		}
	}
}
class TipParametraTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('TipParametra')->delete();

		$faker = Faker\Factory::create();
		for ($i = 0; $i < 200; $i++) {
			$TipParametra = new TipParametra;
			$TipParametra->NazivTipa = $faker->name;
			$TipParametra->save();
		}

	}
}
class KlijentiTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('Klijenti')->delete();

		$faker = Faker\Factory::create();
		for ($i = 0; $i < 100; $i++) {
			$Klijenti = new Klijent;
			$Klijenti->Naziv = $faker->company;
			$Klijenti->save();
		}

	}
}
class PartneriTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('Partneri')->delete();

		$faker = Faker\Factory::create();
		for ($i = 0; $i < 1000; $i++) {
			$Partneri = new Partner;
			$Partneri->Naziv = $faker->company;
			$Partneri->Adresa = $faker->streetAddress;
			$Partneri->Email = $faker->email;
			$Partneri->Telefon = $faker->phoneNumber;
			$Partneri->Mobitel = $faker->phoneNumber;
			$Partneri->OIB = $faker->unique()->creditCardNumber;
			$Partneri->save();
		}

	}
}
class ZiroRacuniTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('ZiroRacuni')->delete();

		$faker = Faker\Factory::create();
		$partner = Partner::lists('id')->all();
		for ($i = 0; $i < 2000; $i++) {
			$ZiroRacuni = new ZiroRacun;
			$ZiroRacuni->IBAN = $faker->unique()->creditCardNumber;
			$ZiroRacuni->VaziOd = $faker->dateTime;
			$ZiroRacuni->VaziDo = $faker->dateTime;
			$ZiroRacuni->PartneriId = $faker->randomElement($partner);;
			$ZiroRacuni->save();
		}

	}
}
class ParametriTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('Parametri')->delete();

		$faker = Faker\Factory::create();
		$tipParametra = TipParametra::lists('id')->all();
		$operateri = User::lists('id')->all();
		$klijenti = Klijent::lists('id')->all();
		for ($i = 0; $i < 2000; $i++) {
			$Parametri = new Parametar;
			$Parametri->NazivParametra = $faker->unique()->text(20);
			$Parametri->OpisParametra = $faker->text(100);
			$Parametri->Vrijednost = $faker->text(10);
			$Parametri->TipParametraId = $faker->randomElement($tipParametra);
			$Parametri->OperaterId = $faker->optional()->randomElement($operateri);
			$Parametri->KlijentiId = $faker->optional()->randomElement($klijenti);
			$Parametri->save();
		}

	}
}
class OperateriKlijentiTbleSeeder extends Seeder
{
	public function run()
	{
		DB::table('OperateriKlijenti')->delete();

		$faker = Faker\Factory::create();
		$operateri = User::lists('id')->all();
		$klijenti = Klijent::lists('id')->all();
		for ($i = 0; $i < 2000; $i++) {
			DB::table('OperateriKlijenti')->insert([
				'OperateriId' => $faker->randomElement($operateri),
				'KlijentiId' => $faker->randomElement($klijenti)
			]);
		}
	}
}
class KlijentiPartneriTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('KlijentiPartneri')->delete();

		$faker = Faker\Factory::create();
		$partneri = Partner::lists('id')->all();
		$klijenti = Klijent::lists('id')->all();
		for ($i = 0; $i < 4000; $i++) {
			DB::table('KlijentiPartneri')->insert([
				'Partneri_id' => $faker->randomElement($partneri),
				'Klijenti_id' => $faker->randomElement($klijenti),
				'Primatelj' => $faker->numberBetween($min = 0, $max = 1),
				'Platitelj' => $faker->numberBetween($min = 0, $max = 1)
			]);
		}
	}
}
class PredlosciTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('Predlosci')->delete();

		$faker = Faker\Factory::create();
		$VrsteOsobnihPrimanjaId = VrstaOsobnihPrimanja::lists('id')->all();
		$SifreNamjeneId = SifraNamjene::lists('id')->all();
		$ValuteId = Valuta::lists('id')->all();
		$PlatiteljId = Partner::lists('id')->all();
		$PrimateljId = ZiroRacun::lists('id')->all();
		$ModelOdobrenjaId = ModelPlacanja::where('Odobrenje',1)->lists('id')->all();
		$ModelZaduzenjaId = ModelPlacanja::where('Zaduzenje',1)->lists('id')->all();
		$VrstaNalogaId = VrstaNaloga::lists('id')->all();
		$klijenti = Klijent::lists('id')->all();
		for ($i = 0; $i < 2000; $i++) {
			$Predlosci = new Predlozak;
			$Predlosci->Naziv = $faker->text(50);
			$Predlosci->ModelOdobrenjaId = $faker->randomElement($ModelOdobrenjaId);
			$Predlosci->BrojOdobrenja = $faker->text(22);
			$Predlosci->ModelZaduzenjaId = $faker->randomElement($ModelZaduzenjaId);
			$Predlosci->BrojZaduzenja = $faker->text(22);
			$Predlosci->Iznos = $faker->randomFloat(2);
			$Predlosci->Opis = $faker->text(50);
			$Predlosci->DatumIzvrsenja = $faker->date();
			$Predlosci->VrsteOsobnihPrimanjaId = $faker->optional()->randomElement($VrsteOsobnihPrimanjaId);
			$Predlosci->SifreNamjeneId = $faker->randomElement($SifreNamjeneId);
			$Predlosci->ValuteId = $faker->randomElement($ValuteId);
			$Predlosci->PlatiteljId = $faker->randomElement($PlatiteljId);
			$Predlosci->ZiroPrimatelja = $faker->randomElement($PrimateljId);
			$Predlosci->KlijentiId = $faker->randomElement($klijenti);
			$Predlosci->VrstaNalogaId = $faker->randomElement($VrstaNalogaId);
			$Predlosci->save();
		}

	}
}
class NaloziTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('Nalozi')->delete();

		$faker = Faker\Factory::create();
		$VrsteOsobnihPrimanjaId = VrstaOsobnihPrimanja::lists('id')->all();
		$SifreNamjeneId = SifraNamjene::lists('id')->all();
		$ValuteId = Valuta::lists('id')->all();
		$PlatiteljId = Partner::/*where('Platitelj',1)->*/lists('id')->all();
		$PrimateljId = ZiroRacun::/*where('Primatelj',1)->*/lists('id')->all();
		$ModelOdobrenjaId = ModelPlacanja::where('Odobrenje',1)->lists('id')->all();
		$ModelZaduzenjaId = ModelPlacanja::where('Zaduzenje',1)->lists('id')->all();
		$VrstaNalogaId = VrstaNaloga::lists('id')->all();
		for ($i = 0; $i < 2000; $i++) {
			$Nalozi = new Nalog;
			$Nalozi->Naziv = $faker->text(50);
			$Nalozi->ModelOdobrenjaId = $faker->randomElement($ModelOdobrenjaId);
			$Nalozi->BrojOdobrenja = $faker->text(22);
			$Nalozi->ModelZaduzenjaId = $faker->randomElement($ModelZaduzenjaId);
			$Nalozi->BrojZaduzenja = $faker->text(22);
			$Nalozi->Iznos = $faker->randomFloat(2);
			$Nalozi->Opis = $faker->text(100);
			$Nalozi->DatumIzvrsenja = $faker->date();
			$Nalozi->VrsteOsobnihPrimanjaId = $faker->optional()->randomElement($VrsteOsobnihPrimanjaId);
			$Nalozi->SifreNamjeneId = $faker->randomElement($SifreNamjeneId);
			$Nalozi->ValuteId = $faker->randomElement($ValuteId);
			$Nalozi->PlatiteljId = $faker->randomElement($PlatiteljId);
			$Nalozi->ZiroPrimatelja = $faker->randomElement($PrimateljId);
			$Nalozi->VrstaNalogaId = $faker->randomElement($VrstaNalogaId);
			$Nalozi->save();
		}

	}
}
class ZbrojniNalogTableSeeder extends Seeder
{
	public function run()
	{
		//DB::table('ZbrojniNalog')->delete();

		$faker = Faker\Factory::create();
		$ZiroRacun = ZiroRacun::all();
		//$NacinIzvrsenjaId = NacinIzvrsenja::lists('id')->all();
		//$klijenti = Klijent::lists('id')->all();

		foreach ($ZiroRacun as $nal) {
			$nal->Primatelj = $faker->numberBetween($min = 0, $max = 1);
			$nal->Platitelj = $faker->numberBetween($min = 0, $max = 1);
			$nal->update();
		}

	}
}
class ZbrojniNaloziNaloziTableSeeder extends Seeder{
	public function run()
	{
		DB::table('ZbrojniNalogNalozi')->delete();

		$faker = Faker\Factory::create();
		$nalozi = Nalog::lists('id')->all();
		$zbrojNiNalogId = ZbrojniNalog::lists('id')->all();
		for ($i = 0; $i < 5000; $i++) {
			DB::table('ZbrojniNalogNalozi')->insert([
				'ZbrojniNalogId' => $faker->randomElement($zbrojNiNalogId),
				'NaloziId' => $faker->randomElement($nalozi)
			]);
		}
	}
}
class NaloziKlijentiTbleSeeder extends Seeder{
	public function run()
	{
		DB::table('NaloziKlijenti')->delete();

		$faker = Faker\Factory::create();
		$nalozi = Nalog::lists('id')->all();
		$klijenti = Klijent::lists('id')->all();
		for ($i = 0; $i < 5000; $i++) {
			DB::table('NaloziKlijenti')->insert([
				'NaloziId' => $faker->randomElement($nalozi),
				'KlijentiId' => $faker->randomElement($klijenti)
			]);
		}
	}
}
class PostsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('posts')->delete();

		$faker = Faker\Factory::create();
		$users = User::all();
		for ($i=0; $i < 500; $i++) {
			$post = new Post;
			$post->title = $faker->paragraph;
			$users->random(1)->posts()->save($post);
		}

	}

}
