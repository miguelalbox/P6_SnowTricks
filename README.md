# P6_SnowTricks

Processus d'installation.

Tout d'habord vous devez vous positionner sur la branche dev dé projet.

Une fois vous y êtes, vous téléchargez le projet puis dans le terminal vous lancer la commande composer install, grace à composer vous aller installer tous les dépendances qui le projet a besoin.


Après avoir installé cela, vous devez créer un utilisateur en base de données puis  vous devez configurer le fichier .env pour paramétrer la connexion a la base de données.

une fois le paramétrage fait il faut jouer la commande: php bin/console d:m:m qui va permettre des créer tous les tables et colonnes en base de données.

"Attention si vous avez déjà une base de données emportée sans jouer la commande."

Démarrer le serveur, jouer la commande: symfony serve -d puis rentré sur le site.