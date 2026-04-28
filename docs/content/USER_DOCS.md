# CarLink – Felhasználói dokumentáció

## 1. Bevezetés

A CarLink egy webalapú alkalmazás, amely lehetőséget biztosít gépjárműhirdetések létrehozására, böngészésére és kezelésére. A rendszer célja, hogy egyszerű és átlátható felületet biztosítson a felhasználók számára az autóhirdetések kezeléséhez.

A felhasználók az alábbi funkciókat érhetik el:

- felhasználói fiók regisztrációja,
- bejelentkezés a rendszerbe,
- új hirdetések létrehozása,
- hirdetések böngészése és szűrése,
- hirdetések mentése a gyűjteménybe.

## 2. A rendszer elérhetősége

- Frontend: `http://frontend.vm1.test`

## 3. Regisztráció

### 3.1. Regisztrációs oldal elérése

1. Nyissa meg a főoldalt: `http://frontend.vm1.test`
2. Válassza a Bejelentkezés menüpontot.
3. Kattintson a Regisztráljon itt hivatkozásra.

Közvetlen elérés:

- `http://frontend.vm1.test/auth/register`

### 3.2. Szükséges adatok

A regisztráció során az alábbi adatok megadása szükséges:

- név,
- e-mail-cím,
- telefonszám,
- jelszó,
- jelszó megerősítése.

### 3.3. Adatmegadási követelmények

- Az e-mail-címnek valós formátumúnak kell lennie.
- A telefonszámot nemzetközi formátumban kell megadni (pl. `+36301234567`).
- A jelszó minimális hossza 8 karakter.
- A jelszó és a megerősítése mező tartalmának egyeznie kell.

### 3.4. Regisztráció véglegesítése

A Regisztráció gombra kattintva a rendszer feldolgozza az adatokat. Sikeres művelet esetén visszajelzés jelenik meg.

### 3.5. Hibaüzenetek

Hibás vagy hiányos adatok esetén a rendszer hibaüzenetet jelenít meg, például:

- „Az e-mail-cím formátuma érvénytelen.”
- „A jelszavak nem egyeznek.”
- „Ez az e-mail-cím már használatban van.”

## 4. Bejelentkezés

### 4.1. Bejelentkezési oldal

A bejelentkezési oldal elérhető a főoldalról vagy közvetlenül:

- `http://frontend.vm1.test/auth/login`

### 4.2. Bejelentkezés folyamata

1. Adja meg e-mail-címét.
2. Adja meg jelszavát.
3. Kattintson a Bejelentkezés gombra.

### 4.3. Sikeres bejelentkezés

Sikeres bejelentkezés után a felhasználó neve megjelenik a navigációs sávban, valamint elérhetővé válnak a további funkciók (pl. új hirdetés létrehozása, gyűjtemény).

### 4.4. Tesztfelhasználó

A rendszer tartalmazhat előre létrehozott tesztfiókot:

- e-mail: `test@example.com`
- jelszó: `Password1234`

## 5. Hirdetés létrehozása

### 5.1. Elérés

A funkció csak bejelentkezett felhasználók számára érhető el.

Közvetlen elérés:

- `http://frontend.vm1.test/listing/new`

### 5.2. Megadandó adatok

A hirdetés létrehozásakor az alábbi mezők kitöltése szükséges:

- hirdetés címe,
- márka,
- modell,
- évjárat,
- teljesítmény (lóerő),
- ár,
- üzemanyag típusa,
- kivitel,
- kilométeróra-állás,
- váltó típusa,
- szín,
- motorméret,
- leírás,
- képek (opcionális).

### 5.3. Validációs szabályok

- A kötelező mezők kitöltése szükséges.
- Numerikus mezők esetén negatív érték nem adható meg.
- Az évjárat nem lehet a megengedett maximális értéknél nagyobb.

### 5.4. Hirdetés mentése

A Hirdetés létrehozása gombra kattintva a rendszer menti az adatokat. Sikeres mentés esetén visszajelzés jelenik meg, és a hirdetés adminisztrátori jóváhagyást követően válik publikussá.

## 6. Hirdetések böngészése és szűrése

### 6.1. Főoldal

A főoldalon a rendszer az elérhető hirdetéseket listázza.

### 6.2. Szűrési lehetőségek

A bal oldali panelen az alábbi szűrők érhetők el:

- márka,
- modell,
- kivitel,
- üzemanyag,
- maximális évjárat,
- maximális ár.

### 6.3. Szűrés működése

A szűrők kiválasztását követően a találati lista automatikusan frissül.
Több szűrő egyidejű alkalmazásával a találatok pontosíthatók.

### 6.4. Szűrők visszaállítása

A Szűrők törlése gombbal a rendszer alapállapotba állítható.

## 7. Hirdetés részletei

Egy hirdetés részleteinek megtekintéséhez kattintson egy autókártyára.

A részletes nézet tartalmazza:

- az autó alapadatait,
- az árat,
- a műszaki jellemzőket,
- a leírást,
- az eladó adatait,
- a feltöltött képeket.

## 8. Gyűjtemény kezelése

### 8.1. Hozzáadás

A hirdetések a Felvétel a gyűjteménybe gombbal menthetők.

### 8.2. Eltávolítás

A mentett elemek az Eltávolítás a gyűjteményből gombbal törölhetők.

### 8.3. Megjegyzés

A funkció használatához bejelentkezés szükséges.

## 9. Kijelentkezés

A kijelentkezés a navigációs sávban található Kijelentkezés gombbal érhető el.
Mobil nézetben a funkció a menüben található.

## 10. Hibaelhárítás

### 10.1. Sikertelen bejelentkezés

- Ellenőrizze az e-mail-címet és a jelszót.
- Ügyeljen az esetleges szóközökre.

### 10.2. Sikertelen regisztráció

- Ellenőrizze a megadott adatokat.
- Kövesse a hibaüzenetekben megadott útmutatást.

### 10.3. Nem megfelelő szűrési eredmény

- Állítsa vissza a szűrőket.
- Adja meg újra a kívánt feltételeket.

## 11. Összefoglalás

A CarLink rendszer egy egyszerűen használható felületet biztosít autóhirdetések kezelésére. A dokumentáció célja, hogy a felhasználók számára egyértelmű útmutatást nyújtson az alapvető funkciók használatához.