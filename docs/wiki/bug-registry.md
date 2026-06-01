# Bug Registry

| ID | Titolo | Modulo | Stato | Scoperto |
|----|--------|--------|-------|----------|
| BUG-001 | Cancellazione scadenza → SQLSTATE 1265 (ENUM mancante) | Scadenze | CHIUSO | 2026-05-08 |
| BUG-002 | Anagrafiche clienti vuote dopo import CSV | Clienti | CHIUSO | 2026-05-15 |
| BUG-003 | /scadenze 500 → "read property cliente on null" (join ignora soft-delete) | Scadenze | CHIUSO | 2026-06-01 |

---

## BUG-003 — /scadenze 500 → "Attempt to read property cliente on null"
**Stato:** CHIUSO
**Modulo:** Scadenze
**Scoperto:** 2026-06-01 (produzione, GET /scadenze)
**Causa:** Il `join` raw su `articoli`/`clienti` in `ScadenzeController@index` non applica lo scope soft-delete, mentre l'eager-load `with('articolo.cliente')` filtra `deleted_at is null`. Una scadenza con articolo (o cliente) soft-deleted passava il join ma aveva `$s->articolo = null`; la view `index.blade.php:76` faceva `$s->articolo->cliente` → crash.
**Fix:** Aggiunto `->whereNull('articoli.deleted_at')->whereNull('clienti.deleted_at')` alla query del controller (esclude le scadenze orfane e rende coerente anche il count del paginator). Guardia difensiva nella view: `@continue(! $s->articolo || ! $s->articolo->cliente)`.
**Commit:** —

---

## BUG-001 — Cancellazione scadenza → SQLSTATE 1265 (ENUM mancante)
**Stato:** CHIUSO
**Modulo:** Scadenze / Database
**Scoperto:** 2026-05-08 (manuale, produzione)
**Causa:** La colonna `stato` nella tabella `scadenze` era definita come `ENUM('attiva','rinnovata','disdetta')` ma il controller usava il valore `cancellata` non presente nell'ENUM.
**Fix:** ALTER TABLE via MySQL per aggiungere `cancellata` all'ENUM: `ALTER TABLE scadenze MODIFY COLUMN stato ENUM('attiva','rinnovata','cancellata','disdetta') NOT NULL DEFAULT 'attiva';`. Migration locale: `2024_01_03_000001_fix_stato_scadenze_enum.php`.
**Commit:** —

---

## BUG-002 — Anagrafiche clienti vuote dopo import CSV
**Stato:** CHIUSO
**Modulo:** Clienti / Import
**Scoperto:** 2026-05-15 (manuale, produzione)
**Causa:** Il file `clienti_unici.csv` conteneva solo la colonna `ragione_sociale`. Gli altri campi anagrafici (indirizzo, città, email, ecc.) erano nel vecchio database SQL Server (`manager.bak`) e non erano mai stati importati nel nuovo gestionale Laravel.
**Fix:** Estrazione dati da `manager.bak` tramite parser Python (`strings` + regex). Generato `import_anagrafiche.sql` con 28 UPDATE su 36 clienti. 8 clienti con dati assenti nel backup → da compilare manualmente nell'interfaccia.
**Commit:** —
