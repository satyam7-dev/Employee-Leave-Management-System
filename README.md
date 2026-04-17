# Employee-Leave-Management-System
Develop a basic employee leave management system for a small company with around 50 employees. The system aims to automate the process of requesting and approving leave requests, providing transparency and efficiency in managing employee absences
📋 Overview
A complete Employee Leave Management System built with HTML, CSS, JavaScript, MySQL, and PHP for small companies (50+ employees). This system automates leave request submission, approval workflows, balance tracking, and calendar visualization.

✨ Features
✅ User Authentication - Secure login for employees and managers
✅ Role-based Access - Different permissions for employees vs managers
✅ Leave Request Submission - Form with validation for leave requests
✅ Approval Workflow - Managers review and approve/reject requests
✅ Leave Balance Tracking - Automatic balance updates
✅ Calendar View - Visual leave schedule
✅ Responsive Design - Works on desktop and mobile
🛠️ Tech Stack

Frontend: HTML5, CSS3, Vanilla JavaScript
Backend: PHP 8+, MySQL 8+
Database: MySQL
Authentication: PHP Sessions + Password Hashing
Styling: Custom CSS + Font Awesome Icons
🚀 Quick Start
Prerequisites
XAMPP or WAMP (Apache + MySQL + PHP)
PHP 7.4+
MySQL 5.7+
Installation Steps
Setup Database

bash
# 1. Start XAMPP (Apache + MySQL)
# 2. Open phpMyAdmin (http://localhost/phpmyadmin)
# 3. Create database and run SQL:
Copy the SQL from database.sql and execute it.

Project Setup

bash
# 1. Copy all files to htdocs/leave-management/
# 2. Update config.php with your DB credentials
# 3. Access: http://localhost/leave-management/
Demo Login Credentials

Employee 1: employee1 / password
Employee 2: employee2 / password  
Manager:    manager1 / password
📁 Project Structure

leave-management/
├── database.sql          # MySQL database setup
├── config.php           # Database connection
├── login.php            # Authentication handler
├── api.php             # REST API endpoints
├── logout.php          # Session logout
├── index.html          # Login page
├── dashboard.html      # Main dashboard
├── style.css           # Stylesheets
└── script.js           # JavaScript functionality
🎮 How to Use
Employee Workflow
Login → Dashboard
Request Leave → Fill form → Submit
View My Requests → Track status
Check Balance → See remaining leave days
Calendar → View company leave schedule
Manager Workflow
Login → Dashboard
Pending Approvals → Review requests
Approve/Reject → Add comments
Calendar → Company-wide view
🔧 API Endpoints
All API calls handled via api.php?action=...

GET    api.php?action=get_leave_types
POST   api.php?action=submit_leave
GET    api.php?action=get_pending_requests
POST   api.php?action=update_request
GET    api.php?action=get_my_requests
GET    api.php?action=get_leave_balance
GET    api.php?action=get_calendar_data
📊 Database Schema
sql

users          # User accounts & roles
leave_types    # Vacation, Sick, Personal
leave_balances # Employee leave entitlements
leave_requests # All leave requests
Key Relationships:

users 1:N leave_requests (submitter)
users 1:N leave_requests (approver/manager)
users 1:N leave_balances
leave_types 1:N leave_requests
leave_types 1:N leave_balances
⚙️ Configuration
config.php
php

$host = 'localhost';
$dbname = 'leave_management';
$username = 'root';     // Update as needed
$password = '';         // Update as needed
🔒 Security Features
Password hashing (password_hash() / password_verify())
Session-based authentication
Role-based access control
SQL injection prevention (Prepared Statements)
Input validation & sanitization
CSRF protection ready (add tokens)
📱 Responsive Design
Mobile-first approach
Works on phones, tablets, desktops
Touch-friendly interface
Optimized for 50+ employee companies
🐛 Troubleshooting
Issue

Solution

Login fails

Check config.php DB credentials

500 Error

Enable PHP error display in php.ini

API fails

Check browser console + PHP error logs

Calendar blank

Verify approved leave requests exist

