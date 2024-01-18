PHP RESTful API
This repository provides a comprehensive PHP-based solution for utilizing REST APIs and building your own RESTful API using plain PHP.
The kit includes features such as API key and JWT token authentication, all encapsulated within a Docker environment for easy deployment and scalability.

### Prerequisites
Before you begin, make sure you have the following prerequisites installed on your local machine:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)


Getting Started
Follow these steps to get started with the PHP RESTful API Starter Kit:

Clone this repository to your local machine:

bash
Copy code
https://github.com/AlxRdnvc/RESTful-API.git

Navigate to the project directory and build and run the Docker containers:

bash
Copy code
docker-compose up -d

Access your API at http://localhost:9000 and start exploring the provided examples and documentation.
Access PHPMyAdmin at http://localhost:9001 for database management.
Login with the MySQL root credentials configured in the Docker Compose file.


The Docker environment includes the following services:

PHP with Apache
MySQL
PHPMyAdmin for database management

Stop Docker Containers:

bash
Copy code
docker-compose down

If facing error after adding .htaccess file enable rewriting:

bash
Copy code
docker exec -it restful-api_php-apache-environment_1 a2enmod rewrite
docker restart restful-api_php-apache-environment_1


These instructions provide a step-by-step guide for cloning the repository, setting up the Docker environment, and accessing the PHP, Apache, MySQL, and PHPMyAdmin services.
Users can then proceed with using and customizing the PHP RESTful API Starter Kit for their projects.