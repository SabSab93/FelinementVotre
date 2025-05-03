# FélinementVôôtre 😻

> Et si nos félins aussi avaient droit à l'amour ?

On connaît tous ces sites de rencontre pour humains : Tinder, Meetic, Adopte un mec…  
Et pourtant, nos chers chats n’ont jamais eu leur chance pour trouver un compagnon à ronronner !

Après des années de réflexion (et quelques miaulements), je vous présente **FélinementVôôtre** :  
le site de rencontre pour nos matous d’amour !

Ici, chaque félin peut :
- parcourir des profils de congénères  
- swiper pour matcher selon ses préférences  
- et peut-être trouver son âme sœur pour faire vibrer son petit cœur de chat !

Avec **FélinementVôôtre**, rencontre ton félin près de chez toi… grrrrrr 🐾

---

## 🚀 Initialisation du projet

1. **Récupération du code**  
   ```bash
   git clone git@serveur:User/FelinementVotre.git
   cd FelinementVotre
   ```

2. **Installation des dépendances PHP**  
   ```bash
   composer install
   ```

3. **Configuration de l’environnement**  
   ```bash
   cp .env .env.local
   ```
   Puis, ouvre `.env.local` et ajuste la variable `DATABASE_URL` (hôte, port, utilisateur, mot de passe, nom de la DB).

---

## 🐾 Génération des données

4. **Création de la base de données**  
   ```bash
   php bin/console doctrine:database:create
   ```

5. **Mise à jour du schéma ou exécution des migrations**  
   - **Avec migrations Doctrine**  
     ```bash
     php bin/console doctrine:migrations:migrate --no-interaction
     ```
   - **Sans migrations**  
     ```bash
     php bin/console doctrine:schema:update --force
     ```

6. **Chargement des fixtures**  
   (purge et réinjection des données de test)  
   ```bash
   php bin/console doctrine:fixtures:load --purge-with-delete --no-interaction
   ```

---

## 🎨 Assets & cache

7. **(Facultatif) Compilation des assets**  
   *Si vous utilisez Webpack Encore pour vos JS/CSS*  
   ```bash
   npm install    # ou yarn install
   npm run dev    # ou yarn encore dev
   ```

8. **Vider / rafraîchir le cache Symfony**  
   ```bash
   php bin/console cache:clear
   ```

---

## ▶️ Lancement du serveur

9. **Démarrer le serveur de développement**  
   ```bash
   symfony server:start
   ```

10. **Accéder à l’application**  
    > http://127.0.0.1:8000

---

> **FélinementVôôtre** – le premier site de rencontre pensé pour nos matous !  
> Bonne découverte et… longue vie aux ronrons !
