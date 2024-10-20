# Laravel Task Management Application

This is a simple Laravel-based task management application that allows users to create, view, update, and delete tasks.

## Features

- Create new tasks with a title, description, due date, and status.
- View tasks with pagination, search, and filter by status.
- Edit tasks and update details.
- Delete tasks with confirmation.
- Modern UI with Bootstrap and SweetAlert for a smooth user experience.

## Prerequisites

Before setting up the application, make sure you have the following installed:

- [PHP 8.x](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)
- [Git](https://git-scm.com/)
- A database server (e.g., MySQL)

## Getting Started

### 1. Clone the Repository

Clone the repository to your local machine:


2. Install Dependencies
Run the following command to install PHP dependencies:
composer install


3. Set Up Environment
Copy the .env.example file to create your environment configuration:

cp .env.example .env

4. Generate Application Key
Run the following command to generate a unique application key:

php artisan key:generate

5. Set Up Database
Open the .env file and configure your database connection:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

Create the database manually in your MySQL or preferred database server.

6. Run Database Migrations and Seeders
Run the following command to create the necessary tables and seed the database with test data:


php artisan migrate --seed


7. Serve the Application

Start the local development server: