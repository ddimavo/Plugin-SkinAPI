<?php

return [
    'title' => 'Настройка Skin API',

    'fields' => [
        'width' => 'Ширина',
        'height' => 'Высота',
        'scale' => 'Максимальный масштаб',
        'not_found_behavior' => 'Когда пользователь не найден',
        'not_found_options' => [
            'skin_api_default' => 'Вернуть скин по умолчанию',
            'error_message' => 'Вернуть сообщение об ошибке'
        ],
        'show_nav_icon' => 'Показать иконку в навигации',
        'show_skin_in_profile' => 'Показать управление скинами в профиле',
        'navigation_icon' => 'Иконка навигации',
        'navigation_icon_help' => 'Введите класс иконки Bootstrap (например: bi bi-images). Вы можете найти иконки на <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a><br>Оставьте пустым, чтобы скрыть иконку навигации'
    ],

    'api' => [
        'title' => 'Информация об API',
        'using_id' => 'Использование ID пользователя',
        'using_username' => 'Использование имени пользователя',
        'usage_info' => 'Вы можете использовать',
        'replace_id' => 'Замените {user_id} на ID пользователя',
        'replace_username' => 'Замените {username} на имя пользователя',
        'post_info' => 'POST-запрос требует 2 параметра',
        'update_info' => 'Пользователь, если он авторизован, может обновить свой скин по адресу'
    ],

    'permissions' => [
        'manage' => 'Управление плагином skin-api',
    ],

    'capes' => [
        'capes' => '1',
        'title' => 'Настройки плащей',
        'enable' => 'Включить плащи',
        'max_size' => 'Максимальный размер файла плаща (КБ)',
        'max_size_info' => 'Максимальный размер файлов для загрузки плащей в килобайтах.',
        'upload_default' => 'Загрузить плащ по умолчанию',
        'upload_info' => 'Загрузить новый файл плаща',
        'current_default' => 'Текущий плащ по умолчанию',
        'no_default' => 'Плащ по умолчанию не установлен',
        'show_nav_button' => 'Показать кнопку плаща в навигации',
        'show_in_profile' => 'Показать плащ в профиле',
        'nav_icon' => 'Иконка навигации',
        'nav_icon_info' => 'Введите класс иконки Bootstrap (например: bi bi-person-circle). Вы можете найти иконки на <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a><br>Оставьте пустым, чтобы скрыть иконку навигации',
        'not_found_behavior' => 'Когда плащ не найден',
        'not_found_default' => 'Использовать плащ по умолчанию',
        'not_found_error' => 'Показать сообщение об ошибке',
        'remove_default' => 'Удалить плащ по умолчанию'
    ],

    'settings' => [
        'updated' => 'Настройки успешно обновлены!',
    ],
];