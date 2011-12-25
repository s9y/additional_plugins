<?php # $Id$

# (c) 2009 by remundia , http://www.remundia.com, <http://www.remundia.com>

# french language file

/**
 *  @version $Revision$
 *  @author Translator Name <contact@remundia.com>
 *  FR-Revision: Revision of lang_fr.inc.php
 */

@define("PLUGIN_FORUM_TITLE", "Forum de discussion / phpBB mirroring des commentaires");
@define("PLUGIN_FORUM_DESC", "proposer un veritable forum a vos utilisateurs. Peut aussi permettre de mettre PHPBB en miroir pour les commentaires.");
@define('PLUGIN_FORUM_PAGETITLE', 'Titre de la page');
@define('PLUGIN_FORUM_PAGETITLE_BLAHBLAH', 'title of the page');
@define('PLUGIN_FORUM_HEADLINE', 'Entete');
@define('PLUGIN_FORUM_HEADLINE_BLAHBLAH', 'Entete de la page page.');
@define('PLUGIN_FORUM_PAGEURL', 'Url statique');
@define('PLUGIN_FORUM_PAGEURL_BLAHBLAH', 'Definir l\'url de la page (index.php?serendipity[subpage]=name)');
@define("PLUGIN_FORUM_UPLOADDIR", "Lien absolut du serveur pour le repertoire");
@define("PLUGIN_FORUM_UPLOADDIR_BLAHBLAH", "default: ".$serendipity['serendipityPath'].'files');
@define("PLUGIN_FORUM_DATEFORMAT", "Le format actuel de la date d'un message utilise le format date() de php.(Par defaut: \"Y/m/d\")");
@define("PLUGIN_FORUM_TIMEFORMAT", "Format de l'heure");
@define("PLUGIN_FORUM_TIMEFORMAT_BLAHBLAH", "Le format actuel de l'heure d'un message utilise le format date() de php.(Par defaut: \"h:ia\")");
@define("PLUGIN_FORUM_BGCOLOR_HEAD", "Couleur de fond de la barre de titre");
@define("PLUGIN_FORUM_BGCOLOR_HEAD_BLAHBLAH", "Couleur de fond de la barre de titre");
@define("PLUGIN_FORUM_BGCOLOR1", "couleur de fond 1");
@define("PLUGIN_FORUM_BGCOLOR2", "Couleur de fond 2");
@define("PLUGIN_FORUM_APPLY_MARKUP", "Est-ce que les markup-plugins doiventes'ils sont installes, seront utilises pour le format des messages (BBCodes, smilies, galleryimage, etc...)");
@define("PLUGIN_FORUM_ITEMSPERPAGE", "messages par page");
@define("PLUGIN_FORUM_ITEMSPERPAGE_BLAHBLAH", "Le nombre de message que vous souhaitez afficher par page  (threads/posts), par defaut: 15");
@define("PLUGIN_FORUM_USE_CAPTCHAS", "Utiliser spamblock");
@define("PLUGIN_FORUM_USE_CAPTCHAS_BLAHBLAH", "Doit-on utiliser le plugin spamblock (captchas)");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS", "Pas de markups pour les utilisateurs non enregistres");
@define("PLUGIN_FORUM_UNREG_NOMARKUPS_BLAHBLAH", "Doit-on afficher seulement les markups pour les utilisateurs enregistres?");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER", "Autoriser le telechargement de fichier pour les utilisateurs enregistres");
@define("PLUGIN_FORUM_FILEUPLOAD_REGUSER_BLAHBLAH", "Autorisers les telechargements de fichier seulement pour les utilisateurs enregistres");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST", "Autoriser le telechargement de fichier pour les visiteurs");
@define("PLUGIN_FORUM_FILEUPLOAD_GUEST_BLAHBLAH", "Autoriser le telechargement de fichier pour les utilisateurs enregistres (non recommande !!!!)");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST", "Nombre maximum de fichers telecharges dans un message");
@define("PLUGIN_FORUM_HOW_MANY_FILES_IN_ONE_POST_BLAHBLAH", "Nombre maximum de fichiers a telecharger par messages ");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING", "Nombre simultanes de fichiers a telecharger");
@define("FORUM_HOW_MANY_FILEUPLOADS_WHEN_POSTING_BLAHBLAH", "Le nombre de fichiers pouvant etres telecharges lors de l'edition ou de la modification d'un message.");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALL", "Le nombre de fichiers a telecharger par utilisateurs.");
@define("FORUM_PLUGIN_HOW_MANY_FILEUPLOADS_AT_ALLBLAHBLAH", "Combien de telechargement de fichier autoriser pour les utilisateurs enregistres.. Si cette option est active ils pourront enregistrer autant de fichiers qu'ils le souhaitent.Si cette action est active ils pourront utiliser autant de fichiers qu'ils le souhaitent!!!");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM", "Notification par mail  : adresse mail de l'expediteur");
@define("FORUM_PLUGIN_NOTIFYMAIL_FROM_BLAHBLAH", "L'adresse mail qui sera indique dans l'expediteur du mail de notification");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME", "Notiication par mail : Nom de l'expediteur");
@define("FORUM_PLUGIN_NOTIFYMAIL_NAME_BLAHBLAH", " Le nom de l'expediteur du mail de notification. Ce nom apparaitra dans le champe De: du mail.");
@define("FORUM_PLUGIN_ADMIN_NOTIFY", "Notification a l'administrateur");
@define("FORUM_PLUGIN_ADMIN_NOTIFY_BLAHBLAH", "Indique si l'administrateur doit etre informe lors de l'ajout d'un nouveau message dans le forum.");
@define("PLUGIN_FORUM_COLORTODAY", "Couleur pour le texte \"Aujourd'hui\"");
@define("PLUGIN_FORUM_COLORYESTERDAY", "Couleur pour le texte \"Hier\"");


@define("PLUGIN_FORUM_NO_BOARDS", "Pas de forums indiques");
@define("PLUGIN_FORUM_NO_ENTRIES", "Pas de messages");
@define("PLUGIN_FORUM_BOARDS", "Forums");
@define("PLUGIN_FORUM_THREADS", "Nb.de discussions");
@define("PLUGIN_FORUM_NO_THREADS", "Aucune discussion");
@define("PLUGIN_FORUM_messages", "messages");
@define("PLUGIN_FORUM_POSTS", "Messages");
@define("PLUGIN_FORUM_NO_POSTS", "Cette discussion n'a pas de messages ");
@define("PLUGIN_FORUM_LASTPOST", "Dernier message");
@define("PLUGIN_FORUM_LASTREPLY", "Derniere reponse");
@define("PLUGIN_FORUM_NO_messages", "Aucun message trouve");
@define("PLUGIN_FORUM_THREADTITLE", "Titre de la discussion");
@define("PLUGIN_FORUM_POSTTITLE", "Titre");
@define("PLUGIN_FORUM_REPLIES", "Replies");
@define("PLUGIN_FORUM_VIEWS", "Nb Affichages");
@define("PLUGIN_FORUM_NO_REPLIES", "Pas de reponses");
@define("PLUGIN_FORUM_AUTHOR", "Auteur");
@define("PLUGIN_FORUM_MESSAGE", "Message");
@define("PLUGIN_FORUM_BACKTOTOP", "Haut de page");
@define("PLUGIN_FORUM_ALT_REOPEN", "Reouvrir cette discussion..");
@define("PLUGIN_FORUM_ALT_CLOSE", "Fermer cette discussion...");
@define("PLUGIN_FORUM_ALT_MOVE", "Deplacer cette discussion dans un autre forum...");
@define("PLUGIN_FORUM_ALT_DELETE", "Effacer ce forum...");
@define("PLUGIN_FORUM_REOPEN", "Reouvrir");
@define("PLUGIN_FORUM_CLOSE", "Fermer");
@define("PLUGIN_FORUM_MOVE", "Deplacer");
@define("PLUGIN_FORUM_DELETE", "Effacer");
@define("PLUGIN_FORUM_ALT_DELETE_POST", "Effacer cette reponse...");
@define("PLUGIN_FORUM_ALT_REPLY", "Repondre a cette discussion...");
@define("PLUGIN_FORUM_ALT_QUOTE", "Repondre en citant ce message...");
@define("PLUGIN_FORUM_ALT_EDIT", "Modifier votre reponse..");
@define("PLUGIN_FORUM_ALT_DELETE", "Effacer cette reponse..");
@define("PLUGIN_FORUM_REPLY", "Repondre ");
@define("PLUGIN_FORUM_QUOTE", "Citer");
@define("PLUGIN_FORUM_EDIT", "Modifier");
@define("PLUGIN_FORUM_DELETE", "Effacer ");
@define("PLUGIN_FORUM_ALT_UNREAD", "pas lu avant ou pas nouvelle reponse poste..");
@define("PLUGIN_FORUM_ALT_READ", "deja lu...");
@define("PLUGIN_FORUM_ALT_DIRECTGOTOPOST", "aller directement au message...");
@define("PLUGIN_FORUM_MARKUPS", "Following markupspeuvent etre utilise si c'est active par l'administrateur:<br />&nbsp; - <a href=\"http://www.s9y.org/forums/faq.php?mode=bbcode\" target=\"_blank\">BBCode</a><br />&nbsp; - Smilies<br />&nbsp; - GalleryImage<br />");
@define("PLUGIN_FORUM_GUEST", "Invite");
@define("PLUGIN_FORUM_CONFIRM_DELETE_POST", "Voules-vous vraiment effacer ce message ?");
@define("PLUGIN_FORUM_ORDER", "Reorganiser");
@define("PLUGIN_FORUM_BOARDNAME", "Nom du Forum");
@define("PLUGIN_FORUM_BOARDDESC", "Description");
@define("PLUGIN_FORUM_REALLY_DELETE_Forums", "Etes-vous vraiment sur de vouloir effacer {num} Forum(s)?");
@define("PLUGIN_FORUM_REALLY_DELETE_THREAD", "Etes-vous vraiment sur de vouloir effacer ce forum");
@define("PLUGIN_FORUM_DELETE_OR_MOVE", "Should the messages be deleted or moved to another board?");
@define("PLUGIN_FORUM_WHERE_TO_MOVE", "Choisir un forum ou effacer:");
@define("PLUGIN_FORUM_ADD_BOARD", "Ajouter un nouveau Forum");
@define("PLUGIN_FORUM_PAGES", "Pages");
@define("PLUGIN_FORUM_MOVE_THREAD", "Vers quel Forum voulez-vous deplacer cette discussion?");
@define("PLUGIN_FORUM_MOVE", "Deplacer");
@define("PLUGIN_FORUM_FROM_BOARD", "du Forum");
@define("PLUGIN_FORUM_TO_BOARD", "vers le forum");
@define("PLUGIN_FORUM_SUBMIT", "Soumettre");
@define("PLUGIN_FORUM_RESET", "Remettre a zero");
@define("PLUGIN_FORUM_REG_USER", "Utilisateur enregistre");
@define("PLUGIN_FORUM_POSTS", "Messages");
@define("PLUGIN_FORUM_VISITS", "Visites");
@define("PLUGIN_FORUM_UPLOAD_FILE","Fichier telecharger");
@define("PLUGIN_FORUM_DOWNLOADCOUNT", "Telechargement:");
@define("PLUGIN_FORUM_REST_UPLOAD_USER", "telechargements restants pour l'utilisateur");
@define("PLUGIN_FORUM_REST_UPLOAD_POST", "telechargements restants pour cette discussion");
@define("PLUGIN_FORUM_ANNOUNCEMENT", "Est-ce une annonce?");
@define("PLUGIN_FORUM_SUBSCRIBE", "S'abonner a ce forum?");
@define("PLUGIN_FORUM_UNSUBSCRIBE", "Se desabonner a ce forum?");
@define("PLUGIN_FORUM_TODAY", "Aujourd'hui");
@define("PLUGIN_FORUM_YESTERDAY", "Hier");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE", "Ecraser");
@define("PLUGIN_FORUM_UPLOAD_OVERWRITE_BLAHBLAH", "	Si un fichier,telecharge par vous, de meme nom existe , il sera ecrase avec le meme nom");	
@define("PLUGIN_FORUM_ERR_MISSING_THREADTITLE", "Erreur: Titre du Forum absent ou trop court (4 caractrers minimum)! Message non enregistre");
@define("PLUGIN_FORUM_ERR_MISSING_MESSAGE", "Erreur: Texte du Forum absent ou trop court (4 caractrers minimum)! Message non enregistre");
@define("PLUGIN_FORUM_ERR_THREAD_CLOSED", "	Erreur: la discussion a laquelle vous essayez de repondre est fermee. Message non enregistre");
@define("PLUGIN_FORUM_ERR_EDIT_NOT_ALLOWED", "Erreur: Vous n'etes pas autorise a modifier .Message non enregistre!");
@define("PLUGIN_FORUM_ERR_DELETE_NOT_ALLOWED", "Erreur: Vous n'etes pas autorise a supprimer .Message non enregistre!");
@define("PLUGIN_FORUM_ERR_DOUBLE_THREAD", "Erreur: Vous avez deja enregistre cette discussion .Message non enregistre!");
@define("PLUGIN_FORUM_ERR_DOUBLE_POST", "Erreur: Vous avez deja envoye cette reponse .Message non enregistre!");
@define("PLUGIN_FORUM_ERR_POST_INTERVAL", "Erreur: l'intervalle entre deux enregistrements de messages est trop court .Message non enregistre!");
@define("PLUGIN_FORUM_ERR_WRONG_CAPTCHA_STRING", "Erreur: Mauvaise saisie des chapca.Message non enregistre!");
@define("PLUGIN_FORUM_ERR_FILE_TOO_BIG", "Fichier trop lourd (Non enregistre)!");
@define("PLUGIN_FORUM_ERR_FILE_NOT_COPIED", "Le Fichier n'a pas pu etre copie( raison inconnue)");


// email notify
@define("PLUGIN_FORUM_EMAIL_NOTIFY_SUBJECT", "Nouveau message a ete ecris par {postauthor} sur votre forum {blogurl}!");

@define("PLUGIN_FORUM_EMAIL_NOTIFY_PART1", "Bonjour,

{postauthor} wrotes a new reply to the thread
\"{threadtitle}\"
in our forum on
{forumurl}.

");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART2", "Voici ce qui est ecris:

----------------------------------------------------------------------
\"{replytext}\"
----------------------------------------------------------------------

");

@define ("PLUGIN_FORUM_EMAIL_NOTIFY_PART3", "Vous pouvez aller a ce message en cliquant sur ce lien:
{posturl}

");
@define('PLUGIN_FORUM_IMGDIR', 'chemin de ce plugin');
@define('PLUGIN_FORUM_IMGDIR_DESC', 'The HTTP path to where this plugin is stored. Used to output image files, for example.');


@define('PLUGIN_FORUM_PHPBB_MIRROR', 'Activer phpBB mirroring?');
@define('PLUGIN_FORUM_PHPBB_MIRROR_DESC', 'Si c`\'est actif,vos messages seront copies dans votre base PHPBB.n. Les commentaires seront ajoutes dans le forum phpBB au lieu d\'apparaître dans votre site.');

@define('FORUM_PLUGIN_PHPBB_USER', '(optional) phpBB database username');
@define('FORUM_PLUGIN_PHPBB_PW', '(optional) phpBB database password');
@define('FORUM_PLUGIN_PHPBB_NAME', '(optional) phpBB database name');
@define('FORUM_PLUGIN_PHPBB_HOST', '(optional) phpBB database server');
@define('FORUM_PLUGIN_PHPBB_PREFIX', '(optional) phpBB database table prefix');
@define('FORUM_PLUGIN_PHPBB_FORUM', '(optional) phpBB target forum ID');
@define('FORUM_PLUGIN_PHPBB_POSTER', '(optional) phpBB target poster ID');
@define('FORUM_PLUGIN_PHPBB_DISCUSS', 'Discuss this entry on the forum');

@define('FORUM_PLUGIN_NEW_THREAD', 'Nouvelle discussion');

/* vim: set sts=4 ts=4 expandtab : */
