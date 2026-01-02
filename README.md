# concatweb

## Table of Contents

- [Setup](#setup)
    - [General](#general)
    - [Start the development server](#start-the-development-server)
- [Large File Uploads](#large-file-uploads)

## Setup

### General

1. Clone the GitHub repository either via the **cli** or **GitHub Desktop**
2. Navigate to the project directory
3. Run `composer install` and `npm install` to install dependencies
4. Copy the `.env.example` file to `.env` and configure the following variables:
    - All variables starting with `DB_` for your database connection
    - `APP_URL` to match your local development URL
    - `APP_KEY` by running `php artisan key:generate`
5. Create the database by running `php artisan migrate --seed`
6. After that run `php artisan db:seed` to seed the database with initial data

### Start the development server

Run `php artisan serve` and `npm run dev` to start the Laravel development server and compile assets.

## Large File Uploads

If a file upload fails before Laravel validation, it is often because the **server's `upload_max_filesize` is smaller or
equal to the max size set in the request**.

Key points for developers:

- PHP blocks uploads exceeding `upload_max_filesize` before Laravel sees them.
- `post_max_size` must be at least as large as `upload_max_filesize`.
- The Laravel validator (`max:<size>`) only applies to files that successfully reach the server.
- **Always set the server's `upload_max_filesize` slightly higher than the max file size enforced in your form request**
  to avoid silent failures. Consider also handling `PostTooLargeException` in `Handler.php` to provide a clear error to
  users.
