# Project name
    Mini POS System

# Project description
  Build a mini Point of Sale (POS) backend system using Laravel. The system should support the following:

• Products: Add products with support for image and video uploads.
• Media Compression: Compress uploaded images and videos to optimize storage and
delivery.
• API: Expose RESTful APIs for product creation, listing, and order placement.
• Payment: Integrate Stripe for product purchases. Demonstrate handling of payment
flow, success, and failure.
• Security: Sanitize input and secure media and payment endpoints.
• Clean Code: Ensure your code is clean, readable, and properly structured.

Bonus:
• Implement authentication for admin endpoints.
• Add search functionality for products.

# Tool choices and design decisions
  - Laravel 12
  - MySQL
  - Docker

# Setup instructions
  - You will need to have docker installed on your machine as this project is dockerized

  - Clone project to your device

  - run inside the project
  `` docker compose up --build -d ``

  - run 
  `` docker exec -it pos_app bash ``

  - For simplicty, you just need to copy env.sample and name it .env

  - Then run
  `` composer install ``
  `` php artisan migrate ``
  `` php artisan db:seed ``
  `` php artisan storage:link ``

  - Open browser
  [http://localhost:8000]

  - To try stripe payment, please add your stripe client secret key value in .env for the key 'STRIPE_CLIENT_SECRET'
  