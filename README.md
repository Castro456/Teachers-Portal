# Teachers-Portal

## Description
A web application for managing student records securely and efficiently. The application is highly scalable and built with Laravel framework and jQuery for frontend interactions.

## Technologies Used
- Framework: Laravel
- Frontend: jQuery

## Local Setup
1. Clone the repository.
2. Create your Laravel `.env` file and configure it with `db_database`, `db_username`, and `db_password` for database connection.
3. Ensure a reliable internet connection for loading CDN resources.
4. Migrate the database using the command: php artisan migrate


## Modules

### Login Page
- Users need to provide email and password to access the portal.

### Register Page
- New users can register with their name, email, and password. Email must be unique.
- Passwords are encrypted for enhanced security.

### Portal Page
- Displays a list of students.
- Shows the logged-in user's name in the navigation bar with an option to logout.
- **Create:** Teachers can add a new student. Required fields include Name, Subject, and Marks. If a student with the same Name and Subject exists, the Marks will be added to the existing record.
- **View:** Displays student details including Name, Subject, and Marks.
- **Edit:** Allows teachers to modify student details (Name, Subject, Marks).
- **Delete:** Prompts for confirmation before permanently deleting a student record.

## Additional Information
- jQuery is used primarily for handling API responses. 
- Login, Register, and CRUD functionalities for students are implemented as APIs.

