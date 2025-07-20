# Backoffice & Database Project

## Student Information

- **Name:** Gust Pêtre
- **E-mail:** gust.petre@student.arteveldehs.be

## Project Description

This application is a backoffice system for managing an online book collection. The backoffice is designed for administrators, allowing them to create, update, delete, and view books, authors, genres, and publishers in a central database. This system helps administrators efficiently manage and structure book information.

## Features

- Full CRUD for books and authors
- File upload (book cover image)
- One-to-many relationship: select author for a book (dropdown)
- Many-to-many relationship: assign genres to a book (checkbox-list)
- Dashboard with 2 statistics (books per genre, books per year)
- File manager for uploaded files (including delete)
- Search and sort in the book list
- Public API (fetch books, add comments)
- Protected against SQL injection (prepared statements)
- Modern layout with Bootstrap (Sass)

## Installation

1. **Clone the project**
2. **Install dependencies**
   ```
   npm install
   ddev composer install
   ```
3. **Start the DDEV environment**
   ```
   ddev start
   ```
4. **Import the database**
   - Use the `database.sql` file in your database manager or via DDEV:
     ```
     ddev mysql < database.sql
     ```
5. **Compile the CSS**
   ```
   npx sass public/css/main.scss public/css/main.css --no-source-map --style=expanded
   ```
6. **Open the site**
   - Usually at: http://backoffice.ddev.site

## API Usage

### Fetch books

- **GET** `/api/books`
- Optional search: `/api/books?search=harry`
- **Result:** JSON list of books

### Add a comment

- **POST** `/api/comments`
- **Body (JSON):**
  ```json
  {
    "book_id": 1,
    "author": "Your Name",
    "content": "Great book!"
  }
  ```
- **Result:** `{ "success": true, "id": ... }`

## File Manager

- Go to `/filemanager` to view and delete all uploaded files.

## Dashboard

- The homepage shows 2 charts:
  - Books per genre (bar chart)
  - Books per publication year (line chart)

## Security

- All database queries use prepared statements (SQL injection impossible)
- Uploads are stored in a separate folder (`public/uploads/`)

## Other Info

- Project uses the base MVC pattern
- Bootstrap/Sass for styling
- See code and comments for further explanation

---

**Questions or issues?** Contact via the e-mail address above.
