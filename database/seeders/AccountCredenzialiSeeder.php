<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountCredenzialiSeeder extends Seeder
{
    public function run(): void
    {
        $clienteId = function(string $nome): int {
            return DB::table('clienti')->where('ragione_sociale', $nome)->value('id') ?? 0;
        };

        $creds = [
            ['A Day S.r.l.', 'cPanel', 'aday.it', 'https://86.107.36.161:2083', 'aday', 'Ady12301!'],
            ['AQ Italy S.r.l.', 'cPanel', 'aqitaly.it', 'https://185.81.2.18:2083', 'aqitaly', 'Aqita-ACly11!'],
            ['Absolute Ceramica Positano S.a.s.', 'cPanel', 'absoluteceramicapositano.com', 'https://185.81.2.18:2083', 'absoluteceramica', 'abs2019cer!'],
            ['Al Mare S.r.l.s.', 'cPanel', 'almarebistrot.it', 'https://86.107.36.161:2083', 'almarebit', 'AlMa.2022!'],
            ['Al Mare S.r.l.s.', 'cPanel', 'almarebistrot.com', 'https://86.107.36.161:2083', 'almarebcom', 'AlMa.2022!'],
            ['Al Mare S.r.l.s.', 'cPanel', 'almarerestaurant.it', 'https://86.107.36.161:2083', 'almarerit', 'AlMa.2022!'],
            ['Al Mare S.r.l.s.', 'cPanel', 'almarerestaurant.com', 'https://86.107.36.161:2083', 'almarercom', 'AlMa.2022!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'cartieraconfalone.it', 'https://185.81.2.18:2083', 'carconfit3', 'confa003lone'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'centrodiagnosticobattipagliese.it', 'https://185.81.2.18:2083', 'centrodiagnostic', 'Centr0001!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'centrodiagnosticosanciro.it', 'https://185.81.2.18:2083', 'centrosanciro', 'Centr0001!12'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'irussohairstyle.it', 'https://185.81.4.134:2083', 'irussohairstyle', 'irusso--hairstyle001'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'man-lab.it', 'https://185.81.4.134:2083', 'manlab', 'man81lab72!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'marigoitalia.com', 'https://185.81.4.134:2083', 'marigoitalia', 'MarGo2023.'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'novecento-napoletano.it', 'https://185.81.4.134:2083', 'novecentonapolet', 'novecento--napolet001'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'pcaonline.it', 'https://46.16.90.63:2083', 'pcaonline', 'Pca2019online!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'specialitadallacampania.com', 'https://185.81.4.134:2083', 'sdellac', 'SpeDC2021!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'vit-tipremia.it', 'https://185.81.4.134:2083', 'vittipremia', 'vitti--premia!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'confaloneshop.it', '', 'conshop', 'ConShoP2021!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'cartieraconfalone.com', 'https://185.81.4.134:2083', 'cartconf', 'cconfalone2022.'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'qualisan.com', 'https://46.16.90.63:2083', 'qualisan', 'Quasan2019!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'algoritmica.it', 'https://86.107.36.161:2083', 'algo', 'AL789go!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'confalone.it', 'https://86.107.36.161:2083', 'confalone', 'confa000lone'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'marigoshop.it', 'https://86.107.36.161:2083', 'marigoshop', 'MarigoS2020!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'comatdairyequipment.com', 'https://46.16.90.63:2083', 'comatde', 'ComDaiEqu2022!'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'comatonline.ca', 'https://86.107.36.161:2083', 'comatca', 'c7bDq53pJx4'],
            ['Algoritmica LAB S.c.r.l.', 'cPanel', 'massimopetrosino.com', 'https://86.107.36.161:2083', 'maspet', 'm8vDw42p.'],
            ['Beta Cavi S.r.l.', 'cPanel', 'betacavi.it', 'https://185.81.2.18:2083', 'becavit', 'Be2019cavi!'],
            ['Beta Cavi S.r.l.', 'cPanel', 'betacavihd.com', 'https://185.81.2.18:2083', 'betacavihd', 'betac4--v1hd!'],
            ['Beta Cavi S.r.l.', 'cPanel', 'fire-evac-tour.com', 'https://185.81.4.134:2083', 'firevactour', 'fir4vA-ct0ur'],
            ['Beta Cavi S.r.l.', 'cPanel', 'marcopontecorvo.net', 'https://185.81.4.134:2083', 'marcopontecorvo', 'marcop0--!ntecorv0!'],
            ['Beta Cavi S.r.l.', 'cPanel', 'dev.fire-evac-tour.com', 'https://185.81.4.134:2083', 'firevactour2', 'FirEvaTou2023!'],
            ['Beta Cavi S.r.l.', 'cPanel', 'staging.fire-evac-tour.com', 'https://185.81.4.134:2083', 'firevactour3', 'FirEvaTou2023!'],
            ['Beta Cavi S.r.l.', 'cPanel', 'smartintegration.it', '', 'smart', 'SmaInt2026!fire'],
            ['Beta Cavi S.r.l.', 'cPanel', 'dev.fire-evac-tour.com', '', 'smart', 'SmaInt2026!fire'],
            ['Cantine Marisa Cuomo S.r.l.', 'cPanel', 'granfuror.it', 'https://185.81.4.134:2083', 'granfuror', 'GranFuror2019!'],
            ['Cantine Marisa Cuomo S.r.l.', 'cPanel', 'marisacuomo.com', 'https://217.64.200.54:2083', 'marisacuomo', 'marisa2019cuomo!'],
            ['Cantine Marisa Cuomo S.r.l.', 'cPanel', 'marisacuomo.eu', 'https://185.81.4.134:2083', 'marisacuomo2', 'Marisa2022Cuomo!'],
            ['Castrovilli S.r.l.', 'cPanel', 'castrovilli.com', 'https://86.107.36.161:2083', 'castrovilli', 'c4stro-vill1'],
            ['Centro Diagnostico Mandarino di Lucia Zampoli S.a.s.', 'cPanel', 'diagnosticamandarino.it', 'https://185.81.4.134:2083', 'diagnosticamanda', 'diagn0Astic4-mand4'],
            ['CoFren S.r.l.', 'cPanel', 'frendo.it', 'https://86.107.36.161:2083', 'frendo', 'Frendo2019!'],
            ['Consac IES - Infrastrutture energia servizi S.p.A', 'cPanel', 'consacinfrastrutture.it', 'https://185.81.4.134:2083', 'consacinfrastrut', 'consacin--fr4strut!'],
            ['Covit S.r.l.', 'cPanel', 'covit.it', 'https://86.107.36.161:2083', 'covit', 'c0-vit'],
            ["D'Onofrio Domenico", 'cPanel', 'agrifood.biz', 'https://46.16.90.63:2083', 'agrifood', 'Agri2019!'],
            ["D'Onofrio Domenico", 'cPanel', 'dadomatica.it', 'https://185.81.4.134:2083', 'dadomatica', 'dado2023matica!'],
            ["D'Onofrio Domenico", 'cPanel', 'domusconstructions.com', 'https://185.81.4.134:2083', 'domusconstructio', 'DomCos2020!'],
            ["D'Onofrio Domenico", 'cPanel', 'lsi.cr.it', 'https://185.81.4.134:2083', 'lsicr', 'Lcr.2022!'],
            ["D'Onofrio Domenico", 'cPanel', 'lucaghisetti.it', 'https://185.81.4.134:2083', 'lucaghisetti', 'lucghi2019!'],
            ["D'Onofrio Domenico", 'cPanel', 'offanengoservizi.it', 'https://185.81.4.134:2083', 'offanengos', 'Offa2019servizi!'],
            ["D'Onofrio Domenico", 'cPanel', 'saresa.it', 'https://185.81.4.134:2083', 'saresa', 'Sare2019sa!'],
            ["D'Onofrio Domenico", 'cPanel', 'scapi.eu', 'https://46.16.90.63:2083', 'scapi', 'Scapi2019!'],
            ["D'Onofrio Domenico", 'cPanel', 'studiocantoniluca.it', 'https://185.81.4.134:2083', 'studiocantoni', 'Studio2019cantoni!'],
            ['Dama S.r.l.', 'cPanel', 'damaim.it', 'https://185.81.4.134:2083', 'damaim', 'dama2019im!'],
            ['Di Emme Elettronica S.a.s. di Adriano Aniello Mastrogiovanni', 'cPanel', 'diemmesas.it', 'https://185.81.4.134:2083', 'diemmesas', 'Diem2019sas!'],
            ['Digitecno S.n.c.', 'cPanel', 'comune.fanoadriano.te.it', 'https://85.18.255.135:2083', 'fanoadriano', 'Fano2019adriano!'],
            ['Elettroferroviaria S.r.l.', 'cPanel', 'elettroferroviaria.it', 'https://86.107.36.161:2083', 'elettroferr', 'EleTTro2023!'],
            ['Federpellami S.p.a.', 'cPanel', 'federpellami.it', 'https://185.81.4.134:2083', 'federpellami', 'Feder2019pellami!'],
            ["Fico d'India Holidays S.a.s.", 'cPanel', 'locandadellejanare.it', 'https://185.81.4.134:2083', 'locandadellej', 'loc4--!34ndadellej!'],
            ['Francesco Spera & Figli S.r.l.', 'cPanel', 'confezionispera.it', 'https://185.81.4.134:2083', 'confezionispe', 'confezi-0nispe'],
            ['Gamma Tributi S.r.l.', 'cPanel', 'calcoloici.it', 'https://46.16.90.29:2083', 'calcoloici', 'Calcolo2019ici!'],
            ['Gamma Tributi S.r.l.', 'cPanel', 'calcolo-imu.it', 'https://46.16.90.29:2083', 'calcoimu', 'Calco2019imu!'],
            ['Gruppo Agenti FATA Assicurazioni', 'cPanel', 'gafata.it', 'https://199.34.228.65:2083', 'gafata', 'Ga2019fata!'],
            ['Hotel Belvedere S.r.l.', 'cPanel', 'belvederehotel.it', 'https://185.81.2.18:2083', 'belvederehotel', 'belved--erehot4l!'],
            ['Hotel Belvedere S.r.l.', 'cPanel', 'demo.belvederehotel.it', 'https://185.81.4.134:2083', 'andrea', 'Bel2024vedere!'],
            ['Hotel Belvedere S.r.l.', 'cPanel', 'stage.belvederehotel.it', 'https://185.81.2.18:2083', 'belvedere3', 'Bel2024vedere!'],
            ['Hotel Pensione Vittoria', 'cPanel', 'bbvittoria-amalficoast.it', 'https://185.81.2.18:2083', 'hotelvittoria', 'hotel--vittori4!'],
            ['Hotel Pensione Vittoria', 'cPanel', 'hotel-vittoria.it', 'https://185.81.4.134:2083', 'hotvit2', 'Hot2019vit!'],
            ['Il Centro S.r.l.', 'cPanel', 'ilcentrosrl.it', 'https://185.81.4.134:2083', 'ilcentrosrl', '1lc3ntr0-srl'],
            ['Intelligent Information Technology S.r.l.', 'cPanel', 'intellit.it', 'https://86.107.36.161:2083', 'intellit', 'Inte2019!'],
            ['Intelligent Information Technology S.r.l.', 'cPanel', 'netexpert.it', 'https://46.16.90.63:2083', 'netexpert', 'Net2019expert!'],
            ['Intelligent Information Technology S.r.l.', 'cPanel', 'soluzionecad.com', 'https://86.107.36.161:2083', 'soluzionecad', 'Soluzione2019cad!'],
            ['Komiv S.r.l.', 'cPanel', 'komiv.it', 'https://86.107.36.161:2083', 'komiv', 'k8vHt62p!'],
            ['L.F.G.M. Inox S.r.l.', 'cPanel', 'lfgminox.it', 'https://185.81.4.134:2083', 'lfgminox', 'lfgm2019inox!'],
            ['La Casa delle Stelle di Carmine Di Bianco', 'cPanel', 'lacasadellestelle.it', 'https://185.81.4.134:2083', 'lacasadellest', 'Lacasa-d3llest!'],
            ['La Marina de "Il Leone di Caprera" S.r.l.', 'cPanel', 'portodicamerota.it', 'https://185.81.4.134:2083', 'portodicamerota', 'Portodi--camerotA-!'],
            ['Locanda degli Agrumi di Milo Salvatore', 'cPanel', 'locandadegliagrumi.it', 'https://185.81.4.134:2083', 'locandaagrumi', 'LocandA2019!'],
            ['M. G. Car S.r.l.', 'cPanel', 'mgcarsrl.com', 'https://185.81.4.134:2083', 'mgcasrl', 'MH-01casrl'],
            ['Marino Amerigo S.r.l.', 'cPanel', 'amerigomarino.it', 'https://185.81.2.18:2083', 'amerigomarino', 'amerig0--marin0!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'arcrusso.it', 'https://46.16.90.63:2083', 'arcrusso', 'Arc2019russo!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'grimasal.it', 'https://185.81.4.134:2083', 'grimasal', 'Grima2019sal!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'lombardifrutta.com', 'https://46.16.90.63:2083', 'lombardifrutta', 'Lom2022fru!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'moscardiniangri.it', 'https://185.81.4.134:2083', 'moscardiniangri', 'Mos2019angri!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'scadasystem.it', 'https://185.81.4.134:2083', 'scadasystem', 'scad4--system!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'sic-informatica.it', 'https://46.16.90.63:2083', 'sicinfo', 'Sic2019web!'],
            ['Multinet S.c.a.r.l.', 'cPanel', 'sicweb.it', 'https://46.16.90.63:2083', 'sicweb', 'Sic2019web!'],
            ['Officine Zephiro di Gabriele Cavaliere', 'cPanel', 'coopsantandrea.it', 'https://46.16.90.63:2083', 'coopsandrea', 'CoopS2019Andrea!'],
            ['Officine Zephiro di Gabriele Cavaliere', 'cPanel', 'officinezephiro.com', 'https://185.81.4.134:2083', 'officinezephi', 'offic1nez-3phy'],
            ['Osculati S.r.l.', 'cPanel', 'osculati.it', '', 'osculati', 'Osculati2019!'],
            ['Osculati S.r.l.', 'cPanel', 'osculati.site', 'https://185.81.4.134:2083', 'osculatisite', 'Osculati2024!'],
            ['Osculati S.r.l.', 'cPanel', 'osculati.net', 'https://86.107.36.161:2083', 'oscu2lati', 'Oscu2022lati!'],
            ['Osculati S.r.l.', 'cPanel', 'osculati.us', 'https://86.107.36.161:2083', 'osculati', 'o7nFr53s.'],
            ['Prolab Studio Associato di Progettazione', 'cPanel', 'prolabassociati.it', 'https://185.81.4.134:2083', 'prolabassocia', 'prolab-ass0cia!'],
            ['RCA Consulting S.r.l.', 'cPanel', 'orsomiele.it', 'https://185.81.4.134:2083', 'orsomiele', '0rsom1-ele!'],
            ['Renato Romano', 'cPanel', 'ecdev.jopistacchio.it', 'https://185.81.4.134:2083', 'ecdevjp2020', 'EcDevJP2020.'],
            ['Renato Romano', 'cPanel', 'ecommerce.jopistacchio.it', 'https://185.81.4.134:2083', 'ecomjp2020', 'EcomJoPi2020.'],
            ['Renato Romano', 'cPanel', 'ecommerce2.jopistacchio.it', 'https://185.81.4.134:2083', 'ecom2jp2020', 'Ecom2JoPi2020.'],
            ['Renato Romano', 'cPanel', 'irisconsulting.it', 'https://185.81.4.134:2083', 'irisconsulting', 'iris2019-consulting2019!'],
            ['Renato Romano', 'cPanel', 'irisip.net', 'https://46.16.90.63:2083', 'irisipnet', 'Iris2019net!'],
            ['Renato Romano', 'cPanel', 'irispec.it', 'https://185.81.4.134:2083', 'irispec', 'Iris2019pec!'],
            ['Renato Romano', 'cPanel', 'limonicostadiamalfi.it', 'https://185.81.4.134:2083', 'limoniamalfi', 'l89c72a4s!'],
            ['Renato Romano', 'cPanel', 'amalfinet.it', 'https://46.16.90.63:2083', 'amalfinet', 'Amalfi2019net!'],
            ['Renato Romano', 'cPanel', 'jopistacchio.it', 'https://86.107.36.161:2083', 'jopistacchio', 'Jo2019pistacchio!'],
            ['Renato Romano', 'cPanel', 'renatoromano.it', '', 'renrom', 'Ren2019rom!'],
            ['Renato Romano', 'cPanel', 'ticket.irisip.net', 'https://86.107.36.161:2083', 'ticket', 'Tic2020ket!'],
            ['Renato Romano', 'cPanel', 'prenota.irisip.net', 'https://86.107.36.161:2083', 'prenota', 'Pre2020nota!'],
            ['Renato Romano', 'cPanel', 'mobilitymanagement.consulting', 'https://86.107.36.161:2083', 'mobilitym', 'MobMan2021'],
            ['Renato Romano', 'cPanel', 'metalstyle.irisip.net', 'https://86.107.36.161:2083', 'metalstyle', 'MetSty2022!'],
            ['Sacar Forni S.r.l.', 'cPanel', 'sacarforni.it', 'https://86.107.36.161:2083', 'sacarforni', 's4carf0rni!'],
            ['Sainvest S.r.l.', 'cPanel', 'sainvest.it', 'https://185.81.4.134:2083', 'sainvest', 'sa1n--v3st!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'agriturismo-lavigna.it', 'https://46.16.90.63:2083', 'agriturismolav', 'Agri2019lavigna!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'dallair.com', 'https://46.16.90.63:2083', 'dalaircom', 'Dall2019air!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'dallair.net', 'https://46.16.90.63:2083', 'dallairnet', 'Dall2024air!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'dmigrandimacchine.com', '', 'dmigm', 'DMI2019gm!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'm2gsistemi.it', 'https://46.16.90.63:2083', 'm2gsistemi', 'm2gs2019!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'meridionalstampi.com', 'https://185.81.4.134:2083', 'meridionalstampi', 'meridionA--lstamp1!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'nataleinreggia.it', 'https://185.81.4.134:2083', 'nataleinreggia', 'natal3--01inreggia'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'peclegal.it', 'https://185.81.4.134:2083', 'peclegal', 'Pec2019legal!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'pnpspedizioni.com', 'https://46.16.90.63:2083', 'pnpspedizioni', 'pnp2019sped!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'pnpvini.com', 'https://185.81.4.134:2083', 'pnpvini', 'pnp2019vini!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'sartoreonline.it', 'https://46.16.90.63:2083', 'sartoreonline', 'Sarto2019online!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'serviceinfoweb.com', 'https://46.16.90.63:2083', 'siwposta', 'EnzCav2019!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'serviceinfoweb.it', 'https://185.81.4.134:2083', 'siwit', 'EnzCav2019!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'trasportilettieri.com', 'https://46.16.90.63:2083', 'trasportilettier', 'Tras2019lettieri'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'dematteissartoria.it', 'https://46.16.90.63:2083', 'dematteis', 'DeMatte2021!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'franco62.it', 'https://46.16.90.63:2083', 'franco62', 'F62ranc2022!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'spagnoles.com', 'https://46.16.90.63:2083', 'spagnoles', 'Spa2022les!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'andreass.it', 'https://86.107.36.161:2083', 'andreass23', 'Andr3ass--23!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'assistenzerispoli.it', 'https://46.16.90.63:2083', 'assirispoli', 'Assi2019rispoli!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'associazionelavita.it', 'https://46.16.90.63:2083', 'assolavita', 'Asso2019lavita!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'lasartoriaone.it', 'https://46.16.90.63:2083', 'lasartoriaone', 'La2019sartoria!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'socialservicesrl.it', 'https://46.16.90.63:2083', 'socservice', 'Soc2019service!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'blog.serviceinfoweb.com', 'https://86.107.36.161:2083', 'adminblog', 'EnzCav2019!'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'abitareindigitale.it', 'https://85.235.133.90:2083', 'wabitjaw', 'n8pHc52Y'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'prenotaingresso.it', 'https://85.235.133.90:2083', 'vfprenwm', 'npoVZuC*LK5Xp25g'],
            ['Service Infoweb di Enzo Cavallaro', 'cPanel', 'smsweb.it', 'https://85.235.133.90:2083', 'gtsmswzf', 'i8zV?1dKoTF5LBbr'],
            ['Smet S.r.l.', 'cPanel', 'crmlogint.com', 'https://185.81.4.134:2083', 'crmlogint', 'crm2019log!'],
            ['Smet S.r.l.', 'cPanel', 'smet-logistics.com', 'https://185.81.4.134:2083', 'smetlogistics', 'Smet2019!'],
            ['Smet S.r.l.', 'cPanel', 'smet-logistics.it', 'https://185.81.4.134:2083', 'smelog', 'Smet2019!'],
            ['Smet S.r.l.', 'cPanel', 'domenicoderosa.eu', '', 'domenicoderosa', 'ddr29vGt5!'],
            ['Trono Consulting S.r.l.', 'cPanel', 'scuolapertate.it', '', 'scuolapertate', 'scuola-pertat3!'],
            ['Trono Consulting S.r.l.', 'cPanel', 'sosgenitori.com', 'https://185.81.4.134:2083', 'genitorisos', 'SoSgen2022!'],
            ['Unique Experience di Nicola Asprella', 'cPanel', 'pergamon-travel.it', 'https://185.81.4.134:2083', 'pergamontrave', 'perg4m0ntrav3!'],
            ['Unique Experience di Nicola Asprella', 'cPanel', 'uniqueexperience.it', 'https://185.81.4.134:2083', 'uniquexp', 'UniExp2024!'],
            ['Vittorio Caponigro', 'cPanel', 'ivgamma.it', 'https://185.81.4.134:2083', 'ivgamma', '1vg4--mm4!'],
            // SKIP (no cliente): adamomediterranea.org / adamomediterrane
            // SKIP (no cliente): cilentontheroad.com / cilentontheroad
            // SKIP (no cliente): convitalia.org / convitalia
            // SKIP (no cliente): cremagreen.it / cremagreen
            // SKIP (no cliente): dairyespresso.com / dairyespresso
            // SKIP (no cliente): ecoprato.com / ecoprato
            // SKIP (no cliente): giordanodolci.it / giordanodolci
            // SKIP (no cliente): hotelpaestum.it / hotelpaes
            // SKIP (no cliente): hotelsottovento.com / hotelsottovento
            // SKIP (no cliente): hotelsottovento.it / htlsottovento
            // SKIP (no cliente): ildonodellinnovazione.it / ildonodellinnova
            // SKIP (no cliente): indigomedpartners.net / indigomp
            // SKIP (no cliente): kapaz.it / kapaz
            // SKIP (no cliente): latuacasanelverde.com / latuacasa
            // SKIP (no cliente): marchettisrl.com / marchettisrl
            // SKIP (no cliente): momoitalianfood.com / momoitalianfood
            // SKIP (no cliente): newcaretechnology.it / newcaretechnolog
            // SKIP (no cliente): oleificiofratellidigiorgio.it / oleificiofsg
            // SKIP (no cliente): promoretail.it / promoretail
            // SKIP (no cliente): puntosaluteonline.it / puntosaluteonlin
            // SKIP (no cliente): smj.it / smj
            // SKIP (no cliente): stilematica.it / stilemat
            // SKIP (no cliente): villaggiopaestum.it / villaggiopaes
            // SKIP (no cliente): mp3-air.com / fraorl
            // SKIP (no cliente): palestraincloud.it / palestraincloud
            // SKIP (no cliente): gestionale.smet.it / gestsmet
            // SKIP (no cliente): lacasadigiusy.it / sarrom
            // SKIP (no cliente): psicologacasali.it / fcasali
            // SKIP (no cliente): ener-supply.eu / enersupply
            // SKIP (no cliente): ilcellaiodidongennaro.it / iodidonge
            // SKIP (no cliente): magtunedengines.com / magtunedengines
            // SKIP (no cliente): milangelatoaward.com / milanga
            // SKIP (no cliente): smet.it / smet6536
            // SKIP (no cliente): foodandtech.company / fodtec
            // SKIP (no cliente): casanova.gelatogo.shop / casanovagelato
            // SKIP (no cliente): gelatogo.shop / gelatogo
            // SKIP (no cliente): sinecoda.com / sinecoda
            // SKIP (no cliente): pizzago.shop / pizzago
            // SKIP (no cliente): smetfoodlog.eu / smet7647
            // SKIP (no cliente): moou.sinecoda.com / msinecoda
            // SKIP (no cliente): professionegelatiere.it / pgelatiere
            // SKIP (no cliente): decamedicinaestetica.it / decamedicina
            // SKIP (no cliente): metalstyle.com / metalstyle2
            // SKIP (no cliente): zamattio.net / zamattio
        ];

        foreach ($creds as [$ragione, $tipo, $dominio, $url, $user, $pass]) {
            $cid = $clienteId($ragione);
            if (!$cid) continue;
            DB::table('account_credenziali')->insertOrIgnore([
                'cliente_id'   => $cid,
                'tipo'         => $tipo,
                'url'          => $url,
                'username'     => $user,
                'password_enc' => encrypt($pass),
                'note'         => $dominio,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}