# Libra Library Management System — PHP + MySQL

A local XAMPP-ready library management system with separate administrator and member panels. It is the PHP implementation of the discussed MERN library project.

## Features

### Member panel
- Self-registration and login (username or email).
- Automatic library member profile and unique Member ID.
- Personal dashboard showing current borrowing, borrowing history, overdue records and unpaid fine estimate.
- Personal issue/return history, due dates and recorded fines.
- Browse catalogue and request a reservation.
- View membership information.
- Members can only access their own records.

### Administrator panel
- Dashboard statistics and recent circulation.
- Book catalogue: add, edit, delete, search and copy tracking.
- Member directory and account status control.
- Issue books to registered members and record returns.
- Automatic final fine calculation on return.
- Fine ledger: mark paid or waive.
- Reservation review and status updates.
- Circulation report with CSV export.
- Fine-per-day and loan-period settings.
- Audit log.

### Permissions
- A member can create an account and sign in.
- Registration does **not** issue a book.
- Only an administrator can issue a book, record a return, alter fines or manage library records.
- Member pages query data using the authenticated account's linked member record; a member cannot choose another member ID.
- No mailer, password-reset or public administrator registration is included.

## Requirements
- PHP 8.0+ with PDO MySQL enabled
- MySQL 5.7+ / MariaDB
- XAMPP (recommended on Windows)

## XAMPP setup
1. Extract the `library-php-final` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** in XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Import `sql/schema.sql` (it creates `library_management`).
5. Check `config.php`. Default XAMPP values are host `127.0.0.1`, user `root`, blank password. Change them if your MySQL credentials differ.
6. Open a terminal in `C:\xampp\htdocs\library-php-final` and run:

   ```bash
   php seed_admin.php
   ```

7. Open `http://localhost/library-php-final/`.

## Administrator demo login
- Username: `admin`
- Password: `admin123`

Change the demo password before using this system with real member data. The seed script does not overwrite an existing administrator password.

## Member registration
Open the login page and select **Create a member account**. Members can then sign in and see their own account. They will see no borrowed books until the administrator issues a book from **Issue / Return**.

## Fine calculation
The default fine is ₹10 per overdue day and the default loan period is 14 days. Change these in Admin → Settings. The member dashboard shows a live estimate for books that are still overdue. The final fine is stored when the administrator records the return. Fine payments and waivers are administrator-only.

## Notes
- This is designed for local use. For public hosting, configure HTTPS, stronger credentials, backups, and server-level protections.
- SQL schema import is required before opening the app.
- No external JavaScript libraries or Node/npm setup is required.
"# Library-Management-PHP" 
