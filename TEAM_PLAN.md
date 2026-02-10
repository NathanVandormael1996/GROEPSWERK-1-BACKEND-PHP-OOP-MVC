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
### Users & Auth
- **users**: `id` (PK), `email`, `password_hash`, `created_at`
- **roles**: `id` (PK), `name`, `description`
- **user_roles**: `user_id` (FK), `role_id` (FK)

### Products
- **factions**: `id` (PK), `name`, `description`
- **products**: `id` (PK), `faction_id` (FK), `name`, `description`, `price`, `image_url`, `stock_quantity`, `created_at`, `updated_at`, `deleted_at`

### Sales & Orders
- **orders**: `id` (PK), `user_id` (FK), `total_price`, `created_at`
- **order_products**: `id` (PK), `order_id` (FK), `product_id` (FK), `quantity`, `price_at_purchase`

## 4. Taakverdeling
De verantwoordelijkheden zijn verdeeld om een goede samenwerking te garanderen:
- **Nathan**: Projectopzet
- **Kirano**: Database, db-connection, maken van de RolesController, -Model, en -Repository.

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