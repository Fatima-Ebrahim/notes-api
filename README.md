# Notes API - Backend

This is the backend API for the Notes application, built with Laravel 10. The project follows professional software architecture principles, including the Controller-Service-Repository pattern, to ensure the codebase is clean, scalable, and maintainable.

## Key Features

-   **RESTful API**: Clean and predictable API endpoints.
-   **Separation of Concerns**: Logic is decoupled into Controllers, Services, and Repositories.
-   **Request Validation**: Robust validation using dedicated Form Request classes.
-   **Dependency Injection**: Utilizes Laravel's Service Container to manage class dependencies and bind interfaces to implementations.
-   **Database Migrations**: Easy database schema management with Laravel Migrations.

## Tech Stack

-   **Framework**: Laravel 10+
-   **Language**: PHP 8.1+
-   **Database**: MySQL 
-   **Package Manager**: Composer

---
## Project Architecture

The project is built upon a layered architecture to achieve a high degree of Separation of Concerns (SoC). Below is a simplified view of the structure within the `app` directory:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── NoteController.php       
│   └── Requests/
│       └── StoreNoteRequest.php     
│
├── Models/
│   └── Note.php
│
├── Providers/
│   └── RepositoryServiceProvider.php  
│
├── Repositories/
│   ├── Interfaces/
│   │   └── NoteRepositoryInterface.php  
│   └── NoteRepository.php           
│
└── Services/
    ├── Interfaces/
    │   └── NoteServiceInterface.php   
    └── NoteService.php              
```

For a detailed explanation of the design philosophy and the role of each component, please refer to the "Project Architecture & Design Philosophy" section in the full project documentation.

## Project Architecture & Design Philosophy

This project is built upon a layered architecture inspired by Domain-Driven Design (DDD) principles to achieve a high degree of **Separation of Concerns (SoC)**. The chosen pattern is **Controller-Service-Repository**, which offers significant advantages in terms of code quality, scalability, and ease of maintenance.

### Why This Architecture?

In simple applications, it's common to place all logic within the Controller. However, as applications grow, this approach (known as a "Fat Controller") leads to code that is difficult to read, test, and maintain.

By adopting the Controller-Service-Repository pattern, we address these issues directly:

1.  **Maintainability**: Each component has a single, well-defined responsibility. If you need to change database logic, you only touch the Repository. If business rules change, you only edit the Service. This makes finding and modifying code much simpler and safer.
2.  **Testability**: Decoupling allows for easier unit testing. We can "mock" the Repository when testing the Service to isolate the business logic, or mock the Service when testing the Controller. This ensures that tests are fast and reliable.
3.  **Scalability**: The clear separation allows different team members to work on different layers (e.g., one developer on the API layer, another on the business logic) with minimal conflict. It also makes it easier to introduce new features without breaking existing ones.
4.  **Reusability**: Business logic in the Service layer can be reused by different parts of the application (e.g., an API Controller, a Web Controller, or a command-line Artisan command) without duplicating code.

### Component Roles in Detail

The flow of a request is handled by a chain of specialized components:

-   **`Form Request` (The Gatekeeper)**
    -   **Responsibility**: To validate incoming HTTP request data.
    -   **How it's built**: A dedicated class that contains all validation rules and authorization logic for a specific request. It cleans the input before it even reaches the controller, ensuring the controller only works with valid data.

-   **`Controller` (The Traffic Manager)**
    -   **Responsibility**: To handle the HTTP layer. It parses the request, calls the appropriate service method, and formats the result into an HTTP response (usually JSON).
    -   **How it's built**: It is kept "thin" and clean. It knows nothing about the database or the business logic's complexity. It only orchestrates the interaction between the HTTP world and the application's core logic.

-   **`Service` (The Brains of the Operation)**
    -   **Responsibility**: To execute the core business logic and application-specific rules.
    -   **How it's built**: It coordinates one or more repositories to gather data, performs calculations or operations, and implements the use cases of the application (e.g., "create a new note"). It is the central point for the application's functionality.

-   **`Repository` (The Librarian)**
    -   **Responsibility**: To abstract the data access layer. Its only job is to communicate with the database.
    -   **How it's built**: It contains all the Eloquent queries. This abstraction means the rest of the application doesn't need to know *how* data is stored or retrieved. If we were to switch from SQL to a NoSQL database, we would only need to change the implementation of the repository, not the service or controller. The use of an **Interface** (`NoteRepositoryInterface`) ensures a consistent contract for data access.

This structured approach, while requiring more initial setup, pays significant dividends in the long run by creating a robust, professional, and highly manageable codebase.



## Project Setup and Installation

Follow these steps to get the project up and running on your local machine.

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/Fatima-Ebrahim/notes-api
    cd notes-api
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Configuration**
    -   Create a copy of the `.env.example` file and name it `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Generate a new application key:
        ```bash
        php artisan key:generate
        ```

4.  **Database Setup (MySQL)**
    -   Create the MySQL database :
       
    -   Ensure your `.env` file is configured for MySQL:
        ```env
        DB_CONNECTION=mysql
        ```

5.  **Run Database Migrations**
    -   This will create the `notes` table in your database.
        ```bash
        php artisan migrate
        ```

6.  **Start the Development Server**
    ```bash
    php artisan serve
    ```
    The API will now be available at `http://127.0.0.1:8000`.

## API Endpoints Documentation

Here are the available API endpoints.

### `GET /api/notes`

-   **Description**: Retrieves a list of all notes, ordered by the most recently created.
-   **Success Response (200 OK)**:
    ```json
    [
        {
            "id": 1,
            "title": "My First Note",
            "content": "Content of the first note.",
            "created_at": "2025-09-25T18:00:00.000000Z",
            "updated_at": "2025-09-25T18:00:00.000000Z"
        },
        {
            "id": 2,
            "title": "Another Note",
            "content": "More content here.",
            "created_at": "2025-09-25T18:05:00.000000Z",
            "updated_at": "2025-09-25T18:05:00.000000Z"
        }
    ]
    ```

### `POST /api/notes`

-   **Description**: Creates a new note.
-   **Headers**:
    -   `Content-Type`: `application/json`
    -   `Accept`: `application/json`
-   **Request Body**:
    ```json
    {
        "title": "A New Note Title",
        "content": "This is the main content of the new note."
    }
    ```
-   **Success Response (201 Created)**:
    ```json
    {
        "id": 3,
        "title": "A New Note Title",
        "content": "This is the main content of the new note.",
        "updated_at": "2025-09-25T18:10:00.000000Z",
        "created_at": "2025-09-25T18:10:00.000000Z"
    }
    ```
-   **Error Response (422 Unprocessable Entity)**:
    -   Triggered if validation fails (e.g., missing `title`).
    ```json
    {
        "message": "The title field is required.",
        "errors": {
            "title": [
                "The title field is required."
            ]
        }
    }
    ```

