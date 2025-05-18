
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

## Getting Started

### 1. Clone the repository

```sh
git clone https://github.com/yourusername/iSIMS-Web.git
cd iSIMS-Web