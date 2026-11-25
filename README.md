# Local Tourist Day-Visit Planner & Information System

A complete PHP + MySQL + Bootstrap + JavaScript + Google Map web application inspired by the supplied UI image.

## Technology
- PHP 8+
- MySQL / MariaDB
- HTML5 / CSS3
- Bootstrap 5
- JavaScript
- Google Map

## Main features
- Responsive home page
- Tourist attraction cards
- Attraction details
- Interactive map
- 25 km radius filter around Gelioya
- One-day itinerary generator
- Travel tips
- About page
- Admin login
- Admin CRUD for attractions
- Image URL management
- Search and category filtering

## XAMPP setup

1. Install XAMPP.
2. Start Apache and MySQL.
3. Copy this folder into:
   `C:\xampp\htdocs\local_tourist_planner`
4. Open phpMyAdmin:
   `http://localhost/phpmyadmin`
5. Create/import the database using:
   `database.sql`
6. Open:
   `http://localhost/local_tourist_planner/`

## Admin login

- URL: `http://localhost/local_tourist_planner/admin/login.php`
- Email: `admin@touristplanner.local`
- Password: `admin123`

Change the password before using the application outside a local demo.

## Important
The sample attraction image URLs use Unsplash image URLs. Internet access is therefore needed for those remote images. You can replace the URLs in the `attractions` table with your own local image paths.

The map uses Leaflet and OpenStreetMap through CDN resources.
