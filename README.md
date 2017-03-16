# laravel-phraseapp
Larval PhraseApp Package

## Install

### Add Service provider
```
Ajaaleixo\PhraseApp\PhraseAppServiceProvider::class,
```

### Add a Storage Disk
```
'disks' => [
(...)
'lang' => [
    'driver' => 'local',
    'root' => resource_path('lang'),
],
]
```

### Run Publish Command

