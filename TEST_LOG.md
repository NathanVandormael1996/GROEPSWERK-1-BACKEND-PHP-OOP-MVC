# TEST_LOG.md

**Project:** Warhammer 40k Webshop  
**Versie:** 1.0  
**Datum:** 2026-02-11  
**Tester:** Development Team

---

## Overzicht Testcases

| ID  | Module         | Test Scenario                                   | Type     | Status |
| :-- | :------------- | :---------------------------------------------- | :------- | :----- |
| 001 | Authentication | Succesvol inloggen met geldige gegevens         | Positief | ✅ Pass |
| 002 | Authentication | Inloggen met foutief wachtwoord                 | Negatief | ✅ Pass |
| 003 | Shop (Frontend)| Productoverzicht correct weergegeven            | Positief | ✅ Pass |
| 004 | Cart           | Product toevoegen aan winkelwagen               | Positief | ✅ Pass |
| 005 | Cart           | Product verwijderen uit winkelwagen             | Positief | ✅ Pass |
| 006 | Order          | Succesvolle bestelling plaatsen (Stock update)  | Positief | ✅ Pass |
| 007 | Order          | Bestellen met onvoldoende voorraad              | Negatief | ✅ Pass |
| 008 | Admin          | Toegang tot Orderoverzicht (Rolcheck)           | Positief | ✅ Pass |

---

## Detailrapportage

### Testcase 001: Succesvol inloggen
* **Omschrijving:** Verifieer dat een gebruiker kan inloggen met correcte gegevens.
* **Stappen:**
    1. Ga naar `/login`.
    2. Voer e-mail in: `inquisitor@imperium.com`.
    3. Voer wachtwoord in: `password123`.
    4. Klik op "Verify Credentials".
* **Verwachte uitkomst:** Gebruiker wordt doorgestuurd naar de Homepage (`/`) en de sessie start.
* **Effectieve uitkomst:** Gebruiker succesvol ingelogd en doorgestuurd.

### Testcase 002: Foutief wachtwoord (Beveiliging)
* **Omschrijving:** Verifieer dat toegang wordt geweigerd bij onjuiste gegevens.
* **Stappen:**
    1. Ga naar `/login`.
    2. Voer geldig e-mail in.
    3. Voer **foutief** wachtwoord in.
    4. Klik op "Verify Credentials".
* **Verwachte uitkomst:** Systeem blijft op `/login` en toont foutmelding "Access Denied".
* **Effectieve uitkomst:** Foutmelding zichtbaar, geen toegang verleend.

### Testcase 003: Shop Weergave
* **Omschrijving:** Controleer of producten uit de database correct laden.
* **Stappen:**
    1. Log in als klant.
    2. Navigeer naar `/`.
    3. Bekijk het grid met producten.
* **Verwachte uitkomst:** Productkaarten tonen juiste Naam, Prijs en Afbeelding (of 📦 placeholder).
* **Effectieve uitkomst:** Grid laadt correct met database data.

### Testcase 004: Toevoegen aan Cart
* **Omschrijving:** Verifieer dat de sessie wordt bijgewerkt bij toevoegen item.
* **Stappen:**
    1. Klik op "+ Cart" bij een product.
    2. Navigeer naar `/cart`.
* **Verwachte uitkomst:** Het product staat in de tabel met aantal = 1 en correcte totaalprijs.
* **Effectieve uitkomst:** Item succesvol toegevoegd aan sessie array.

### Testcase 005: Verwijderen uit Cart
* **Omschrijving:** Verifieer dat een item uit de sessie verwijderd kan worden.
* **Stappen:**
    1. Vanuit `/cart`, klik op het kruisje (X) naast een item.
* **Verwachte uitkomst:** Pagina herlaadt, item is weg, totaalprijs is bijgewerkt.
* **Effectieve uitkomst:** Item correct verwijderd.

### Testcase 006: Order Plaatsen & Voorraad Update
* **Omschrijving:** Verifieer dat een aankoop de databasevoorraad vermindert.
* **Stappen:**
    1. Plaats een item in de cart (Huidige stock: X).
    2. Klik op "Confirm Requisition".
    3. Controleer database tabel `products`.
* **Verwachte uitkomst:** Gebruiker ziet succesmelding, order is aangemaakt, nieuwe stock is X-1.
* **Effectieve uitkomst:** Database transactie geslaagd, voorraad is verminderd.

### Testcase 007: Overselling Preventie
* **Omschrijving:** Probeer meer te kopen dan er op voorraad is.
* **Stappen:**
    1. Selecteer een product met voorraad = 2.
    2. Probeer 3 stuks in de winkelwagen te doen (of manipuleer sessie).
    3. Klik op "Confirm Requisition".
* **Verwachte uitkomst:** Order faalt, gebruiker keert terug naar `/cart` met foutmelding "Insufficient stock".
* **Effectieve uitkomst:** Blokkade werkt, rode foutmelding zichtbaar.

### Testcase 008: Admin Rechten
* **Omschrijving:** Verifieer dat alleen staff bij de orders kan.
* **Stappen:**
    1. Log in als Manager (Rol 3).
    2. Navigeer naar `/orders`.
* **Verwachte uitkomst:** Pagina laadt het overzicht van alle bestellingen.
* **Effectieve uitkomst:** Toegang verleend (Bij rol < 3 wordt toegang geweigerd).