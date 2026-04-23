# YOUxBUILD – PC Components Marketplace

## 📌 Project Overview

YOUxBUILD is a web-based marketplace for buying and selling PC components and prebuilt computers.
The platform allows users to browse products, add them to a cart, and place orders, while vendors can manage their own products.

This project was developed as a **final year project (Projet Fil Rouge)** using Laravel.

---

## 🚀 Features

### 👤 Client

* Register and login
* Browse products
* Search and filter by category
* View product details
* Add products to cart
* Checkout with payment simulation
* View order history
* Track order status (confirmed, shipped, delivered)

---

### 🧑‍💼 Vendor

* Request vendor account (admin approval required)
* Add, edit, and delete products
* Manage their own products only
* View orders related to their products
* Update order status

---

### 🛠 Admin

* Approve or reject vendors
* Manage categories (add / delete)
* View all orders
* Manage users and platform data

---

## 🛒 Marketplace Flow

```text
User → Browse Products → Add to Cart → Payment → Order Confirmation → Delivery Tracking
```

---

## 🧠 Architecture

* Laravel (Blade, MVC)
* Role-based access control (visitor, client, vendor, admin)
* Orders system used as cart (status = pending)

---

## 🗂️ Main Features Implemented

* Authentication system
* Vendor approval system
* Product management (CRUD)
* Public marketplace (listing + details)
* Cart system (via orders)
* Payment simulation step
* Order lifecycle (confirmed → shipped → delivered)
* Search and category filtering
* Admin dashboard features

---

## 🧱 Tech Stack

* Backend: Laravel (PHP)
* Frontend: Blade, HTML, CSS, JavaScript
* Database: MySQL
* Version Control: Git & GitHub

---

## 📱 Responsive Design

The application is fully responsive and works on desktop and mobile devices.

---

## ⚠️ Important Notes

* The platform does NOT provide compatibility checking between components
* No automatic product recommendations
* Users are responsible for their own configuration choices

---

## 📊 Project Status

✔ Core features completed
✔ CDC (Cahier des Charges) requirements respected
✔ Additional features implemented (vendor system, order tracking)

---

## 🧑‍💻 Author

* Ayoub Amine (Parlog)

---

## 📎 License

This project is for educational purposes.
