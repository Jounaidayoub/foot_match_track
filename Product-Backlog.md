ROLE: VISITEUR
===
#### User storie
_"En tant que visiteur, je veux consulter les résultats des matchs, les classements des équipes et les calendriers des tournois sans créer de compte, afin de découvrir rapidement les informations sans engagement."_
#### Criteres d'acception
- [ ] Page des matchs triés par date
- [ ] 2 Pages de résultats de tournois, contenant le classement des équipes
- [ ] Page de résultats d'équipe
- [ ] Page des joueurs
- [ ] Page des équipes

#### User storie
_"En tant qu'utilisateur standard, je veux souscrire à un abonnement premium, afin d’accéder à des statistiques exclusives et recevoir des notifications sur les match prochains."_
#### Criteres d'acception
- [ ] Page d'inscription premium
- [ ] Après paiement, l’utilisateur voit un badge "Premium" sur son profil.

UTILISATEUR PREMIUM
===
#### User storie
_"En tant qu'utilisateur premium, je veux suivre mes équipes et joueurs favoris, afin de recevoir des notifications push en temps réel pour leurs matchs, transferts ou blessures."_
#### Criteres d'acception
- [ ] Un bouton "♥ Suivre" est présent sur les pages équipe/joueur.
- [ ] Une page de notifications 

#### User storie
_"En tant qu'utilisateur premium, je veux créer des sondages prédictifs (ex: "Qui gagnera le prochain match ?"), afin de partager mes pronostics et comparer mes résultats avec ceux de la communauté."_
#### Criteres d'acception
- [ ] Une sidebar de sondage present dans chaque match 

#### User storie
_"En tant qu' utilisateur premium
je veux écrire mon avis à propos du match dans un espace dédié au discussions
afin d’échanger avec d’autres fans et partager mes réactions"_
#### Criteres d'acception
- [ ] Un footer contenant les messages des utilisateurs ainsi qu' un formulaire pour envoyer un message
- [ ] L'envoie de message ne recharge pas la page
- [ ] Les messages sont synchronisés (pas besoin de recharger la page pour recevoir les nouveaux messages)

ADMIN GENERAL
===
#### User storie
_"En tant qu’admin général, je veux créer des comptes admin tournoi avec des permissions spécifiques, afin de déléguer la gestion des tournois sans donner accès à l’ensemble de l’application."_
#### Criteres d'acception

- [ ] Un formulaire de création d’admin tournoi inclut un email, selection du tournoi à assigner, et les permissions à donner (_Créer/modifier/supprimer des matchs_, _Gérer les équipes_) 
- [ ] Un email de confirmation avec un lien de connexion est envoyé au nouvel admin.

ADMIN TOURNOIS
===
#### User storie
_"En tant qu’admin tournoi, je veux programmer des matchs (date, heure, lieu), afin d’organiser le calendrier du tournoi de manière claire pour les participants."_
#### Criteres d'acception
- [ ] Sélection des équipes (liste déroulante liée au tournoi).
- [ ] Date et heure avec vérification des conflits (pas deux matchs au même lieu en même temps).
#### User storie
_"En tant qu’admin tournoi, je veux saisir les résultats des matchs (score, cartons rouges/jaunes), afin de maintenir les classements à jour."_
#### Criteres d'acception
- [ ] Sur la page d’un match, un formulaire permet de renseigner :
    - Score final (ex: 2-1).
    - Événements (buts, cartons, remplacements) avec minutage.
    - Option _"Valider définitivement"_ (bloque les modifications après validation).
- [ ] Les classements sont recalculés automatiquement après validation.
#### User storie
_"En tant qu’admin tournoi, je veux envoyer des notifications aux équipes (changements d’horaire, documents requis), afin de garantir le bon déroulement du tournoi."_
