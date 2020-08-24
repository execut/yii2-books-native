# Yii2 books native
CRUD for books on native Yii2 framework for a compare and demonstration [execut/yii2-books](https://github.com/execut/yii2-books).

For license information check the [LICENSE-file](https://github.com/execut/yii2-books-native/blob/master/LICENSE.md).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

### Install

Either run

```
$ php composer.phar require execut/yii2-books-native "dev-master"
```

or add

```
"execut/yii2-books-native": "dev-master"
```

to the ```require``` section of your `composer.json` file.

Apply module migrations:
```shell script
./yii migrate/up --interactive=0
-> ...migration was applied.
-> 
-> Migrated up successfully.
```

## Usage
Open books example url in your browser [/booksNative/books/index](http://localhost/booksNative/books/index).

![Books CRUD list](https://raw.githubusercontent.com/execut/yii2-books-native/master/docs/guide/i/books-list.jpg)
![Books CRUD form](https://raw.githubusercontent.com/execut/yii2-books-native/master/docs/guide/i/books-form.jpg)

Authors example here [/booksNative/authors/index](http://localhost/booksNative/authors/index).

![Authors CRUD list](https://raw.githubusercontent.com/execut/yii2-books-native/master/docs/guide/i/authors-list.jpg)
![Authors CRUD form](https://raw.githubusercontent.com/execut/yii2-books-native/master/docs/guide/i/authors-form.jpg)
