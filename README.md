# yii2-crud-example
## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

### Install

Either run

```
$ php composer.phar require execut/yii2-crud-example "dev-master"
```

or add

```
"execut/yii2-crud-example": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Configuration

Add to your app config:
```php
return [
    // ...
    'modules' => [
         // ...
         'crudExample' => [
            'class' => \execut\crudExample\Module::class,
        ],
         // ...
    ],
    // ...
];
```

## Usage
Open books example url in your browser [/crudExample/books/index](http://localhost/crudExample/books/index)