# MyBudgetCalculator

**MyBudgetCalculator** ist eine webbasierte Haushaltsbuch-Anwendung zur Verwaltung von Einnahmen und Ausgaben. Mit dieser Anwendung können Nutzer ihre regelmäßigen und einmaligen Einnahmen sowie Ausgaben erfassen, individuelle Kategorien erstellen und eine übersicht über ihre finanzielle Situation erhalten.

## Features

- Verwaltung von **Einnahmen und Ausgaben** (einmalig & wiederkehrend)
- **Individuelle Kategorien** für eine personalisierte Budgetplanung
- **Benutzerfreundliche Oberfläche** mit modernen Web-Technologien
- **Datenbankgestützte Speicherung** mit MySQL
- **Sichere Authentifizierung & Autorisierung** via Laravel

---

## Verwendete Technologien

### Frontend
- [Vue.js](https://vuejs.org/)  Dynamische UI-Komponenten
- [Inertia.js](https://inertiajs.com/)  Verknüpfung von Laravel und Vue.js
- [TailwindCSS](https://tailwindcss.com/)  CSS-Framework für modernes Styling
- [Vite](https://vitejs.dev/) Schneller Build-Prozess fÃ¼r das Frontend

### Backend
- [Laravel](https://laravel.com/) (PHP)  Leistungsstarkes Web-Framework
- [MySQL](https://www.mysql.com/) Relationale Datenbank zur Speicherung von Finanzdaten

### Tools & Deployment
- [Composer](https://getcomposer.org/) PHP-Paketverwaltung
- [NPM](https://www.npmjs.com/) Verwaltung von JavaScript-Abhängigkeiten

---

## Installation für Entwickler (Lokale Umgebung)

### Voraussetzungen
- PHP (>= 8.1)
- MySQL (oder eine kompatible Datenbank wie MariaDB)
- Node.js (>= 18)
- Composer

### Schritte zur Installation
1. **Repository klonen**  
   ```sh
   git clone https://github.com/ShakirPlayZ/MyBudgetCalculator.git
   cd MyBudgetCalculator
   ```

2. **Abhängigkeiten installieren**  
   ```sh
   composer install
   npm install
   ```

3. **Umgebungsvariablen konfigurieren**  
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. **Datenbank konfigurieren**  
   Bearbeite die `.env`-Datei und setze die Datenbankverbindung entsprechend:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mybudgetcalculator
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Datenbank-Migrationen & Seed-Daten ausführen**  
   ```sh
   php artisan migrate --seed
   ```

6. **Entwicklungsserver starten**  
   ```sh
   php artisan serve
   npm run dev
   ```

Die Anwendung läüft nun unter `http://localhost:8000`.

---

## Deployment (Live-Umgebung)

### Voraussetzungen
- PHP (>= 8.1)
- MySQL-Datenbank
- Webserver (z. B. Apache oder Nginx)
- SSH-Zugriff auf den Server

### Schritte zum Deployment
1. **Repository auf Server klonen**  
   ```sh
   git clone https://github.com/ShakirPlayZ/MyBudgetCalculator.git
   cd MyBudgetCalculator
   ```

2. **Abhängigkeiten installieren**  
   ```sh
   composer install --no-dev --optimize-autoloader
   npm install && npm run build
   ```

3. **Umgebungsvariablen setzen & App-Schlüssel generieren**  
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. **Datenbank konfigurieren & Migrationen ausführen**  
   ```sh
   php artisan migrate --force
   ```

5. **Cache & Optimierungen aktivieren**  
   ```sh
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Webserver konfigurieren (z. B. Nginx oder Apache)**  
   - Stelle sicher, dass dein Webserver den `public/`-Ordner als Root-Verzeichnis verwendet.

Das Projekt ist nun erfolgreich online.

---

## Lizenz

Dieses Projekt steht unter der **MIT-Lizenz**. Weitere Informationen findest du in der Datei `LICENSE`.