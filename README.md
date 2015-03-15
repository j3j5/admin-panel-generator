# Laravel 5 Admin Panel Generator

Generate admin panel interface based on configuration.

- [Installation](#installation)
- [Configuration](#configuration)
  - [prefix](#prefix)
  - [authMiddleware](#authMiddleware)
  - [tables](#tables)
  - [rowsPerPage](#rowsPerPage)
  - [columns](#columns)
  - [filters](#filters)
  - [forms](#forms)
  - [validationRules](#validationRules)
- [Screenshots](#screenshots)
- [Contributing](#contributing)

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


## Configuration

After publishing vendor assets, you will get new config file `config/vivifyideas/admin-panel-generator.php`.

Configuration file will look like this:

```php
return [
    'prefix' => 'admin',

    'authMiddleware' => 'auth',

    'tables' => [],

    'rowsPerPage' => 15,

    'columns' => [],

    'filters' => [],

    'forms' => [],

    'validationRules' => []
];

```

Lets explain each section.

### prefix

This represent URL prefix of your admin panel.
Eg If you set `'admin'` as your `prefix`, your admin URL will be something like this `http://localhost:8000/admin`.

> **Note:** Set this option without `/` prefix

### authMiddleware

This middleware will be used for authorizing admin users. By default its set to Laravel default `auth` middleware.
You can use your own middleware.

### tables

Represent list of table names that you want to manage via your admin panel.
Example:

```php
'tables' => [ 'users', 'articles', 'tags' ]
```

### rowsPerPage

Here you can set how many rows per page you want to display on list view. By default it is set to `15`.

### columns

Define which columns you want to display for each table.
Example:

```php
'columns' => [
    'users' => [ 'id', 'name', 'email', 'created_at' ],
    'articles' => [ 'title', 'description' ]
]
```

### filters

For each "List view" you can setup filters. Filters are used so you can easy filter your list view. Example:

```php
'filters' => [
    'users' => [
        'email' => [
            'label' => 'Email',
            'type' => 'text',
            'compare' => 'LIKE'
        ],
        'id' => [
            'label' => 'User #',
            'type' => 'number'
        ]
    ]
]
```

First you define for which table you want to setup filters. For each filter you can setup 3 params:

- `label` [required] Label for certain column
- `type` [required] [ _text | password | email | url | textarea | number | checkbox | radio_ ]
- `compare` [optional] If you dont setup this param, then `=` will be used.

### forms

Forms config is used for creating and editing certain model.
It represent list of fields that you want to allow your admin user to enter when creating/editing certain models.
Example:

```php
'forms' => [
    'articles' => [
        'title',
        'category' => [
            'label' => 'Takson',
            'type' => 'text'
        ],
        'belongsTo' => [
            'users' => [
                'label' => 'User',
                'column' => 'user_id',
                'foreignLabel' => 'name',
                'nullable' => true // this is optional param
            ]
        ],
        'hasMany' => [
            'videos' => [
                'label' => 'Videos',
                'column' => 'article_id',
                'foreignLabel' => 'title'
            ]
        ]
    ]
]
```

- `belongsTo` param will generate "select box"
- `hasMany` will generate "multi select box". In above example we have `videos` table with column `article_id` (that represent foreign key).

### validationRules

Here you can setup validation rules ([Laravel validation rules](http://laravel.com/docs/5.0/validation#available-validation-rules)) for each table. It will be called when admin user want to create or edit some entity. Example:

```php
'validationRules' => [
    'articles' => [
        'title' => 'required|min:10',
        'text' => 'required'
    ]
]
```

## Screenshots

// TODO

## Contributing

// TODO
