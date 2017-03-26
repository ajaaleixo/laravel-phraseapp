# Laravel PhraseApp Package
Supports L5.4

This package offers you a way of downloading translated keys from https://phraseapp.com.
This translation tool supports *tagging* which is used to separate your key set.

## Commands / Features
### Download
Fetched the configured list of *Locales* per *Tag* from your PhraseApp.com and creates one file per Tag under you resources/lang/locale/ directory.

+PhraseApp - Suggestion of usage+

When importing/inserting new keys, I suggest to use tags as API accept it as filter option.


## Install

### Add Service provider
Open your config/app.php and insert the following in providers key:
```
Ajaaleixo\PhraseApp\PhraseAppServiceProvider::class,
```

### Add a Storage Disk
Open your config/filesystems.php and insert the following code:
```
'disks' => [
(...)
'lang' => [
    'driver' => 'local',
    'root' => resource_path('lang'),
],
]
```

### Run Publish command
```
php artisan vendor:publish --provider="Ajaaleixo\PhraseApp\PhraseAppServiceProvider"
```

### Edit your settings
Open ```config/laravel-phraseapp.php``` and create each ```.env``` key and edit the following:
- project_id
- api.key
- identification

## Roadmap
- Phraseapp:Upload
  Push existing translations to PhraseApp
- Phraseapp:Get:Locales
  Displays a Table with Available Locales in your Account


