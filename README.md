# 🥛 Dairy Management System

A web-based **Dairy Management System** built using **PHP, Java (Backend), and MySQL**. This system simplifies the process of buying dairy products for customers and allows administrators to manage sales, track inventory, and generate billing invoices seamlessly.

---

## 🚀 Features

### 👤 Customer Side
* **Product Catalog:** Interactive and responsive UI with clean product cards.
* **Instant Checkout:** "Buy Now" feature that calculates totals and updates inventory in real-time.
* **Invoice Generation:** Automatic redirect to `checkout.php` with a verified order ID to print or view bills.

### 👑 Admin Side
* **Sales & Order Management:** Direct form to record manual orders for offline or walk-in customers.
* **Stock & Product Control:** Live tracking of product availability (automatically decrements stock upon successful orders).
* **Customer Mapping:** Data consistency using database foreign key constraints.

---

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3 (Custom Styling & Glassmorphic Overlays), Bootstrap 5
* **Backend:** PHP (OOP & Procedural mix), Java
* **Database:** MySQL (Port: `3307` configuration supported)
* **Server:** XAMPP / Apache

---

## 📋 Database Structure & Constraints

The system relies on a relational database (`dairy_system`) with automated constraints:
* **Orders Table:** Linked to the `customers` table using a Foreign Key constraint (`orders_ibfk_1`) on `customer_id` with `ON DELETE CASCADE`.
* **Order Items Table:** Maps unique `order_id` with `product_id` for accurate breakdown.

---

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Imparas04/dairy-system.git](https://github.com/Imparas04/dairy-system.git)
Database Setup:

Open XAMPP and start Apache & MySQL (Ensure port 3307 or 3306 matches your config).

Go to http://localhost/phpmyadmin.

Create a new database named dairy_system.

Import the provided .sql file (if available) or create tables for users, customers, products, orders, and order_items.

Configure Connection:

Open config.php and verify your connection parameters:

PHP
$conn = new mysqli("localhost", "root", "", "dairy_system", 3307);
Run the Project:

Move the project folder to C:/xampp/htdocs/dairy-system.

Open your browser and navigate to http://localhost/dairy-system.

🔒 Security & Session Handling
Automatic Traffic Routing: Built-in index.php acts as a routing controller, redirecting unauthenticated users back to login.php.

State Preservation: Keeps users securely logged in across tabs until a manual logout is initiated via logout.php.

Error Prevention: Safe execution of queries handled through fallback logic (SELECT MAX(order_id)) to bypass local port synchronization bugs.

👤 Author
Paras Manoj Choudhary - Software Developer / Technical Student
