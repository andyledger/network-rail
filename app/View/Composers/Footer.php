<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Footer extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.footer',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'social_media_footer' => $this->social_media_footer()
        ];
    }

    /**
     * Add social media to footer
     *
     * @return [array]
     */
    public function social_media_footer()
    {
        $social_media = get_field('social_media_footer', 'options');

        $social_media['0']['icon'] = 'sm_facebook';
        $social_media['0']['text'] = 'Network Rail on Facebook';

        $social_media['1']['icon'] = 'sm_instagram';
        $social_media['1']['text'] = 'Network Rail on Instagram';

        $social_media['2']['icon'] = 'sm_linkedin';
        $social_media['2']['text'] = 'Network Rail on Linkedin';

        $social_media['3']['icon'] = 'sm_twitter';
        $social_media['3']['text'] = 'Network Rail on Twitter';

        $social_media['4']['icon'] = 'sm_youtube';
        $social_media['4']['text'] = 'Network Rail on Youtube';

        return $social_media;
    }
}
