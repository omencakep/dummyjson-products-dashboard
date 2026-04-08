# DummyJSON Products Dashboard

A Laravel-based web dashboard that fetches product data from the [DummyJSON API](https://dummyjson.com/products), stores it locally, and presents it through interactive charts and a full CRUD interface.

## Features

- **Dashboard** — visual analytics with Chart.js:
  - Products per category (bar chart)
  - Stock distribution: Out of Stock / Low / Medium / High (doughnut chart)
  - Average rating per category (bar chart)
  - Price distribution: 0-50 / 50-100 / 100-500 / 500+ (bar chart)
- **Products** — list, create, edit, and delete products
- **Sync** — pull the latest 100 products from `https://dummyjson.com/products` into the local database with one click
- **Sync log** — every sync attempt is recorded (timestamp, total records, status)

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 (PHP ≥ 8.2) |
| Database | SQLite (default) |
| Frontend | Blade + Tailwind CSS 4 + Chart.js 4 |
| Build tool | Vite 7 |

---

## Requirements

- PHP ≥ 8.2 with the `pdo_sqlite` extension enabled
- Composer
- Node.js ≥ 18 & npm

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/omencakep/dummyjson-products-dashboard.git
cd dummyjson-products-dashboard
```

### 2. One-command setup (recommended)

The project ships with a `setup` Composer script that handles everything:

```bash
composer run setup
```

This script runs the following steps in order:
1. `composer install`
2. Copies `.env.example` → `.env` (if `.env` does not already exist)
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install`
6. `npm run build`

### 3. Manual setup (alternative)

If you prefer to run each step yourself:

```bash
# Install PHP dependencies
composer install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations (creates the SQLite file automatically)
php artisan migrate

# Install JS dependencies and build assets
npm install
npm run build
```

---

## Configuration

Open `.env` and adjust values as needed.

### Database

The default driver is **SQLite**. No extra configuration is required — Laravel creates `database/database.sqlite` automatically on migration.

```env
DB_CONNECTION=sqlite
```

To switch to **MySQL**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## Running the Application

### Development (with hot-reload)

```bash
composer run dev
```

This starts four concurrent processes:
- `php artisan serve` — Laravel development server at `http://localhost:8000`
- `npm run dev` — Vite HMR server
- `php artisan queue:listen` — queue worker
- `php artisan pail` — real-time log viewer

### Production

```bash
npm run build
php artisan serve
```

Open `http://localhost:8000` in your browser. You will be redirected to `/dashboard`.

---

## Syncing Products

The dashboard starts empty. Populate it by syncing data from the DummyJSON API.

**Option A — button in the UI:**  
On the Products or Dashboard page, click the **Sync Products** button. This sends a `POST` to `/sync-products`.

**Option B — direct URL (quick test):**  
Visit `http://localhost:8000/sync-test` in your browser. This runs the sync immediately and redirects to the Products list.

Each sync fetches up to 100 products, upserts them into the `products` table, creates any missing categories, and writes a record to the `sync_logs` table.

---

## Application Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | Redirects to `/dashboard` |
| GET | `/dashboard` | Analytics dashboard |
| GET | `/products` | List all products |
| GET | `/products/create` | Create product form |
| POST | `/products` | Store new product |
| GET | `/products/{id}/edit` | Edit product form |
| PUT/PATCH | `/products/{id}` | Update product |
| DELETE | `/products/{id}` | Delete product |
| POST | `/sync-products` | Sync products from API |
| GET | `/sync-test` | Quick sync test (dev only) |

---

## Database Schema

### `categories`
| Column | Type |
|--------|------|
| id | bigint PK |
| name | string |
| timestamps | — |

### `products`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| api_id | integer, nullable | Original ID from DummyJSON |
| title | string | |
| price | decimal | |
| category_id | FK → categories | |
| brand | string, nullable | |
| rating | decimal, nullable | |
| stock | integer, nullable | |
| discount | decimal, nullable | `discountPercentage` from API |
| last_synced_at | timestamp, nullable | |
| timestamps | — | |

### `sync_logs`
| Column | Type |
|--------|------|
| id | bigint PK |
| last_sync | timestamp |
| total_data | integer |
| status | string (`success` / `failed`) |
| timestamps | — |

---

## Running Tests

```bash
composer run test
# or
php artisan test
```

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
