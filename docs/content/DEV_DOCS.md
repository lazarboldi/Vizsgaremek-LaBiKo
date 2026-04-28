# CarLink – Fejlesztői dokumentáció

## 1. Projekt áttekintés

A projektünk lényege egy weboldal, ahol a felhasználók autóikat eladásra hirdethetik meg, illetve a már meghirdetett autók között böngészhetnek és érdeklődhetnek azok iránt.

### Főbb funkciók

- regisztráció, bejelentkezés
- hirdetés létrehozás és böngészés
- saját hirdetések kezelése (profil oldalon)
- admin, hirdetések jóváhagyás/törlés
- kedvencek/gyűjtemény funkció (hirdetések mentése)

### Használt technológiák

- Backend: Laravel + Sanctum
- Frontend: Vue 3 + Pinia + Vue Router (file-based)
- Adatbázis: MySQL (Docker környezetben)

## 2. Projekt struktúra

### Főbb mappák

- `backend/`
  - `app/Http/Controllers`
  - `app/Models`
  - `routes/api.php`
  - `database/migrations`
  - `database/seeders`
- `frontend/`
  - `src/pages`
  - `src/components`
  - `src/stores`
  - `src/layouts`
  - `src/utils`

## 3. Futtatás fejlesztői környezetben

### 1, Projekt indítása (Docker + start script)

```bash
chmod +x ./start.sh
./start.sh
```

### 2, Backend migráció + seed

```bash
docker compose exec backend fish
php artisan migrate:fresh --seed
```

### 3, Frontend elérés

- `http://frontend.vm1.test`

### 4, További szolgáltatások

- Swagger: `http://swagger.vm1.test`
- phpMyAdmin: `http://pma.vm1.test`

## 4. Hitelsítés és szerepkörök

### Autentikáció

- Laravel Sanctum token alapú azonosítás
- frontend oldalon a token a Pinia AuthStore-ban van kezelve

### Szerepkörök

- `user`: saját funkciók + hirdetéskezelés
- `admin`: admin listing felület, jóváhagyás és törlés

### Backend oldali auth védelem

- auth:sanctum middleware
- admin route-ok külön admin middleware-rel

## 5. Backend API – lényeges végpontok

### Auth

- `POST /api/login`
- `POST /api/registration`

### Felhasználó

- `GET /api/users/me` (auth szükséges)

### Hirdetések

- REST: `/api/listings`
- Admin listing:
  - `GET /api/admin/listings`
  - `DELETE /api/admin/listings/{listing}`
  - `PATCH /api/admin/listings/{listing}/approve` (ha implementálva van)

### Gyűjtemény / Kedvencek

- `GET /api/favourites`
- `POST /api/favourites/{listing}`
- `DELETE /api/favourites/{listing}`

## 6. Adatmodell – fontos kapcsolatok

### User

- `hasMany(Listings)`
- `belongsToMany(Listings)` favourites pivoton keresztül

### Listings

- `belongsTo(User)`
- `belongsTo(Car)`
- `belongsToMany(User)` favouritedBy pivoton keresztül

### Favourites tábla

- `user_id`
- `listing_id`
- `timestamps`

## 7. Frontend felépítés

### Oldalak
s
- Főoldal: `frontend/src/pages/index.vue`
- Bejelentkezés: `frontend/src/pages/auth/login.vue`
- Regisztráció: `frontend/src/pages/auth/register.vue`
- Saját profil: `frontend/src/pages/myprofile/my-profile.vue`
- Hirdetés létrehozás: `frontend/src/pages/Listing/NewListing.vue`
- Gyűjtemény: `frontend/src/pages/Collection/collection.vue`
- Admin listing oldal: `frontend/src/pages/admin/listings.vue`

### Store-ok

- `AuthStore.mjs`: auth állapot, token, szerepkör
- `NewListingStore.mjs`: listing betöltés/létrehozás/törlés
- `FavouritesStore.mjs`: kedvencek betöltése, add/remove/toggle
- `ListingStore.mjs` : API-ról autók betöltése, és kezeli a loading/hiba állapotot.

### Layout

- `BaseLayout.vue`: BaseHeader + tartalom+ BaseFooter
- `BaseCard-vue`: Egy konkrét hirdetés megjelenítése a főoldalon
- `BaseHeader.vue`: role/auth alapján menüpontok
