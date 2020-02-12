# Frontend CMS
[![Latest Stable Version](https://poser.pugx.org/uniben/cms/version)](https://packagist.org/packages/uniben/cms)
[![Total Downloads](https://poser.pugx.org/uniben/cms/downloads)](https://packagist.org/packages/uniben/cms)
[![Latest Unstable Version](https://poser.pugx.org/uniben/cms/v/unstable)](//packagist.org/packages/uniben/cms)
[![License](https://poser.pugx.org/uniben/cms/license)](https://packagist.org/packages/uniben/cms)

A content management system that allows you to output editable content to the page.

## Install

```shell script
$ composer require uniben/cms
```

## Examples

```php
$model->field // Field value
```

```php
$model->field->title('Default value', 'h2', ['class' => 'example', 'rand']) // Output <h2 class="example ..." rand data-edtable="...">Field value</h2>
```

```php
$model->field->image() // Output <video class="..." data-edtable="..."><source src="..." type="..."><source ...></h2>
```

## Restricting editable capabilities

Allow everyone to edit a particular model:

```php
class X extends Editable {
    public function canEdit()
    {
        return true;
    }
}
```

Only allow logged in users to edit:

```php
class X extends Editable {
    public function canEdit()
    {
        return auth()->user(); // Could even check their permissions here?
    }
}
```

## Contributing

For an easy install of a development environment you can use docker to run using docker. The docker file will install laravel and the package for you along with a temporary database.

### Install

```shell script
$ make install
``` 

### Start

```shell script
docker-compose up -d
```

Visit `localhost:8080`

## How it works

When an editable field is rendered it is given an id which maps to the model type, model id and updated field.
When an update/save is made editable fields which belong to the same model are collated in to an array and sent to an update controller.

## Todo
* Switch edtable types render methods over to views rather than generatng inside of a method.
* Handle redirect responses from edtables when a new product is created.
* Make edtables on the frontend reactive using VueX
* Use UniBen/laravel-graphqlable for an easy to use documented API.
* Get wwyswig and image upload fields working using standard libraries.
* Improve editable type caching and queries in admin
* Make editable fields revisionable
* Improve code qualiity
* Aim for 100% code coverage
* Make dynamic registration of editable types easy via a service provider
* Reduce JS bundle size as much as possible
* Remove server side rendered editables and use vue components with ssr instead to simplify process.
