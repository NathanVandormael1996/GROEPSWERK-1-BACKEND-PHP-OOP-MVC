# CHANGELOG

**Project:** Warhammer 40k Webshop
**Datum:** 2026-02-11
**Versie:** 1.0

---

## Groepslid 1: Nathan
**Rol:** Lead Developer (Architecture, Products, Shop & Cart)

### 🚀 Uitgewerkte Onderdelen

#### 1. Projectopzet & Architectuur
* **MVC Structuur:** Opzetten van de volledige Model-View-Controller architectuur.
* **Routing:** Implementatie van de `Router` en `index.php` entry point om URL's naar controllers te vertalen.
* **Autoloader:** Zorgen dat classes automatisch worden ingeladen.

#### 2. Product Management (Full Stack)
* **Admin Backend:** Volledige CRUD (Create, Read, Update, Delete) functionaliteit gemaakt voor producten.
* **Webshop Frontend:** De publieke weergave (`ShopController`) met grid-view en detailpagina's.
* **Views:** Alle views voor producten (zowel admin tabellen als klant kaarten) ontwikkeld.

#### 3. Winkelwagen & Checkout
* **Cart Logica:** `CartController` gebouwd voor sessie-gebaseerd winkelwagen beheer (toevoegen, verwijderen, totalen).
* **Order Systeem:** `OrdersController` en Repository gebouwd om bestellingen definitief op te slaan (Transacties).
* **Voorraad Check:** Implementatie van de stock-check en automatische voorraadvermindering bij aankoop.

### 📂 Verantwoordelijke Bestanden
* `app/Core/Router.php`
* `public/index.php`
* `app/Controllers/ProductsController.php`
* `app/Repositories/ProductsRepository.php`
* `app/Controllers/ShopController.php`
* `app/Controllers/CartController.php`
* `app/Controllers/OrdersController.php`
* `app/Repositories/OrdersRepository.php`
* `app/Views/products/*`
* `app/Views/shop/*`
* `app/Views/cart/*`

---

## Groepslid 2: Kirano
**Rol:** Backend Developer (Database, Roles & Auth)

### 🛠 Uitgewerkte Onderdelen

#### 1. Database Layer
* **Database Connectie:** Ontwikkeling van de `Database` class en connectie-logica.
* **Configuratie:** Opzetten van de database parameters.

#### 2. Roles Management (Rollen & Rechten)
* **MVC Implementatie:** Volledige ontwikkeling van de `RolesController`, `RolesModel` en `RolesRepository`.
* **Structuur:** Het opzetten van de logica achter gebruikersrollen.

#### 3. Users & Authenticatie
* **User Management:** Opzetten van `UsersRepository` en `UsersModel` voor het ophalen van gebruikersdata.
* **Auth:** Basis setup voor inloggen en sessiebeheer.

### 📂 Verantwoordelijke Bestanden
* `app/Core/Database.php`
* `app/Controllers/RolesController.php`
* `app/Models/RolesModel.php`
* `app/Repositories/RolesRepository.php`
* `app/Repositories/UsersRepository.php`
* `app/Models/UsersModel.php`
* `app/Controllers/AuthController.php`