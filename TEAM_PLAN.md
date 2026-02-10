# TEAM_PLAN.md - Warhammer40k.webshop

## 1. Gekozen Domein
**Naam:** Warhammer40k.webshop
**Omschrijving:** Een beheersysteem voor een webshop gespecialiseerd in Warhammer 40k miniaturen en legers. Het systeem dient als centraal punt voor voorraadbeheer en productinformatie.

## 2. Entiteiten (minimaal 3)
Dit project bevat drie entiteiten, elk met een eigen model en repository:
1. **Product**: De individuele miniaturen of boxsets (bijv. Intercessors, Tactical Squads).
2. **Faction**: De categorieën waartoe de producten behoren (bijv. Imperium, Chaos, Xenos).
3. **User**: De beheerders die toegang hebben tot het CMS-gedeelte van de webshop.

## 3. Globale Databankstructuur
Het project maakt gebruik van een relationele databank met de volgende tabelstructuur:
- **products**: `id` (PK), `name`, `description`, `price`, `faction_id` (FK), `stock_quantity`.
- **factions**: `id` (PK), `name`, `description`.
- **users**: `id` (PK), `email` (unique), `password_hash`.

## 4. Taakverdeling
De verantwoordelijkheden zijn verdeeld om een goede samenwerking te garanderen:
- **Nathan**: Projectopzet
- **Kirano**: Database

## 5. Afspraken rond Samenwerking

### Git Branching Strategy
Om de code overzichtelijk te houden en conflicten te vermijden, hanteren we de volgende prefixen:
- **Nieuwe functionaliteiten:** `feature/omschrijving`
- **Foutoplossingen:** `bugfix/omschrijving`

### Code Afspraken
- **Strict Typing:** Elk PHP-bestand start verplicht met `declare(strict_types=1);`.
- **Namespaces:** Gebruik van namespaces is verplicht voor alle klassen en volgt de mappenstructuur.
- **MVC-Scheiding:** Repositories bevatten enkel databasecode, controllers regelen de flow, en modellen bevatten de data-structuur.

### Specifieke Projectafspraken
- **Validatie:** Alle gebruikersinvoer wordt server-side gevalideerd in de Controller of een helper-klasse. We controleren minimaal op lege velden, correcte data-types en logische waarden.
- **Foutafhandeling:** Fouten worden opgevangen en via duidelijke foutmeldingen in de View aan de gebruiker getoond (geen ruwe PHP-errors in de browser).
- **Views (geen logica):** Views worden uitsluitend gebruikt voor presentatie (HTML). Er wordt geen logica of database-queries uitgevoerd in de view; we gebruiken enkel eenvoudige PHP-loops of echo's om data te tonen.
- **Security:** - Output escaping via `htmlspecialchars()` is verplicht voor alle dynamische data.
    - CSRF-beveiliging wordt toegepast op elk formulier middels een uniek token.