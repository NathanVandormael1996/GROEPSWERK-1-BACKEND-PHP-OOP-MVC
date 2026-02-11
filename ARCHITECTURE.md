# ARCHITECTURE.md

**Project:** Warhammer 40k Webshop  
**Architectuur:** Custom MVC (Model-View-Controller)  
**Taal:** PHP 8.3+ (Strict Types)

---

## 1. Uitleg van de MVC-opzet

Dit project is gebouwd volgens het **Model-View-Controller (MVC)** ontwerppatroon. Het doel hiervan is *Separation of Concerns* (scheiding van verantwoordelijkheden). Hierdoor is de code makkelijker te onderhouden, te testen en uit te breiden.

### De Request Flow:
1.  **Entry Point:** Elke aanvraag komt binnen via `public/index.php`.
2.  **Router:** De `Router` analyseert de URL en bepaalt welke **Controller** en welke functie moet worden aangeroepen.
3.  **Controller:** De controller (bijv. `OrdersController`) ontvangt de aanvraag. Hij haalt data op via een **Repository**.
4.  **Model:** De data wordt vanuit de database omgezet naar een **Model** object (bijv. `OrdersModel`), zodat we met objecten werken in plaats van ruwe arrays.
5.  **View:** De controller stuurt het Model door naar de **View** (bijv. `app/Views/orders/index.php`), die de HTML genereert voor de gebruiker.

---

## 2. Verantwoordelijkheden per Laag

Hieronder staat beschreven waar welke verantwoordelijkheid ligt en waarom.

### A. Models (`app/Models`)
* **Verantwoordelijkheid:** Het representeren van de datastructuur en business regels van één entiteit (zoals een User, Product of Order).
* **Waarom:** In plaats van met losse arrays te werken (wat foutgevoelig is), gebruiken we objecten met *Type Hinting*. Dit garandeert dat een `Product` altijd een prijs en een naam heeft. Onze models zijn voornamelijk *Data Transfer Objects (DTO's)*.

### B. Views (`app/Views`)
* **Verantwoordelijkheid:** Het tonen van de data aan de gebruiker (HTML & CSS).
* **Waarom:** De view mag **geen** complexe logica bevatten (zoals database queries). Door de presentatielaag te scheiden, kunnen we de styling aanpassen zonder de PHP-code te breken.

### C. Controllers (`app/Controllers`)
* **Verantwoordelijkheid:** De "verkeersregelaar". De controller handelt de HTTP-verzoeken af, valideert invoer (bijv. is de gebruiker ingelogd?), roept de juiste repositories aan en laadt de juiste view.
* **Waarom:** De controller koppelt alles aan elkaar, maar bevat zelf **geen** SQL-code. Dit houdt de controller "dun" (*Skinny Controllers*).

### D. Repositories (`app/Repositories`)
* **Verantwoordelijkheid:** Alle communicatie met de database. Hier staan de SQL queries (`SELECT`, `INSERT`, `UPDATE`).
* **Waarom:** Dit is een abstractielaag tussen de applicatie en de database. Als we ooit van database zouden wisselen, of een complexe query moeten aanpassen, hoeven we dat alleen hier te doen en niet in de controllers.

### E. Core (`app/Core`)
* **Verantwoordelijkheid:** De fundering van het framework (Database connectie, Routering, Authenticatie helper).
* **Waarom:** Deze code is generiek en staat los van de specifieke shop-functionaliteit.

---

## 3. Concrete Ontwerpkeuzes

Hieronder twee specifieke keuzes die in dit project zijn gemaakt, verklaard met cursusbegrippen.

### Keuze 1: Gebruik van het Repository Pattern
In plaats van SQL-queries direct in de Controllers te schrijven (bijvoorbeeld `pdo->query(...)` in `OrdersController`), hebben we gekozen voor **Repositories** (`OrdersRepository`).

* **Cursusbegrip:** *Single Responsibility Principle (SRP)* en *Abstraction*.
* **Verklaring:** Een Controller heeft als verantwoordelijkheid het afhandelen van een HTTP-verzoek, niet het praten met een database. Door SQL naar een Repository te verplaatsen, voldoet de Controller beter aan het SRP. Tevens creëert dit een abstractielaag: de Controller vraagt om "alle orders", maar hoeft niet te weten *hoe* die uit de database worden gehaald.

### Keuze 2: Dependency Injection (DI) via de Constructor
In de `public/index.php` (de Router) en in de Controllers zien we het volgende patroon:
```php
// In index.php
new OrdersController(OrdersRepository::make(), ProductsRepository::make());

// In OrdersController.php
public function __construct(OrdersRepository $ordersRepo, ?ProductsRepository $productsRepo) { ... }
