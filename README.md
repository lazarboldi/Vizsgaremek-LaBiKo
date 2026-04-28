# 2026_LáBiKo – Carlink projekt

## Projektleírás
A projektünk lényege egy weboldal, ahol a felhasználók autóikat eladásra hirdethetik meg, illetve a már meghirdetett autók között böngészhetnek és érdeklődhetnek azok iránt.

---

## Felhasználói jogosultságok

### User (Felhasználó)
A sima felhasználó az alábbi műveletekre képes:

- fiók létrehozása
- új hirdetés létrehozása
- hirdetések megtekintése
- hirdetések mentése saját gyűjteményébe, hogy később is könnyen elérhesse őket

---

###  Admin (Adminisztrátor)
Az adminisztrátor külön admin felülettel rendelkezik, ahol:

- az új hirdetéseket jóváhagyhatja
- az új hirdetéseket elutasíthatja
- meglévő hirdetéseket törölhet

---

## Seedelt felhasználók

### User
| Adat | Érték |
|------|------|
| **Email** | `test@example.com` |
| **Jelszó** | `Password1234` |
| **Telefonszám** | `+36201234567` |

### Admin
| Adat | Érték |
|------|------|
| **Email** | `admin@example.com` |
| **Jelszó** | `Admin1234` |
| **Telefonszám** | `+36209999999` |

---

## Projekt indítása

### 1. Repository klónozása
```bash
git clone https://github.com/lazarboldi/Vizsgaremek-LaBiKo
```

### 2. Belépés a projekt mappájába
```bash
cd Vizsgaremek-LaBiKo
```

### 3. Indító script futtatása
Adjunk futtatási jogosultságot a `start.sh` fájlnak, majd futtassuk:

```bash
chmod +x ./start.sh
./start.sh
```

### 4. Adatbázis seedelése
Miután a projekt elindult, lépjünk be a konténerbe, majd futtassuk a migrációt seedeléssel:

```bash
docker compose exec backend fish
php artisan migrate:fresh --seed
```

---

## Elérhető URL-ek

| Szolgáltatás | URL |
|------------|-----|
| Frontend | http://frontend.vm1.test |
| Swagger | http://swagger.vm1.test |
| phpMyAdmin | http://pma.vm1.test |

---

## Tesztek futtatása

### Backend tesztek futtatása

A backend tesztek futtatásához lépjünk be a backend konténerbe:

```bash
docker compose exec backend fish
```

Majd futtassuk le a Laravel teszteket:

```bash
php artisan test
```

### Frontend tesztek futtatása

A frontend tesztek futtatásához futtassuk az alábbi parancsot:

```bash
docker compose exec frontend sh -lc "pnpm test"
```
## Linkek

### Tesztelési jegyzőkönyv
https://docs.google.com/spreadsheets/d/1FOAz9LTY7X4WHUbLdIdKzimzrGW03zhCieTO6TcZ07E/edit?usp=sharing

### Tesztelési terv
https://docs.google.com/document/d/1lXrbo-nW3_2pAdBRUff8YFEo-fhFMikonittsUJddZg/edit?usp=sharing

### Adatbázis terv
https://docs.google.com/document/d/1ZbzqrCYLM9h3Gz7TnjIqLDFdFM7ly-3NH5y2PcuWR0o/edit?usp=sharing

### Figma
https://www.figma.com/files/project/474960549

### Trello
https://trello.com/invite/b/691edf85f62832381fd99d5c/ATTI66a259458908e8e021963144ad998f1037900932/labiko-carlink

### GitHub Repository
https://github.com/lazarboldi/Vizsgaremek-LaBiKo