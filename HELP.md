# HELP MEMO

composer install

php -S 127.0.0.1:8000 -t public

git add --all && git commit -m 'description'

git push origin name_branch

git checkout master

git branch -d name_branch

<!-- pour forcer le delete -->
git branch -D name_branch

git pull origin master

<!-- git clone https://github.com/KStevenWF3/sc-blog/*.git -->

php bin/console doctrine:schema:update --force

!! SYSTEMATIQUE QUAND ON RECUPERE LE PROJET DE QUELQU'UN (pour la strucute de la BDD)

php bin/console d:s:u -f

php bin/console d:f:l -q ajouter les fixture