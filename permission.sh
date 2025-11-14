#!/bin/bash

echo ">> Création du groupe webgroup si non existant..."
sudo groupadd -f webgroup

echo ">> Ajout de dgsr et www-data au groupe webgroup..."
sudo usermod -aG webgroup dgsr
sudo usermod -aG webgroup www-data

echo ">> Changement du groupe du dossier /home/dgsr/Appointment..."
sudo chgrp -R webgroup /home/dgsr/Appointment

echo ">> Attribution des permissions 775 pour le groupe..."
sudo chmod -R 777 /home/dgsr/Appointment

echo ">> Activation du setgid sur les répertoires pour hériter du groupe..."
sudo find /home/dgsr/Appointment -type d -exec chmod g+s {} \;

echo ">> Vérification des permissions sur les dossiers Symfony essentiels..."
sudo chmod -R 777 /home/dgsr/Appointment/var /home/dgsr/Appointment/public

echo ">> Redémarrage d'Apache..."
sudo systemctl restart apache2

echo "✅ Configuration terminée."
