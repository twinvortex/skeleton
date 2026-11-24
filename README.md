# Vortex Framework

A lightweight PHP web application skeleton with routing, MVC structure, CLI generators, database utilities, and a modern frontend asset pipeline.

## Requirements

- **PHP** `>= 8.2`
- **Composer** `2.x`
- **Node.js** `>= 22` and **npm** (for building frontend assets)

## Installation

```bash
composer install
npm install
```

1. Point your web server `DocumentRoot` to `/path/to/project/public`.
2. Configure your database, URLs, and app settings under `app/config/`.
3. Ensure `app/sessions` is writable by your web server user (e.g., `chmod 775 app/sessions` with appropriate group ownership).

Entry point and routing:
- Front controller: `public/index.php`
- Routes: `app/routes.php`

## Frontend Assets

Bundled frontend libraries:
- **Bootstrap** `5.3.9`
- **jQuery** `3.7.1`
- **Font Awesome** `4.3.0`

Assets in `assets/` are compiled into `public/assets/` using **Gulp 5**, **Dart Sass**, **PostCSS** (`autoprefixer` + `cssnano`), and **Terser**:

```bash
npm run build   # Compile SCSS, minify JS, and copy images
npm run css     # Compile and minify assets/sass/**/*.scss -> public/assets/css
npm run js      # Minify assets/js/**/*.js -> public/assets/js
npm run images  # Copy assets/images/**/*.{jpg,png,gif} -> public/assets/images
npm run watch   # Watch assets/ for changes
```

## Console Commands

Run CLI tools via `php console.php` (powered by Symfony Console `^7.4` and Symfony Process `^7.4`):

| Command | Description |
| --- | --- |
| `php console.php db:export <file>` | Export the configured database to `app/dbs/<file>.sql` (and `tests/_data/dump.sql`) |
| `php console.php db:export-schema <file>` | Export the database schema to `app/dbs/<file>-schema.sql` |
| `php console.php db:import <file>` | Import a SQL dump from `app/dbs/<file>.sql` |
| `php console.php gen:ctrl <Name>` | Generate a Controller and Model stub |
| `php console.php gen:cmd <Name>` | Generate a Console command and register it in `console.php` |

## Testing & Security Audits

Development dependencies include **Codeception** (`^5.3`) and **FakerPHP** (`fakerphp/faker ^1.24`).

```bash
composer audit
npm audit
```

## License

MIT
