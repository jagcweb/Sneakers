# Sneakers

https://sneakers7.000webhostapp.com/

**Sneakers** is a project based on what would be a sneakers store in the digital market.

This repository is made up of all the application files including controllers, models, routes and views.

This application is made up of numerous and diverse tables:

![alt text](https://i.imgur.com/duE7ts4.png)

- **Migrations:** Includes application migrations.

- **Regions:**  Includes all the autonomous communities of Spain

- **Categories:**  Includes all product categories.

- **Products:**  Includes all products registered on the web for sale.

- **Product_Images:**  Includes all images of each product.

- **Childs:**  This table determines if the product we are saving is for children or not.

- **Stocks:**  This table determines the amount of stock of a product and its size.

- **Cart_Items:**  These are the items that we add to the shopping cart.

- **Users:**  All users of the application. When registering a user by default his role will be "user".

- Addresses:**  Includes all addresses of each user.

- **Orders:**  Includes the orders of each user. Completed, Canceled and Pending.

- **Order_Items:** This table includes all the products of each order.

-----------------------------------------------------------------------------------------------------------

**Libraries:

- **AOS:** This library has been used for the effects of "loading" the elements of the application.

- **Lazyload:** This library has been added to optimize the Lazy of the images.

- **Mail:** This library has been used to send messages to the user when an order has been made with the order information itself, in addition to sending the emails to the web admin with the contact forms.

- **Stripe:** This library has been added to make payments when confirming an order. As this application is not a real store but rather a fictitious store, it will be configured in testing mode.

-----------------------------------------------------------------------------------------------------------

**Dependencies:

- Xamppp with PHP 8
- MySQL
- Composer 2.0
- Laravel 8
