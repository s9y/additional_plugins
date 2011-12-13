<?php

@define('PLUGIN_ADDUSER_NAME', 'Auto-enregistrement des utilisateurs');
@define('PLUGIN_ADDUSER_DESC', 'Permettre aux visiteurs du blog de créer leur propre compte utilisateur. En conjonction avec le plugin d\'évènement (index.php?serendipity[subpage]=adduser), vous pouvez décider de n\'autoriser que les utilisateurs enregistrés à poster des commentaires.');
@define('PLUGIN_ADDUSER_INSTRUCTIONS', 'Instructions complémentaires');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DESC', 'Ajoutez ici quelques instructions qui apparaîtront dans le formulaire d\'enregistrement');
@define('PLUGIN_ADDUSER_INSTRUCTIONS_DEFAULT', 'Ici, vous pouvez vous enregistrer comme auteur de ce blog. Entrez simplement les informations demandées, validez le formulaire et vous recevrez des instructions complémentaires par email.');
@define('PLUGIN_ADDUSER_USERLEVEL', 'Niveau d\'accès par défaut');
@define('PLUGIN_ADDUSER_USERLEVEL_DESC', 'Choisissez le Niveau d\'accès par défaut des nouveaux utilisateurs.');
@define('PLUGIN_ADDUSER_USERLEVEL_CHIEF', 'Chef');
@define('PLUGIN_ADDUSER_USERLEVEL_EDITOR', 'Éditeur');
@define('PLUGIN_ADDUSER_USERLEVEL_ADMIN', 'Administrateur');
@define('PLUGIN_ADDUSER_USERLEVEL_DENY', 'Accès refusé');
@define('PLUGIN_SIDEBAR_LOGIN', 'Affiche le formulaire d\'enregistrement dans la barre latérale ?');
@define('PLUGIN_SIDEBAR_LOGIN_DESC', 'Si la valeur "oui" est sélectionnée, un formulaire d\'enregistrement sera affiché dans la barre latérale. Sinon, vos utilisateurs devront s\'enregistrer dans une page spéciale définie dans le plugin d\'événement correspondant.');
        
@define('PLUGIN_ADDUSER_EXISTS', 'Désolé, le nom d\'utilisateur "%s" est déjà utilisé. Merci d\'en choisir un autre.');
@define('PLUGIN_ADDUSER_MISSING', 'Vous devez saisir tous les champs pour créer un compte utilisateur.');
@define('PLUGIN_ADDUSER_SENTMAIL', 'Votre compte a été créé. Vous recevrez prochainement par email toutes les informations complémentaires nécessaires à son utilisation.');
@define('PLUGIN_ADDUSER_WRONG_ACTIVATION', 'L\'URL d\'activation que vous avez utilisée n\est pas valide !');

@define('PLUGIN_ADDUSER_MAIL_SUBJECT', 'Un nouveau compte utilisateur a été créé.');
@define('PLUGIN_ADDUSER_MAIL_BODY', "Un compte a été créé pour l'\utilisateur %s sur le Blog %s. Pour activer ce compte, merci de cliquer sur le lien ci-dessous:\n\n%s\n\nUne fois ceci fait, vous pourrez vous connecter en utilisant le mot de passe choisi. Cet email a été envoyé au nouvel utilisateur et au propriétaire du blog.");
@define('PLUGIN_ADDUSER_SUCCEED', 'Le compte utilisateur a été créé avec succès. Vous pouvez vous connecter au panneau d\administration de ce blog en cliquant sur le lien fourni dans l\'email d\'activation.');
@define('PLUGIN_ADDUSER_FAILED', 'Le compte utilisateur n\'a pas pu être créé. Peut-être n\'avez-vous pas recopié la bonne URL dans l\'email d\'activation ?');

@define('PLUGIN_ADDUSER_REGISTERED_ONLY', 'Seuls les utilisateurs enregistrés peuvent poster des commentaires ?');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_DESC', 'Si la valeur "oui" est sélectionnée, seuls les utilisateurs enregistrés et connectés pourront poster des commentaires aux billets de ce blog.');
@define('PLUGIN_ADDUSER_REGISTERED_ONLY_REASON', 'Seuls les utilisateurs enregistrés peuvent poster des commentaires sur ce blog. Créez votre compte <a href="%s">ici</a>, puis <a href="%s">connectez-vous</a>. Votre navigateur doit accepter les cookies.');

@define('PLUGIN_ADDUSER_SERENDIPITY09', 'Serendipity 0.9 est obligatoire pour cette option.');
@define('PLUGIN_ADDUSER_STRAIGHT', 'Insertion immédiate ?');
@define('PLUGIN_ADDUSER_STRAIGHT_DESC', 'Si la valeur "oui" est sélectionnée, un utilisateur sera immédiatement enregistré comme valide. Il est recommandé de n\'utiliser cette option que si aucun serveur d\'email n\'est disponible. Des spammeurs peuvent se servir de cette option. Ne l\'utilisez que si vous savez ce que vous faites !');

@define('PLUGIN_ADDUSER_REGISTERED_CHECK', 'Prévention des usurpations d\'identité');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_DESC', 'Si la valeur "oui" est sélectionnée, les noms d\'utilisateurs enregistrés ne pourront être utilisés que par ceux qui sont connectés en tant qu\'utilisateur.');
@define('PLUGIN_ADDUSER_REGISTERED_CHECK_REASON', 'Le nom d\'utilisateur que vous essayez d\'utiliser est réservé à un utilisateur enregistré. Merci de vous <a href="%s" %s>connecter</a> pour poster un commentaire en utilisant ce nom. Si vous n\'êtes pas un utilisateur enregistré, merci d\'utiliser un nom différent.');

?>