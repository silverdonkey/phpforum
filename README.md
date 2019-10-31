# phpforum

php based forum

# Dev Environment
Start Docker Container (to rebuild use '--build' option):
- docker-compose up -d
- docker-compose up --build -d

Stop Docker Containter 
The docker-entrypoint-initdb.d folder will only be run once 
while the container is created (instantiated) so you actually 
have to do a docker-compose down -v to re-activate this for the next run.
- docker-compose down

# Init Databse 
Use init script
- Run database-init.sql 