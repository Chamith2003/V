# Volunteer & Event Management System

A robust, full-stack web application designed to manage volunteers, sponsors, events, and organizations. The system features a custom MVC (Model-View-Controller) architecture natively written in PHP, ensuring optimal performance and maintainability. It simplifies administrative workflows with role-based access, automated cron-like tasks, comprehensive CSV reporting, and advanced Google Maps integration.

## 🚀 Key Features

### 👥 Multi-Role User Management
* **Roles:** Handles diverse actors including Admins, Managers, Organization Representatives, Volunteers, and Sponsors.
* **Smart Roles:** Automated intelligence built-in (e.g., dynamically downgrading Organization Representatives to Volunteers upon term expiration).
* **Representative Appointments:** System-calculated top representatives based on accumulated "level points".

### 🗓️ Advanced Event Management
* **Interactive Event Maps:** Integrates Google Maps APIs with dynamic UI indicators (such as animated/blinking markers for "active" events when the current user is registered).
* **Location Resolution:** Robustly parses and tracks modern map URLs (e.g., shortened `maps.app.goo.gl` links) for accurate coordinate assignments.
* **Attendance & Tracking:** Manages volunteer event registrations, attendance, and hour-logging.

### 📊 System Overview & Analytics
* **Comprehensive Reporting:** Built-in modal-based report generator in the Admin Panel for querying Event, Volunteer, and Sponsor statistics.
* **Data Filtering:** Support for date range narrowing and sub-category selections (Attendance, Hours logged, Donation amounts).
* **CSV Exports:** One-click CSV downloading for any generated report.

### 🛠️ Technical Implementation
* **Architecture:** Custom MVC framework handled by a centralized `router.php`.
* **Mail Server:** Native asynchronous/synchronous mail sending via `PHPMailer`.
* **Database Management:** Secure data extraction and manipulation using PDO.

## 💻 Tech Stack

* **Backend:** PHP 8+ (Custom MVC)
* **Frontend:** HTML5, Vanilla CSS3 (Custom animations), Vanilla JavaScript/AJAX
* **Database:** MySQL
* **Integrations:** Google Maps API, PHPMailer

## ⚙️ Local Installation Directory Structure

```text
/
├── Controller/      # Application route controllers responding to router.php
├── Database/        # SQL structure and connection configurations
├── Model/           # Database Object-Relational mapping and business logic
├── View/            # Front-end UI files, layouts, and components
├── PHPMailer/       # Email integration library
├── uploads/         # Local file and asset storage
├── config.php       # Environment & database configuration 
├── mailconfig.php   # SMTP configuration
└── router.php       # Centralized MVC routing dispatcher
