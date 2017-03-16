<?php

return [


    /*
     * Master switch to enable or disable the prasheapp client.
     * Default is true
     */
    'enabled' => env('PHRASEAPP_CLIENT_ENABLED', true),

    /*
     * Once you setup PhraseApp there will be a project id.
     */
    'project_id' => env('PHRASEAPP_PROJECT_ID'),

    /*
     * List of locales that you want to fetch from PhraseApp.
     * You should have those configured also in PhraseApp.
     *
     * Laravel locales will be the "xx" from the locales format xx-YY.
     */
    'locales' => [
        'en-US',
        'pt-PT',
    ],

    /*
     * Tags are used in this package as filter options.
     * So basically will fetch translations in laravel format filtered
     * by tags. Each tag will be a separated file within your project.
     * Example:
     * Tag 'auth' for locale en-US:
     * will generate the file "resources/lang/en/auth.php"
     *
     * The ones listed below are the generic translation files that
     * a boilerplate should have.
     *
     * TODO: Add support to tag mapped to file name
     */
    'tags' => [
        'auth',
        'notifications',
        'pagination',
        'passwords',
        'validation',
    ],

    /*
     * We will fetch translation by laravel.
     *
     */
    'format' => 'laravel',
];