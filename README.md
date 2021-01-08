# Présentation TP Blog - Josué Vidrequin

Ce TP est un Blog. 

## Fonctionnalités : 

Il y a 3 Rôles utilisateurs 

- Administrateur 
- Lecteur 
- Editeur 


### Les fonctionnalités possibles 
- Un administrateur peut donner les droits d'accès aux différents utilisateurs. Peut consulter, éditer et modifier les articles et les catégories. Il peut également commenter les articles. 

- Un lecteur peut consulter les articles. 
- Un Editeur peut créer un article, créer une catégorie, Mettre des commentaires sur les articles. 

## Version


Php : 
```bash
PHP 7.3.22
```

Yarn : 
```bash
Yarn 1.22.10
```




## Installation

Pour lancer le projet il faut installer NodeJS et Yarn. 
Lancer les Fixtures : 
```bash
php bin/console doctrine:fixtures:load
```
```bash
yes 
```
Il faut également, lors de la Première utilisation, s'inscrire et dans PhpMyAdmin changer le rôle de l'utilisateur pour avoir accès à l'ensemble des fonctionnalités.

```bash
[] et mettre ["ROLE_ADMIN"]
```
Le nom de la base de donnée : 
```sql
BlogDataBase
```



## Liens CSS 
Pour le Blog
```bash
https://www.free-css.com/free-css-templates/page244/markedia
```


## License
Josué Vidrequin FISA 3 INSA Hauts-De-France 
