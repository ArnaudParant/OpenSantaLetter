<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

/*
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();

//Account
$lang = array_merge($lang,array(
  "ACCOUNT_SPECIFY_USERNAME" 		=> "Entrer votre pseudo",
  "ACCOUNT_SPECIFY_PASSWORD" 		=> "Entrer votre mot de passe",
  "ACCOUNT_SPECIFY_EMAIL"		=> "Entrer votre adresse email",
  "ACCOUNT_INVALID_EMAIL"		=> "Addresse email invalide",
  "ACCOUNT_USER_OR_EMAIL_INVALID"	=> "L'addresse email ou le pseudo est invalide",
  "ACCOUNT_USER_OR_PASS_INVALID"	=> "Le pseudo ou le mot de passe est invalide",
  "ACCOUNT_ALREADY_ACTIVE"		=> "Votre compte est déjà activé",
  "ACCOUNT_INACTIVE"			=> "Votre compte est inactif. Verifiez vos emails / dossier spam pour les instructions d'activation",
  "ACCOUNT_USER_CHAR_LIMIT"		=> "Votre pseudo doit être entre %m1% et %m2% caractères de long",
  "ACCOUNT_DISPLAY_CHAR_LIMIT"		=> "Votre nom public doit être entre %m1% et %m2% caractères de long",
  "ACCOUNT_PASS_CHAR_LIMIT"		=> "Votre mot de passe doit être entre %m1% et %m2% caractères de long",
  "ACCOUNT_TITLE_CHAR_LIMIT"		=> "Les titres doivent être entre %m1% et %m2% caractères de long",
  "ACCOUNT_PASS_MISMATCH"		=> "Les deux mot de passes doivent être identique",
  "ACCOUNT_DISPLAY_INVALID_CHARACTERS"	=> "Le nom public peu seulement contenir des caratères alpha-numeric",
  "ACCOUNT_USERNAME_IN_USE"		=> "Le pseudo %m1% est déjà utilisé",
  "ACCOUNT_DISPLAYNAME_IN_USE"		=> "Le nom public %m1% est déjà utilisé",
  "ACCOUNT_EMAIL_IN_USE"		=> "L'adresse email %m1% est déjà utilisée",
  "ACCOUNT_LINK_ALREADY_SENT"		=> "Un email d'activation a déjà été envoyé dans les dernières %m1% heure(s)",
  "ACCOUNT_NEW_ACTIVATION_SENT"		=> "Un nouvel email d'activation à été envoyé, vérifiez vos emails",
  "ACCOUNT_SPECIFY_NEW_PASSWORD"	=> "Entrer en nouveau mot de passe",	
  "ACCOUNT_SPECIFY_CONFIRM_PASSWORD"	=> "Entrer le même mot de passe",
  "ACCOUNT_NEW_PASSWORD_LENGTH"		=> "Votre nouveau mot de passe doit être entre %m1% et %m2% caractères de long",	
  "ACCOUNT_PASSWORD_INVALID"		=> "Le mot de passe entré est invalide",	
  "ACCOUNT_DETAILS_UPDATED"		=> "Compte mise à jour",
  "ACCOUNT_ACTIVATION_MESSAGE"		=> "Cliquez sur le lien suivant pour activer votre compte. \n\n
	%m1%activate-account.php?token=%m2%",
  "ACCOUNT_ACTIVATION_COMPLETE"		=> "Vous avez bien activez votre compte. Vous pouvez maintenant vous connecter <a href=\"login.php\">ici</a>.",
  "ACCOUNT_REGISTRATION_COMPLETE_TYPE1"	=> "Vous vous êtes bien enregistré. Vous pouvez maintenant vous connecter <a href=\"login.php\">ici</a>.",
  "ACCOUNT_REGISTRATION_COMPLETE_TYPE2"	=> "Vous vous êtes bien enregistré. Vous allez bientôt recevoir un email d'activation.",
  "ACCOUNT_PASSWORD_NOTHING_TO_UPDATE"	=> "Vous ne pouvez pas metre à jour votre compte avec le même mot de passe",
  "ACCOUNT_PASSWORD_UPDATED"		=> "Mot de passe mis à jour",
  "ACCOUNT_EMAIL_UPDATED"		=> "Email mis à jour",
  "ACCOUNT_TOKEN_NOT_FOUND"		=> "Le token est invalide, votre compte est surement déjà activé",
  "ACCOUNT_USER_INVALID_CHARACTERS"	=> "Le pseudo peu seulement contenir des caratères alpha-numeric",
  "ACCOUNT_DELETIONS_SUCCESSFUL"	=> "Vous venez de supprimer les utilisateurs %m1%",
  "ACCOUNT_MANUALLY_ACTIVATED"		=> "Le compte de %m1% à été manuellement activé",
  "ACCOUNT_DISPLAYNAME_UPDATED"		=> "Le nom public à été changé pour %m1%",
  "ACCOUNT_TITLE_UPDATED"		=> "Le titre '%m1%' à été changé pour '%m2%'",
  "ACCOUNT_PERMISSION_ADDED"		=> "Ajout de l'access %m1%",
  "ACCOUNT_PERMISSION_REMOVED"		=> "Suppression de l'access %m1%",
  "ACCOUNT_INVALID_USERNAME"		=> "Invalide pseudo",
));

//Group
$lang = array_merge($lang,array(
  "GROUP_INVALID_ID"                      => "Invalide id de groupe",
  "GROUP_SPECIFY_NAME"                    => "Entrer un nom de groupe",
  "GROUP_SPECIFY_DESCRIPTION"             => "Entrer une description de groupe",
  "GROUP_CREATED"                         => "Le groupe à bien été crée",
  "GROUP_CREATION_FAILED"                 => "Erreur lors de la création du groupe",
  "GROUP_DELETED"                         => "Le groupe à bien été supprimé",
  "GROUP_DELETE_FAILED"                   => "Erreur lors de la suppression du groupe",
  "GROUP_UNKNOWN_EMAIL"                   => "Email inconnu",
  "GROUP_USER_ADDED"                      => "Utilisateur correctement ajouté",
  "GROUP_USER_ADD_FAILED"                 => "Erreur lors de l'ajout de l'utilisateur",
  "GROUP_USER_UNSUBSCRIBE"                => "Utilisateur correctement désabonné",
  "GROUP_USER_UNSUBSCRIBE_FAILED"         => "Erreur lors du désabonnement de l'utilisateur",
  "GROUP_USERLIST_EMPTY"                  => "Liste de voeux vide",
));

//User List
$lang = array_merge($lang,array(
  "USERLIST_ITEM_ADDED"                   => "Objet correctement ajouté",
  "USERLIST_ITEM_ADD_FAILED"              => "Impossible d'ajouter l'objet",
  "USERLIST_ITEM_DELETED"                 => "Objet correctement supprimé",
  "USERLIST_ITEM_DELETE_FAILED"           => "Impossible de supprimer l'objet",
  "USERLIST_ITEM_BOOKED"                  => "Objet correctement réservé",
  "USERLIST_ITEM_BOOK_FAILED"             => "Impossible de réserver l'objet",
  "USERLIST_ITEM_UNBOOKED"                => "Object correctement déréservé",
  "USERLIST_ITEM_UNBOOK_FAILED"           => "Impossible de déréserver l'objet",
  "USERLIST_EMPTY"                        => "Votre list de voeux est vide",
));

//Configuration
$lang = array_merge($lang,array(
  "CONFIG_NAME_CHAR_LIMIT"		=> "Le nom du site doit être entre %m1% et %m2% caratère de long",
  "CONFIG_URL_CHAR_LIMIT"		=> "L'url du site doit être entre %m1% et %m2% caratère de long",
  "CONFIG_EMAIL_CHAR_LIMIT"		=> "L'email du site doit être entre %m1% et %m2% caratère de long",
  "CONFIG_ACTIVATION_TRUE_FALSE"	=> "L'email d'activation doit être `true` ou `false`",
  "CONFIG_ACTIVATION_RESEND_RANGE"	=> "La limite d'activation doite être entre %m1% et %m2% heures",
  "CONFIG_LANGUAGE_CHAR_LIMIT"		=> "Le chemin de langue doite être entre %m1% et %m2% caratère de long",
  "CONFIG_LANGUAGE_INVALID"		=> "Il n'y a pas de ficher de langue `%m1%`",
  "CONFIG_TEMPLATE_CHAR_LIMIT"		=> "Le chemain de template doit être entre %m1% et %m2% caratère de long",
  "CONFIG_TEMPLATE_INVALID"		=> "Il n'y a pas de fichier de template `%m1%`",
  "CONFIG_EMAIL_INVALID"		=> "L'email entré est invalide",
  "CONFIG_INVALID_URL_END"		=> "Merci d'ajouté le / à la fin de l'url du site",
  "CONFIG_UPDATE_SUCCESSFUL"		=> "La configuration de votre site à été mis à jour.",
));

//Forgot Password
$lang = array_merge($lang,array(
  "FORGOTPASS_INVALID_TOKEN"		=> "Votre token d'activation est invalide",
  "FORGOTPASS_NEW_PASS_EMAIL"		=> "Un nouveau mot de passe à été envoyé",
  "FORGOTPASS_REQUEST_CANNED"		=> "Requette de mot de passe oublié, annulé",
  "FORGOTPASS_REQUEST_EXISTS"		=> "Une requette de mot de passe oublié est déjà en cours.",
  "FORGOTPASS_REQUEST_SUCCESS"		=> "Un email à été envoyé pour récupérer l'access à votre compte",
));

//Mail
$lang = array_merge($lang,array(
  "MAIL_ERROR"				=> "Impossible d'envoyé l'email, contactez l'administrateur",
  "MAIL_TEMPLATE_BUILD_ERROR"		=> "Erreur dans les templates d'emails",
  "MAIL_TEMPLATE_DIRECTORY_ERROR"	=> "Impossible d'ouvrir le dossier des templates d'email. Essayez de configurer le chemin sur %m1%",
  "MAIL_TEMPLATE_FILE_EMPTY"		=> "Le fichier de template d'email est vide... rien à envoyer",
));

//Miscellaneous
$lang = array_merge($lang,array(
  "CAPTCHA_FAIL"			=> "Mauvais captcha réponse",
  "CONFIRM"				=> "Confirmé",
  "DENY"				=> "Access interdit",
  "SUCCESS"				=> "Bravo",
  "ERROR"				=> "Erreur",
  "NOTHING_TO_UPDATE"			=> "Rien à mettre à jour",
  "SQL_ERROR"				=> "SQL Fatal erreur",
  "FEATURE_DISABLED"			=> "Cette fonctionalité est actuellement désactivé",
  "PAGE_PRIVATE_TOGGLED"		=> "Cette page est maintenant %m1%",
  "PAGE_ACCESS_REMOVED"			=> "Page supprimé pour les %m1%",
  "PAGE_ACCESS_ADDED"			=> "Page ajouté pour les %m1%",
));

//Permissions
$lang = array_merge($lang,array(
  "PERMISSION_CHAR_LIMIT"		=> "Le nom des permission doit être entre %m1% et %m2% caratères de long",
  "PERMISSION_NAME_IN_USE"		=> "Le nom de permission %m1% ext déjà utilisé",
  "PERMISSION_DELETIONS_SUCCESSFUL"	=> "Le nom de permission %m1% à bien été supprimé",
  "PERMISSION_CREATION_SUCCESSFUL"	=> "Le nom de permission `%m1%` à bien été ajouté",
  "PERMISSION_NAME_UPDATE"		=> "Le nom de permission à bien été changé pour `%m1%`",
  "PERMISSION_REMOVE_PAGES"		=> "L'access à bien été supprimé aux pages %m1%",
  "PERMISSION_ADD_PAGES"		=> "L'access à bien été ajouté aux pages %m1%",
  "PERMISSION_REMOVE_USERS"		=> "L'utilisateur %m1% à bien été supprimé",
  "PERMISSION_ADD_USERS"		=> "L'utilisateur %m1% à bien été ajouté",
  "CANNOT_DELETE_NEWUSERS"		=> "Vous ne pouvez pas supprimé le groupe 'new user'",
  "CANNOT_DELETE_ADMIN"			=> "Vous ne pouvez pas supprimé le groupe 'admin'",
));

//Naviguation
$lang = array_merge($lang,array(
  "NAV_HOME"			=> "Accueil",
  "NAV_LOGIN"			=> "Connection",
  "NAV_REGISTER"		=> "S'enregistrer",
  "NAV_FORGOT_PASSWORD"		=> "Mot de passe oublié",
  "NAV_RESEND_ACTIVATION_EMAIL"	=> "Renvoyer l'activation",
  "NAV_USER_SETTINGS"		=> "Mon compte",
  "NAV_MY_LIST"   		=> "Ma liste voeux",
  "NAV_MY_GROUPS"   		=> "Mes groupes",
  "NAV_GROUP_CREATION" 		=> "Création de groupe",
  "NAV_GROUP_MEMBERS"	        => "Membre du groupe",
  "NAV_GROUP_LIST"	        => "Liste cadeaux du groupe",
  "NAV_LOGOUT"       		=> "Déconnection",
  "NAV_ADMIN_SETTINGS"   	=> "Configuration admin",
  "NAV_ADMIN_USERS"   		=> "Gestion des utilisateurs",
  "NAV_ADMIN_PERMISSIONS"	=> "Gestion des permissions",
  "NAV_ADMIN_PAGES"		=> "Gestion des pages",
));

//Words
$lang = array_merge($lang,array(
  "VERSION"		=> "Version",
  "NAME"		=> "Nom",
  "DESCRIPTION"		=> "Description",
  "USERNAME"		=> "Pseudo",
  "DISPLAY_NAME"	=> "Nom public",
  "EMAIL"  		=> "Email",
  "PASSWORD"  		=> "Mot de passe",
  "NEW_PASSWORD"  	=> "Nouveau mot de passe",
  "CONFIRM_PASSWORD"  	=> "Confirmé le mot de passe",
  "SECURITY_CODE"  	=> "Code de sécurité",
  "ENTER"               => "Entrer",
  "GROUP"		=> "Groupe",
  "ACTION"              => "Action",
  "DELETE"              => "Suppréssion",
  "ADD"                 => "Ajouter",
  "ITEM"                => "Objet",
  "BOOK"                => "Réserver",
  "UNBOOK"              => "Déreserver",
  "BOOKED"              => "Réservé",
  "INVITE"              => "Inviter",
  "UNSUBSCRIBE"         => "Désincription",
  "PERMISSIONS"         => "Permissions"
));

//Place Holder
$lang = array_merge($lang,array(
  "PLACEHOLDER_USER_EMAIL"         => "email utilisateur",
  "PLACEHOLDER_ITEM_NAME"          => "nom d'objet",
  "PLACEHOLDER_DESCRIPTION"        => "description",
));

//Content
$lang = array_merge($lang,array(
  "CONTENT_PRESENTATION"	=> "SantaLetter est un projet open source, libre de droit. Le but est d'offrir une manière simple de gérer des listes de voeux pour la famille ou entre amis.",
));

?>