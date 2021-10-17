## 🚀&nbsp; Installation and Documentation
Installez le projet via Git puis allez dans le dossier

Faite un fichier .env.local avec vos informations de base de donnée.

Ensuite executez ces commandes :
```bash
composer install
yarn install
yarn build
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php -S 127.0.0.1:8000 -t public
```

## Environnement de développement

Si vous êtes dans un environnement de développement vous pouvez utiliser la commande en parallel des autres :
```bash
yarn run dev-server
```