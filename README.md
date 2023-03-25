# Twiimter

> ⚠️ NOTE: Ce projet reprends du code de mon [projet d'axe](https://github.com/Kan-A-Pesh/school-IIMersive), il est donc moins complet que celui-ci.

## 📖 À propos

TwIIMter est un projet de réseau social, inspiré de Twitter, réalisé dans le cadre scolaire.

Le projet est réalisé en PHP, HTML, CSS et JS.\
Il utilise une base de données MySQL et est hébergé sur un serveur Apache.

## 📝 Fonctionnalités

- [x] Créer un compte
- [x] Se connecter
- [x] Se déconnecter
- [ ] Modifier son profil
- [x] Voir un profil
- [ ] Voir la liste des utilisateurs
- [ ] Voir les tweets
- [ ] Ajouter un tweet
- [ ] Supprimer un tweet
- [ ] Rechercher un tweet
- [ ] Séparer les actions dans des pages différentes (delete.php, edit.php, etc.)

## ⚡️ Installation

Pour installer le projet, il vous suffit de cloner le dépôt Git puis de lancer le projet depuis Docker.

```bash
docker-compose up -d
```

Le projet est ensuite accessible à l'adresse `http://localhost:8080/`, il inclut un serveur MySQL et un serveur PHPMyAdmin disponible à l'adresse `http://localhost:8081/`.

## 📜 Documentation

[MEDIA.md](media/MEDIA.md) : Fonctionnement du système de médias
[TODO.md](docs/TODO.md) : Liste des tâches à faire
[LICENSE](LICENSE) : Licence du projet (MIT)

## 📂 Structure du projet

- `api/` : Contient les contrôleurs, modèles et middlewares
- `conf/` : Contient le fichier de configuration d'Apache
- `docs/` : Contient la documentation du projet
- `media/` : Contient les médias du projet
- `templates/` : Contient les composants PHP utilisés pour le rendu des pages
- `www/` : Contient les fichiers du site
- `.htaccess` : Fichier d'Apache pour la redirection des requêtes
- `docker-compose.yml` : Fichier de configuration de Docker
- `Dockerfile` : Fichier de configuration de Docker (PHP:Apache)
- `README.md` : Fichier de présentation du projet (ce fichier)

## 📚 Stack technique

- [PHP](https://www.php.net/) : Langage de programmation utilisé pour le backend
- [MySQL](https://www.mysql.com/fr/) : Base de données utilisée pour le stockage des données
- [Apache](https://httpd.apache.org/) : Serveur web utilisé pour le serveur web
- [Docker](https://www.docker.com/) : Utilisé pour l'hébergement du projet
- [PHPMyAdmin](https://www.phpmyadmin.net/) : Utilisé pour l'administration de la base de données

## 📝 License

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus d'informations.
