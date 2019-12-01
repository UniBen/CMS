# Frontend CMS

A content management system that allows you to output editable content to the page.

```php
$model->field // Field value
```

```php
$model->field->title('h2') // Output <h2 class="..." data-edtable="...">Field value</h2>
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

## How it works

When an editable field is rendered it is given an id which maps to the model type, model id and updated field.
When an update/save is made editable fields which belong to the same model are collated in to an array and sent to an update controller.
