To run database : 

docker compose up -d

 symfony console doctrine:schema:update --force

symfony console doctrine:migrations:migrate

symfony console doctrine:fixtures:load --purge-with-truncate --purger=mysql_purger

To use symfony with the docker database easily, use symfony console [your command] instead of php bin/console [your command]

To find out the port on your local machine used to communicate with the mysql database , run this command: 

docker ps

Then find the database container, and you should see the port 3306 associated with another random port, let's say 32773.

Then you can run commands like mysql -u root --password=password --host=127.0.0.1 --port=32773 (only if you have mysql on local machine)

Or you can do (you don't need mysql on your machine for this command) : 

docker-compose exec database mysql -u root --password=password




Documentation Rate My Intervenant:

Les technologies utilisées pour ce projet: symfony, docker, git.

Les langages et utilisés pour ce projet: php, twig, CSS, JaveScript, MySQL.

Les librairies externes: bootstrap.

Diagramme de classe: 
Code PlantUML:
@startuml

class User {
  +id: int
  -username: String
  -password: String
  -firstName: String
  -lastName: String
  -email: String
}

class Classe {
  +id: int
  -name: String
}

class ResetPasswordRequest {
  +id: int
  -oid: int
  -selector: String
  -hashedToken: String
  -requestedAt: datetime
  -expiresAt: datetime
}

class Review {
  +id: int
  -content: String
  -grade: int
}

class Matiere {
  +id: int
}

class Intervenant {
  +id: int
  -name: String
}

User "1-1" -- "0-N" Review : publie >
User "1-1" -- "0-N" ResetPasswordRequest : demande >
User "1-N" -- "1-N" Matiere: assiste >
Intervenant "1-N" -- "1-N" Classe : intervient >
Intervenant "1-N" -- "1-N" Matiere : intervient >
Classe "1-1" -- "1-N" User : comporte >
Review "0-N" -- "1-1" Intervenant: concerne >

@enduml


