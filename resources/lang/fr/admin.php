<?php

return [
    'title' => 'Configuration de Skin API',

    'fields' => [
        'width' => 'Largeur',
        'height' => 'Hauteur',
        'scale' => 'Échelle maximale',
        'not_found_behavior' => 'Quand l\'utilisateur n\'est pas trouvé',
        'not_found_options' => [
            'skin_api_default' => 'Retourner le skin par défaut',
            'error_message' => 'Retourner une erreur'
        ],
        'show_nav_icon' => 'Afficher l\'icône dans la navigation',
        'show_skin_in_profile' => 'Afficher la gestion des skins dans le profil',
        'navigation_icon' => 'Icône de navigation',
        'navigation_icon_help' => 'Entrez une classe d\'icône Bootstrap (ex: bi bi-images). Vous pouvez trouver les icônes sur <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a><br>Laissez vide pour masquer l\'icône de navigation'
    ],

    'api' => [
        'title' => 'Informations API',
        'using_id' => 'Utilisation de l\'ID utilisateur',
        'using_username' => 'Utilisation du nom d\'utilisateur',
        'usage_info' => 'Vous pouvez utiliser soit',
        'replace_id' => 'Remplacez {user_id} par l\'ID de l\'utilisateur',
        'replace_username' => 'Remplacez {username} par le nom d\'utilisateur',
        'post_info' => 'La route POST nécessite 2 paramètres',
        'update_info' => 'L\'utilisateur, s\'il est connecté, peut mettre à jour son skin à'
    ],

    'permissions' => [
        'manage' => 'Gérer le plugin skin-api',
    ],

    'capes' => [
        'capes' => '1',
        'title' => 'Paramètres des capes',
        'enable' => 'Activer les capes',
        'max_size' => 'Taille maximale des fichiers de cape (KB)',
        'max_size_info' => 'La taille maximale des fichiers pour les téléchargements de capes en kilooctets.',
        'upload_default' => 'Télécharger une cape par défaut',
        'upload_info' => 'Télécharger un nouveau fichier de cape',
        'current_default' => 'Cape par défaut actuelle',
        'no_default' => 'Aucune cape par défaut définie',
        'show_nav_button' => 'Afficher le bouton de cape dans la navigation',
        'show_in_profile' => 'Afficher la cape dans le profil',
        'nav_icon' => 'Icône de navigation',
        'nav_icon_info' => 'Entrez une classe d\'icône Bootstrap (ex: bi bi-person-circle). Vous pouvez trouver les icônes sur <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a><br>Laissez vide pour masquer l\'icône de navigation',
        'not_found_behavior' => 'Quand la cape n\'est pas trouvée',
        'not_found_default' => 'Utiliser la cape par défaut',
        'not_found_error' => 'Afficher un message d\'erreur',
        'remove_default' => 'Supprimer la cape par défaut'
    ],

    'settings' => [
        'updated' => 'Paramètres mis à jour avec succès !',
    ],
];