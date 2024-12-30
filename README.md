# secure-login-system

Project Overview
This User Management System allows users to manage their personal accounts and details securely. It is designed with the following core functionalities:

User Registration (Sign Up):
New users can create an account by providing necessary details such as their email, username, and password. After successful registration, they can access the system's features.

User Login:
Registered users can log into their accounts using their email and password. This functionality ensures secure access to personal and system-related data.

Forgot Password:
If a user forgets their password, they can initiate a password recovery process. The system will allow them to reset their password through a secure link sent to their registered email.

Edit User Details:
Logged-in users can update their personal details such as name, email address, and other profile information. This ensures that users can keep their accounts up-to-date.

# system requirments

- PHP version (PHP 8.0 or higher)
- Web server (Apach)
- Database (MySQL)
- Composer (for forgot password and account activation)

# Installation Instructions

1. Clone or download the repository.
   ```
   git clone https://github.com/secure-login-system.git
   ```
2. Install dependencies:
   ```
   composer install
   ```
3. Start the application:
   - Deploy it on your server or run it locally using PHP:
     ```
     php -S localhost:8000
     ```
