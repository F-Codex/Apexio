# Apexio - Project Management System

**Apexio** is a web-based project management application designed to facilitate efficient team collaboration. This application is built using **Laravel 11** and **Livewire 3**, adopting a *Modern Monolith* approach.

---

## 📸 Application Interface

Below is the main interface of Apexio, featuring the Sidebar and Kanban Board:

![Dashboard & Kanban](./screenshots/kanban_and_sidebar.jpeg)

---

## ✨ Key Features

### 1. User Interface
* **Navigation Sidebar:** A fixed left-side navigation menu with active page indicators and a dynamic project list.
* **Responsive Layout:** Utilizes Flexbox to ensure the display fills the screen perfectly without double scrolling.
* **Clean Design:** Styling uses Bootstrap 5 customized with SCSS.

### 2. Task Management (Kanban)
* **Kanban Board:** Visualizes task statuses across columns (To-Do, In-Progress, Done).
* **Task Cards:** Displays critical details such as title, priority, status, and assignee.
* **Discussion:** Integrated comment feature on every task card.

### 3. User Profile
* **Profile Photo:** Users can upload profile photos with an instant *preview* feature before saving.
* **Account Settings:** A centralized settings page to manage profile information, passwords, and account deletion options.

---

## 🚀 Development Roadmap

Features scheduled for the next development phase:

- [x] **Drag & Drop Kanban:** Implement moving cards between columns via drag-and-drop (*SortableJS*).
- [x] **Due Date System:** Add due dates to tasks with overdue indicators.
- [x] **Real-time Notifications:** Automated notifications for deadlines or task updates.
- [ ] **"My Tasks" Page:** A dedicated page displaying all tasks assigned to the current user across all projects.
- [ ] **Super Admin Dashboard:** A specialized panel for user and system management.

---

## 🛠️ Technology Stack

* **Backend:** Laravel 11
* **Frontend:** Livewire 3
* **Styling:** Bootstrap 5 + SCSS
* **Database:** MySQL / MariaDB
* **Scripting:** Alpine.js

---

## 💻 Installation Guide

Ensure you have **PHP 8.2+**, **Composer**, and **Node.js** installed before starting.

### 1. Initial Setup
Run the following commands in your terminal (Command Prompt / Bash):

```bash
# Clone the repository
git clone https://github.com/noireveil/Apexio.git
cd Apexio

# Install Backend & Frontend dependencies
composer install
npm install

# Duplicate environment configuration
cp .env.example .env

# Generate Application Key
php artisan key:generate
````

### 2\. Database Configuration

Open the `.env` file and adjust the database configuration (`DB_DATABASE=apexio`). Then follow the steps for your operating system:

#### A. Windows Users (Laragon/XAMPP)

1.  Ensure Laragon/XAMPP is running (**Start All**).
2.  Open **HeidiSQL** (Laragon) or **phpMyAdmin**.
3.  Create a new database named: `apexio`.
4.  Ensure the `.env` file matches your credentials (Laragon default is usually user: `root`, password: empty).

#### B. Linux Users (Terminal)

1.  Ensure the database service is running: `sudo systemctl start mariadb` (or `mysql`).
2.  Login to MySQL and create the database:
    ```bash
    mysql -u root -p -e "CREATE DATABASE apexio;"
    ```
3.  Adjust the database username and password in the `.env` file if you use custom credentials.

### 3\. Migration & Storage

Once the database is ready, run the following commands in the project terminal to create tables and seed initial data:

```bash
# Create tables and seed initial data (Seeder)
php artisan migrate:fresh --seed

# Create a shortcut so profile photos are publicly accessible (MANDATORY)
php artisan storage:link
```

### 4\. Running the Application (IMPORTANT)

This application requires **two terminal processes** running simultaneously for the Backend functions and Frontend styling to work.

**Terminal 1 (Run Laravel Server):**

```bash
php artisan serve
```

**Terminal 2 (Run Asset Compilation / Vite):**

```bash
npm run dev
```

Access the application via browser at: `http://localhost:8000`