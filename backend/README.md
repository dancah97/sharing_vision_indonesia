# Laravel Project

## Installation

1. **Install dependencies**
   ```sh
   composer install
   ```

2. **Copy .env file and set environment variables**
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other necessary configurations.

3. **Generate application key**
   ```sh
   php artisan key:generate
   ```

## Database Migration

1. **Run migrations**
   ```sh
   php artisan migrate
   ```

## Running the Project

1. **Start the development server**
   ```sh
   php artisan serve
   ```
   This will start the application at `http://127.0.0.1:8000`