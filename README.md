# iSIMS2.0

---

## What is MVC?

**MVC** stands for **Model-View-Controller**:

- **Model:** Handles data and database logic.  
  Example: `src/Models/User.php` fetches user data from the database.

- **View:** Handles what the user sees (HTML, forms, messages).  
  Example: `src/Views/Login.php` displays the login form and messages.

- **Controller:** Handles user input, processes requests, and coordinates between Model and View.  
  Example: `src/Controllers/AuthController.php` processes login requests.

---

## Configuration

**Add `config.php` to the project root (outside the `public` directory) with the following content:**

```php
<?php
return [
    'host' => '127.0.0.1', // your host
    'db'   => 'yourDatabaseName', // database name
    'user' => 'root', 
    'pass' => ''
];
?>
```

*Do not commit your real `config.php` to version control. Add it to `.gitignore`.*

---

## Getting Started

### 1. Clone the repository

```sh
git clone https://github.com/yourusername/iSIMS2.0.git
cd iSIMS2.0
```

### 2. Configure your database

- Edit `config.php` with your database credentials.
- Create your MySQL database and required tables (e.g., `students`).

### 3. Run the app locally

- Start XAMPP
- Visit `http://localhost/iSIMS2.0/public/` in your browser.

---

## Security Notes

- **Never commit real credentials** (`config.php`, `.env`) to version control.
- Use `password_hash()` and `password_verify()` for storing and checking passwords.
- Always use prepared statements for database queries.

---

**Happy coding!**