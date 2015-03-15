# Laravel 5 Admin Panel Generator

Generate admin panel interface based on configuration.

## Installation

First you need to install this package through Composer. Edit your project's `composer.json` file to require `vivify-ideas/admin-panel-generator` package.

```
"require": {
  "vivify-ideas/admin-panel-generator": "dev-master"
}
```

Next, update Composer from the Terminal:

```
composer update
```

Once this operation completes, you will need to add the service provider into your application.
Open `config/app.php` file, and add a new item to the providers array.

```
'VivifyIdeas\AdminPanelGenerator\Providers\AdminPanelGeneratorProvider'
```

The last step is to publish package dependencies running:

```
php artisan vendor:publish
```

This will create new config file `config/vivifyideas/admin-panel-generator.php`, that you will need to edit to configure your admin panel.
You are now ready to start configuring your admin panel.


## Using

TODO

## Screenshots

TODO

## Contributing

TODO
