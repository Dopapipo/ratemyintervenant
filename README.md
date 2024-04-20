# Bienvenue dans notre Projet Symfony : RATE MY INTERVENANT !

## Membres de l'équipe

- JACOB Romain **(PO)**
- LISNIC Lucian 
- BOULZE Noam
- GROSSMAN Abel


## Etapes pour lancer le projet correctement : 

_STEP 1_ 

```
 composer require --dev orm-fixtures
```
 
_STEP 2_ 

```
composer install 
```

_STEP 3_ 

```
docker compose up -d
```

_STEP 4_ 

```
symfony console doctrine:schema:update -f
```

_STEP 5_ 

```
symfony console doctrine:fixtures:load --purge-with-truncate --purger=mysql_purger 
```

_STEP 6_ 

```
symfony serve -d
```
BONUS : Si le style du dashboard admin n'apparait pas :

```
php bin/console assets:install
```

La commande 5 est une commande pour load les fixtures et des utilisateurs par défaut associés à chaque classe (une utilisateur, une classe): 
Vous pouvez désormais vous connecter et accéder au menu:
  
admin1 (Admin) -id: admin1, pwd: admin1
L3Class (User) -id: L3Class, pwd: L3Class
L3App (User) -id: L3App, pwd: L3App
M1G1 (User) -id: M1G1, pwd: M1G1
M1G2 (User) -id: M1G2, pwd: M1G2
M2G1 (User) -id: M2G1, pwd: M2G1
M2G2 (User) -id: M2G2, pwd: M2G2


## Fonctionnalités
Utilisateur:
- Se connecter et créer un compte
- Envoyer un mail lors de l'inscription et pour l'oubli de mot de passe
- Modifier ses informations personnelles
- Modifier mot de passe
- Voir toutes les reviews des élèves
- Liker/disliker une review
- Voir tous les intervenants de sa classe
- Voir le profil d'un intervenant et toutes ses reviews
- Faire une review d'un intervenant de sa classe
- Modifier ou supprimer sa review
- Envoyer un formulaire de contacte

Admin:
- CRUD classe
- CRUD matière
- CRUD intervenant
- CRUD review
- CRUD utilisateur 
- Bannir utilisateur
- Lire un formulaire de contacte


## Documentation du projet:

- Les technologies utilisées pour ce projet: 
local: symfony, composer.
docker: BDD mysql, maildev, adminer. (à venir: composer php, phpunit, xdebug)

- Les langages et utilisés pour ce projet: 
php, twig, CSS, JaveScript, DQL.

- Les librairies externes: 
bootstrap pour le CSS, Zenstruck Foundry pour générer des fixtures.


## Diagramme de classe (à lancer sur PlantUML):

Diagramme de classe:

![image](https://github.com/Dopapipo/ratemyintervenant/assets/123425704/d20f65f7-ad2a-4162-92f5-a76f9963274e)


