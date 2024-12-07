<?php

namespace Azuriom\Plugin\SkinApi\Cards;

use Azuriom\Extensions\Plugin\UserProfileCardComposer;

class ChangeCapeViewCard extends UserProfileCardComposer
{
    public function getCards(): array
    {
        // Only show the card if enabled in settings
        if (!setting('skin.capes.show_in_profile', true)) {
            return [];
        }

        return [
            [
                'name' => trans('skin-api::messages.capes'),
                'view' => 'skin-api::cards.changecape',
            ],
        ];
    }
}
