To run database : 

docker compose up -d

symfony console doctrine:migrations:migrate

To use symfony with the docker database easily, use symfony console [your command] instead of php bin/console [your command]

To find out the port on your local machine used to communicate with the mysql database , run this command: 

docker ps

Then find the database container, and you should see the port 3306 associated with another random port, let's say 32773.

Then you can run commands like mysql -u root --password=password --host=127.0.0.1 --port=32773 (only if you have mysql on local machine)

Or you can do (you don't need mysql on your machine for this command) : 

docker-compose exec database mysql -u root --password=password
