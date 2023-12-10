# Letsbloom
# Library-Management System
This is a simple RESTful API for managing a library system. It allows basic CRUD operations on books and interacts with a MySQL database.

## Installation
1.Clone repository<br>
`git clone https://github.com/Akhilapanduga/library-management-system.git`

2.Database setup:<br>
Create a MySQL database named library with a table named as info containing columns id (set as the primary key), Book, and Author to prevent the insertion of duplicate data based on the unique id values.<br>
Import the library.sql file to seed the database with the necessary table.

3.Web Server Setup:<br>
Ensure you have a web server (like Apache) set up to serve the PHP files.

4.Configuration:<br>
Update database connection details in insert.php, search.php, and update.php with your MySQL credentials as follows.<br>
$host = "your-host";<br>
$user = "your-username";<br>
$pass = "your-password";<br>
$db = "library";

## Run the application
start web server and open the application in your browser<br>
`(http://localhost/path-to-your-project)`

## Database seeding
To seed the database with mock data, execute the following SQL queries:<br>

1. Open your MySQL client and connect to the database.<br>
2. Copy and paste the following SQL queries and execute them:<br>

sql<br>
 Insert sample books<br>
INSERT INTO info (id, Book, Author) VALUES<br>
(1, 'Book 1', 'Author 1'),<br>
(2, 'Book 2', 'Author 2'),<br>
 ... add more books as needed;<br>

## API Documentation

### 1.Retrieve All Books
   
Endpoint: GET /api/books<br>
Description: Retrieve a list of all books in the library.<br>
Response Format:<br>
json<br>
{"id1":{"bookName":"name1","bookauthor":"author1","bookid":"id1"},<br>
"id2":{"bookName":"name2","bookauthor":"author2 ","bookid":"id2"},<br>
...<br>
"Result":"True",<br>
"Message":"Books fetched successfully"<br>
}


### 2.Add a New Book

Endpoint: POST /api/books<br>
Description: Add a new book to the library.<br>
Request Format:<br>
json<br>
{<br>
  "ID": id,<br>
  "name": "New Book",<br>
  "author": "New Author"<br>
}<br>
If requested data not present previously it gets inserted into database<br>
If requested data already present it doesn't going to insert into databse<br>


### 3. Update Book Details
   
Endpoint: PUT /api/books/{id}<br>
Description: Update the details of a specific book in the library.<br>

Request Format:<br>
json<br>
{
  "name": "Updated Book",<br>
  "author": "Updated Author"<br>
}<br>

If a  data already present with present id with different name and author then it update the data<br>
If a  data already present with present id with same name and same author or there is no data with present id then it dont do anything<br>

## Additional Notes
Ensure proper error handling is implemented for database connections and API operations.<br>
Customize the CSS styles in styles.css for a better user interface.<br>
This is a basic template; modify and expand based on your application's requirements.<br>

 
