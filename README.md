# DummyJSON Products Dashboard

A modern, responsive web dashboard for browsing, searching, and managing products sourced from the [DummyJSON](https://dummyjson.com/) REST API.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
  - [Running the App](#running-the-app)
- [Project Structure](#project-structure)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

**DummyJSON Products Dashboard** is a front-end web application that consumes the free [DummyJSON Products API](https://dummyjson.com/docs/products) to display a paginated, filterable, and searchable list of products. It is designed as a practical reference for building data-driven dashboards with real-world API integration patterns.

---

## Features

- 📦 **Product Listing** – Browse all products with thumbnail images, titles, prices, and ratings.
- 🔍 **Search** – Instantly search products by name or description.
- 🏷️ **Category Filter** – Filter products by category (e.g., Electronics, Clothing, Groceries).
- 📄 **Pagination** – Navigate through large result sets with intuitive pagination controls.
- 📊 **Product Detail View** – View full product details including stock, brand, discount, and description.
- 📱 **Responsive Design** – Optimised for desktop, tablet, and mobile screens.

---

## Tech Stack

| Layer        | Technology                |
|--------------|---------------------------|
| UI Framework | React (or Vue / Vanilla JS) |
| Styling      | CSS / Tailwind CSS        |
| HTTP Client  | Fetch API / Axios         |
| Data Source  | [DummyJSON API](https://dummyjson.com/products) |

> **Note:** Update this table to reflect the exact technologies used in the project as development progresses.

---

## Getting Started

### Prerequisites

- [Node.js](https://nodejs.org/) v16 or higher
- npm (comes with Node.js) or [Yarn](https://yarnpkg.com/)

### Installation

```bash
# Clone the repository
git clone https://github.com/omencakep/dummyjson-products-dashboard.git

# Navigate into the project directory
cd dummyjson-products-dashboard

# Install dependencies
npm install
```

### Running the App

```bash
# Start the development server
npm run dev
```

Then open [http://localhost:3000](http://localhost:3000) in your browser.

To create a production build:

```bash
npm run build
```

---

## Project Structure

```
dummyjson-products-dashboard/
├── public/             # Static assets
├── src/
│   ├── components/     # Reusable UI components
│   ├── pages/          # Page-level views
│   ├── services/       # API service layer (DummyJSON calls)
│   ├── styles/         # Global and component styles
│   └── main.js         # Application entry point
├── .env.example        # Example environment variables
├── package.json
└── README.md
```

---

## API Reference

This project uses the [DummyJSON Products API](https://dummyjson.com/docs/products).

| Endpoint | Description |
|---|---|
| `GET /products` | Retrieve all products (supports `limit` & `skip`) |
| `GET /products/{id}` | Retrieve a single product by ID |
| `GET /products/search?q={query}` | Search products by keyword |
| `GET /products/categories` | List all product categories |
| `GET /products/category/{name}` | Filter products by category |

No API key is required.

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature/your-feature-name`
3. Commit your changes: `git commit -m "feat: add your feature"`
4. Push to the branch: `git push origin feature/your-feature-name`
5. Open a Pull Request.

---

## License

This project is licensed under the [MIT License](LICENSE).
