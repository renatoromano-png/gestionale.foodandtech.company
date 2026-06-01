<?php

namespace App\Http\Controllers;

use App\Models\Articolo;
use App\Models\Cliente;
use App\Models\Dominio;
use App\Models\RataPagamento;
use App\Models\Scadenza;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $oggi = now()->toDateString();
        $tra30 = now()->addDays(30)->toDateString();
        $tra60 = now()->addDays(60)->toDateString();

        $clientiAttivi = Cliente::where('attivo', true)->count();

        $scadenzeDelMese = Scadenza::where('stato', 'attiva')
            ->whereMonth('data_scadenza', now()->month)
            ->whereYear('data_scadenza', now()->year)
            ->count();

        $scadenzeEntro30 = Scadenza::where('stato', 'attiva')
            ->whereBetween('data_scadenza', [$oggi, $tra30])
            ->count();

        $scadute = Scadenza::where('stato', 'attiva')
            ->where('data_scadenza', '<', $oggi)
            ->count();

        $prossimeScadenze = Scadenza::with(['articolo.cliente', 'articolo.tipologia'])
            ->where('stato', 'attiva')
            ->where('data_scadenza', '<=', $tra30)
            ->orderBy('data_scadenza')
            ->limit(20)
            ->get();

        // Totale fisso mensili (stessa cifra ogni mese)
        $totaleMensili = Articolo::whereHas('tipologia', fn($q) => $q->where('periodicita', 'mensile'))
            ->where('attivo', true)->whereNull('deleted_at')->sum('prezzo');

        // Forecast: prossimi 6 mesi basato su fatturazione reale
        $forecastMesi = [];
        for ($i = 0; $i < 6; $i++) {
            $mese   = now()->addMonths($i);
            $inizio = $mese->copy()->startOfMonth();
            $fine   = $mese->copy()->endOfMonth();

            // Scadenze non-mensili nel mese
            $totaleScadenze = Scadenza::with('articolo')
                ->whereBetween('data_scadenza', [$inizio, $fine])
                ->where('stato', 'attiva')
                ->whereHas('articolo.tipologia', fn($q) => $q->where('periodicita', '!=', 'mensile'))
                ->get()->sum(fn($s) => $s->articolo->prezzo ?? 0);

            // Domini in scadenza nel mese
            $totaleDomini = Dominio::whereBetween('data_scadenza', [$inizio, $fine])
                ->whereNull('deleted_at')->sum('prezzo');

            // Rate di progetto con data_prevista nel mese (non ancora incassate)
            $totaleRate = RataPagamento::whereBetween('data_prevista', [$inizio, $fine])
                ->whereIn('stato', ['attesa', 'in_ritardo'])
                ->whereHas('progetto', fn($q) => $q->whereNull('deleted_at')
                    ->whereNotIn('stato', ['annullato']))
                ->sum('importo');

            $forecastMesi[] = [
                'label'   => $mese->locale('it')->isoFormat('MMM YY'),
                'importo' => round($totaleMensili + $totaleScadenze + $totaleDomini + $totaleRate, 2),
            ];
        }

        return view('dashboard.index', compact(
            'clientiAttivi', 'scadenzeDelMese', 'scadenzeEntro30',
            'scadute', 'prossimeScadenze', 'forecastMesi'
        ));
    }
}
