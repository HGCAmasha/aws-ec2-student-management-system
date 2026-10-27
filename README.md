# Student Management System — AWS EC2 Deployment

A simple web-based Student Management System developed using PHP and MySQL, deployed on an AWS EC2 instance running Ubuntu Server and Apache.

## Project Overview

This project demonstrates how to deploy a database-driven web application on AWS cloud infrastructure.

Users can perform basic CRUD operations to manage student records.

## Features

- View student records
- Add new students
- Edit existing student information
- Delete student records
- Store student details in a MySQL database

## Technologies Used

- **Cloud Platform:** Amazon Web Services (AWS)
- **Compute:** Amazon EC2
- **Networking:** Amazon VPC and Security Groups
- **Operating System:** Ubuntu Server
- **Web Server:** Apache2
- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML and CSS

## Database Structure

Database: `studentapp`

Table: `students`

| Column     | Type                              |
|------------|-----------------------------------|
| id         | INT (Primary Key, Auto Increment) |
| name       | VARCHAR(100)                      |
| email      | VARCHAR(100)                      |
| course     | VARCHAR(100)                      |
| created_at | TIMESTAMP                         |

The database structure is available in `database/schema.sql`.

## Deployment Overview

1. Configured AWS networking and an EC2 instance.
2. Installed Apache, PHP, and MySQL on Ubuntu.
3. Created the Student Management System database.
4. Deployed PHP application files to `/var/www/html`.
5. Configured database connectivity.
6. Accessed the application through the EC2 web server.

## Project Structure

```text
aws-ec2-student-management-system/
├── src/
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   └── delete.php
├── database/
│   └── schema.sql
├── screenshots/
├── README.md
└── .gitignore
```

## Security Notes

- Database credentials are not included in this repository.
- SSH private keys are excluded from version control.
- AWS Security Groups control inbound access to the instance.

## Learning Outcomes

- AWS EC2 instance management
- Basic AWS VPC networking
- Linux server administration
- Apache and PHP deployment
- MySQL database configuration
- Secure remote access using SSH and SCP
- Hosting a database-driven application in the cloud


## Database Setup

1. Install Apache, PHP, and MySQL.
2. Create a MySQL database named `studentapp`.
3. Import the database schema from `database/schema.sql`.
4. Copy `src/db.example.php` to `src/db.php`.
5. Open `src/db.php` and replace the placeholder values with your own MySQL credentials.
6. Place the PHP application files in your Apache web directory.
7. Start Apache and MySQL, then open `index.php` in your browser.

### Security Notes

- Never commit `db.php` containing real database credentials.
- Never upload AWS `.pem` private key files.
- Use sample student records for demonstrations.
- This is an educational project. Authentication and additional security controls are required before deploying it as a public application.
