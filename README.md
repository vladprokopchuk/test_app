# Web App test task 

----
# Installation of Web App

1. Install Docker desktop on your work computer
2. Clone this repository on you computer
2. Open Terminal app
3. ```cd web-app/src```
4. ```docker compose build```
5. ```docker compose up -d```
6. Go to ```localhost:8080``` and ensure web server is working
7. Use PHP container as main application container
---
# Tasks

1. **<span style="color:#4dbf71">Complete the installation of Dockerized  Web application:</span>**
   - <span style="color:#8aeba9">Add MySQL or PostgreSQL container into docker compose</span>
   - <span style="color:#8aeba9">Install latest Symfony framework with all dependencies into PHP container using Composer</span>
   - <span style="color:#8aeba9">Ensure default Symfony web page  is working</span>
   - <span style="color:#8aeba9">Connect Symfony framework to database using Doctrine ORM and ensure connection is working</span>
2. **<span style="color:#4dbf71">Create Web App for managing Persons in Houses</span>**
   - <span style="color:#8aeba9">Use Doctrine ORM as main entity management instrument</span>
   - <span style="color:#8aeba9">Create main entities with corresponding fields:</span>
     - <span style="color:#5c8bc4">Person</span>
       - **id** 
       - **name**
       - **last name**
       - **birthdate**
       - **personal ID number**
         - is unique alphanumeric string 
         - is it not primary key
     - <span style="color:#b974d4">Apartment</span>
       - **id** 
       - **number**
         - non-unique
     - <span style="color:#d9ce7c">House</span>
       - **id** 
       - **number**
         - non-unique
       - **street name**
         - non-unique word string

3. **<span style="color:#4dbf71">Assign field types accordingly to your choice</span>**
4. **<span style="color:#4dbf71">Create corresponding relations according to this business logic</span>**
   - <span style="color:#8aeba9">"Multiple Persons can live in one Apartment"</span>
   - <span style="color:#8aeba9">"One unique Person can live only in one Apartment"</span>
   - <span style="color:#8aeba9">"Person cannot live without an Apartment"</span>
   - <span style="color:#8aeba9">"House can have multiple apartments"</span>
   - <span style="color:#8aeba9">"House can exist with no Apartments"</span>
   - <span style="color:#8aeba9">"One unique Apartment can belong to one House. 
   - <span style="color:#8aeba9">"There can be no Apartments without a House"</span>

5. **<span style="color:#4dbf71">Create correct HTTP API to process data from database</span>**
   - <span style="color:#8aeba9">Data should be passed through API using application/json mimetype</span>
   - <span style="color:#8aeba9">Create API endpoint to create a Person</span>
   - <span style="color:#8aeba9">Create API endpoint to create an Apartment</span>
   - <span style="color:#8aeba9">Create API endpoint to create a House</span>
   - <span style="color:#8aeba9">Create API endpoint to retrieve list of Persons</span>
     - Make a possibility to **filter** Persons by:
       - **name** - search by full match
       - **last name** - search by substring match
       - **birthdate** - in form of datetime range
       - **personal ID number** - search by full match
       - **apartment number** - full match
       - **house number** - full match
       - **street name** - search by substring match
     - Make result of Persons list _paginated_
     - Display all the fields in Person row
     - Add fields that display **house number, apartment number, street name**
   - <span style="color:#8aeba9">Create API endpoint to retrieve list of Apartments</span>
     - Make a possibility to **filter** Apartments by:
       - **number** - search by full match
       - **street name** - search by substring match
       - **person name or person last name** - search by substring match
       - Make result of Apartments list **paginated**
     - Display **all the fields** in Apartment row
     - Display **additional collection field with all the Persons** that are living in this house
       - for each **Person row** display all the **Person fields and apartment number**

6. **<span style="color:#4dbf71">If you need any other entities, tables or fields to complete the task - feel free to add it, but explain your decision</span>**
7. **<span style="color:#4dbf71">While coding, you can use these libraries:</span>**
    - <span style="color:#8aeba9">Symfony components</span>
    - <span style="color:#8aeba9">Doctrine ORM</span>
8. **<span style="color:#4dbf71">While coding, you should show expertise in next technologies and design patterns</span>**
    - <span style="color:#8aeba9">Docker</span> 
    - <span style="color:#8aeba9">Relations databases</span>
    - <span style="color:#8aeba9">Symfony framework</span>
    - <span style="color:#8aeba9">HTTP</span>
    - <span style="color:#8aeba9">Relational databases</span>
    - <span style="color:#8aeba9">SOLID</span>
    - <span style="color:#8aeba9">CQRS</span>
    - <span style="color:#8aeba9">DI container</span>
    - <span style="color:#8aeba9">Factory</span>
    - <span style="color:#8aeba9">Strategy</span>
    - <span style="color:#8aeba9">Registry</span>
9. **<span style="color:#4dbf71">If you didn't work with Symfony framework or any of technologies above: your ability to learn new subject matter will be considered</span>**
10. **<span style="color:#4dbf71">Check the functional work of above business logic, make sure it is working correctly</span>**
11. **<span style="color:#4dbf71">Present a finished app in a form of public Git repository</span>**
12. **<span style="color:#4dbf71">Add all the necessary instructions to php-fpm Dockerfile to launch this web app from scratch on other work machine - it should work on any other machine that supports Docker</span>**
13. **<span style="color:#4dbf71">If your project requires any explanations or additional instructions to launch a project - add those instructions as new sections below</span>**

# Installation APP

1. **<span style="color:#4dbf71">Clone repository:</span>**
3. **<span style="color:#4dbf71">Copy /src/.env.example file to /src/.env </span>**
4. **<span style="color:#4dbf71">run docker compose up </span>**
5. **<span style="color:#4dbf71">run composer install inside php-fpm container</span>**
6. **<span style="color:#4dbf71">run bin/console make:migration inside php-fpm container</span>**
7. **<span style="color:#4dbf71">run bin/console doctrine:migrations:migrate inside php-fpm container</span>**
8. **<span style="color:#4dbf71">run docker compose down </span>**
9. **<span style="color:#4dbf71">run docker compose build  </span>**
10. **<span style="color:#4dbf71">run docker compose up -d  </span>**
11. **<span style="color:#4dbf71">To test API use /postman_api_collection.json to import API collection to Postman and then test api endpoints  </span>**
