# Decisioni Architetturali (ADR)

| ID | Titolo | Stato | Data |
|----|--------|-------|------|
| ADR-001 | Stack: Laravel 12 + PHP 8.2 su Serverplan shared hosting | ACCETTATO | 2026-05-01 |
| ADR-002 | SSH su porta 10223, IP diretto (non hostname) | ACCETTATO | 2026-05-08 |
| ADR-003 | Fatturazione: rate progetto incluse per data_prevista | ACCETTATO | 2026-05-15 |
| ADR-004 | Campi fiscali clienti: solo PEC e SDI (P.IVA già presente nel vecchio DB) | ACCETTATO | 2026-05-15 |
| ADR-005 | Modulo Progetti: rate libere + step lista semplice (no kanban) | ACCETTATO | 2026-05-15 |
| ADR-006 | Versionamento: repo Git su GitHub, root in laravel_setup | ACCETTATO | 2026-06-01 |

---

## ADR-001 — Stack: Laravel 12 + PHP 8.2 su Serverplan shared hosting
**Data:** 2026-05-01
**Stato:** ACCETTATO
**Contesto:** Necessità di un gestionale web per Food & Tech che sostituisse il vecchio software Windows (database SQL Server, `manager.bak`).
**Decisione:** Laravel 12, PHP 8.2, MySQL su hosting condiviso Serverplan. Cartella server: `~/gestionale_app`. URL: `https://gestione.foodandtech.company`.
**Razionale:** Hosting già disponibile, costo zero aggiuntivo, PHP 8.2 supportato. Laravel per velocità di sviluppo e ORM.
**Conseguenze:** Deploy manuale via SCP + SSH. Nessun CI/CD. Comando PHP: `sp-php` (wrapper Serverplan). Cache route/view da pulire ad ogni deploy.

---

## ADR-002 — SSH su porta 10223, IP diretto (non hostname)
**Data:** 2026-05-08
**Stato:** ACCETTATO
**Contesto:** La porta SSH 22 è chiusa su Serverplan. Il dominio `gestione.foodandtech.company` non risolve per SSH.
**Decisione:** Tutti i comandi SCP/SSH usano `-P 10223` e IP `86.107.36.161`. Credenziali: utente `fodtec`.
**Razionale:** Vincolo dell'hosting condiviso Serverplan.
**Conseguenze:** Tutti i deploy devono usare esplicitamente `-P $port` in PowerShell. Template comandi nel DEPLOY.sh.

---

## ADR-003 — Fatturazione: rate progetto incluse per data_prevista
**Data:** 2026-05-15
**Stato:** ACCETTATO
**Contesto:** Il modulo Fatturazione mostrava solo scadenze servizi e domini. Con l'introduzione del modulo Progetti, le rate di pagamento devono confluire nel forecast e nel prospetto mensile.
**Decisione:** Le `rate_pagamento` con `data_prevista` nel mese selezionato e `stato IN ('attesa','in_ritardo')` vengono incluse nelle voci fatturazione (badge arancione "progetto") e nel forecast dashboard. Rate di progetti `annullati` o soft-deleted escluse.
**Razionale:** Il fatturato reale include i pagamenti attesi dai progetti. Escludere le rate già incassate evita doppi conteggi.
**Conseguenze:** `FatturazioneController` e `DashboardController` importano `RataPagamento`. Forecast ora è somma di: mensili fissi + scadenze + domini + rate progetto.

---

## ADR-004 — Campi fiscali clienti: solo PEC e SDI (P.IVA esclusa dalla migration)
**Data:** 2026-05-15
**Stato:** ACCETTATO
**Contesto:** La scheda cliente mancava di campi per fatturazione elettronica. P.IVA era richiesta ma l'utente ha confermato che "c'è già" (presente nel vecchio DB, da verificare se importata).
**Decisione:** Migration `2024_01_05_000001_add_pec_sdi_to_clienti.php` aggiunge solo `pec` (varchar 120) e `codice_sdi` (varchar 7), entrambi nullable. P.IVA non toccata per ora.
**Razionale:** Evitare di sovrascrivere un campo che potrebbe già esistere sul server dal vecchio import.
**Conseguenze:** Da verificare se `partita_iva` esiste già nella tabella `clienti` sul server. Se manca, creare migration separata.

---

## ADR-005 — Modulo Progetti: rate libere + step lista semplice
**Data:** 2026-05-15
**Stato:** ACCETTATO
**Contesto:** Necessità di tracciare progetti con offerta/accettazione, pagamenti a rate e fasi di lavoro.
**Decisione:** Rate aggiunte manualmente (no schema fisso acconto/SAL/saldo). Step con lista semplice (stato da_fare/in_corso/completato), no kanban drag&drop. Importo progetto sdoppiato: `importo_proposta` + `valore_totale` (= accettato). % e importo rata si calcolano a vicenda via JS lato client.
**Razionale:** Per pochi progetti con step limitati la lista semplice è più veloce del kanban. Rate libere coprono qualsiasi struttura di pagamento.
**Conseguenze:** Tabelle `progetti`, `rate_pagamento`, `step_progetto`. Migration `2024_01_04_000001_add_importo_proposta_to_progetti.php` per il campo proposta.

---

## ADR-006 — Versionamento: repo Git su GitHub, root in laravel_setup
**Data:** 2026-06-01
**Stato:** ACCETTATO
**Contesto:** Il progetto era senza controllo di versione: ogni deploy era una copia manuale di file via SCP, senza storico né possibilità di rollback. Emerso dopo il fix di BUG-003.
**Decisione:** Inizializzato repo Git con root in `laravel_setup` (cartella che contiene il codice modificato + `docs/wiki/`). Remote: `https://github.com/renatoromano-png/gestionale.foodandtech.company`, branch `main`. `.gitignore` esclude vendor, .env, cache, *.bak. La root NON è la cartella `gestionale` superiore, così credenziali SSH, `Manager.bak` e CSV restano fuori dal repo.
**Razionale:** Storico, rollback e backup off-site senza costi. laravel_setup come root tiene fuori i segreti per costruzione.
**Conseguenze:** Il deploy resta manuale (SCP+SSH, vedi ADR-001) — Git è per versionamento, non ancora CI/CD. Flusso commit gestito via terminale Windows (mai dal sandbox Cowork per evitare index.lock). Da valutare in futuro un deploy via `git pull` lato server.
