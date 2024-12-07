<?php

return [
    'title' => 'Skin API configuration',

    'fields' => [
        'width' => 'Width',
        'height' => 'Height',
        'scale' => 'Max scale',
        'not_found_behavior' => 'When User Not Found',
        'not_found_options' => [
            'skin_api_default' => 'Return Default Skin',
            'error_message' => 'Return User Not Found Error'
        ]
    ],

    'api' => [
        'title' => 'API Information',
        'using_id' => 'Using User ID',
        'using_username' => 'Using Username',
        'usage_info' => 'You can use either:',
        'replace_id' => 'Replace {user_id} with the user\'s ID number',
        'replace_username' => 'Replace {username} with the user\'s username',
        'post_info' => 'The POST route requires 2 parameters:',
        'update_info' => 'The user, if connected, can update their skin at'
    ],

    'permissions' => [
        'manage' => 'Manage skin-api plugin',
    ],

    'capes' => [
        'capes' => '1',
        'title' => 'Cape Settings',
        'enable' => 'Enable capes',
        'max_size' => 'Maximum cape file size (KB)',
        'max_size_info' => 'The maximum file size for cape uploads in kilobytes.',
        'upload_default' => 'Upload Default Cape',
        'upload_info' => 'Upload a new cape file',
        'current_default' => 'Current Default Cape',
        'no_default' => 'No default cape set'
    ],

    'settings' => [
        'updated' => 'Settings successfully updated!',
    ],
];