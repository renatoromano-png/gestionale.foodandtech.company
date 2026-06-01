# Domande Aperte

| ID | Domanda | Owner | Stato |
|----|---------|-------|-------|
| Q-001 | La colonna `partita_iva` esiste già nella tabella `clienti` sul server? | Renato | APERTA |
| Q-002 | I ~47 TLD esotici con prezzi mancanti: quando vengono inseriti? | Renato | APERTA |
| Q-003 | 8 clienti senza anagrafica nel backup: compilare manualmente o c'è un altro export? | Renato | APERTA |

---

## Q-001 — La colonna `partita_iva` esiste già nella tabella `clienti` sul server?
**Data:** 2026-05-15
**Owner:** Renato
**Stato:** APERTA
**Contesto:** Durante l'aggiunta dei campi PEC e SDI, l'utente ha detto "la partita iva c'è già". Non è presente nella migration originale. Potrebbe essere stata aggiunta manualmente sul server o essere un refuso.
**Da fare:** Sul server SSH: `DESCRIBE clienti;` oppure `SHOW COLUMNS FROM clienti LIKE 'partita_iva';`. Se manca → creare migration separata.
**Risposta:** —

---

## Q-002 — I ~47 TLD esotici con prezzi mancanti: quando vengono inseriti?
**Data:** 2026-05-08
**Owner:** Renato
**Stato:** APERTA
**Contesto:** I prezzi standard dei domini sono stati aggiornati (135 domini: .it=€25, .com=€30). Restano ~47 domini con TLD non standard (es. .eu, .net, .org, ecc.) con prezzi da inserire manualmente via interfaccia domini.
**Risposta:** —

---

## Q-003 — 8 clienti senza anagrafica nel backup: compilare manualmente?
**Data:** 2026-05-15
**Owner:** Renato
**Stato:** APERTA
**Contesto:** Il parser del `manager.bak` non ha trovato dati sufficienti per: Consac IES, Euro Cover Pack, Officine Zephiro, Osculati, Prolab Studio, Renato Romano, Sainvest, Service Infoweb di Enzo Cavallaro.
**Da fare:** Inserire manualmente dall'interfaccia, oppure verificare se esistono altri export (Excel, rubrica, vecchio CRM).
**Risposta:** —
