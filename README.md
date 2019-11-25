# Frontend CMS

A content management system that allows you to output editable content to the page.

```php
$model->field // Field value
```

```php
$model->field->title('h2') // Outout <h2 class="..." data-edtable="...">Field value</h2>
```

```php
$model->field->image() // Outout <video class="..." data-edtable="..."><source src="..." type="..."><source ...></h2>
```
