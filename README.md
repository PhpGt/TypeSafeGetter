An interface for objects that expose type-safe getter methods.
==============================================================

Throughout PHP.Gt repositories, wherever an object represents enclosed data, a consistent interface is used to expose the data in a type-safe manner.

***

<a href="https://github.com/PhpGt/TypeSafeGetter/actions" target="_blank">
	<img src="https://badge.status.php.gt/typesafegetter-build.svg" alt="Build status" />
</a>
<a href="https://app.codacy.com/gh/PhpGt/TypeSafeGetter" target="_blank">
	<img src="https://badge.status.php.gt/typesafegetter-quality.svg" alt="Code quality" />
</a>
<a href="https://app.codecov.io/gh/PhpGt/TypeSafeGetter" target="_blank">
    <img src="https://badge.status.php.gt/typesafegetter-coverage.svg" alt="Code coverage" />
</a>
<a href="https://packagist.org/packages/PhpGt/TypeSafeGetter" target="_blank">
	<img src="https://badge.status.php.gt/typesafegetter-version.svg" alt="Current version" />
</a>
<a href="https://www.php.gt/typesafegetter" target="_blank">
	<img src="https://badge.status.php.gt/typesafegetter-docs.svg" alt="PHP.Gt/TypeSafeGetter documentation" />
</a>

The following methods are defined by this interface:

+ `get(string $name):mixed` - A non-type-safe getter, used for getting keys that are not of an inbuilt type
+ `getString(string $name):?string`
+ `getInt(string $name):?int`
+ `getFloat(string $name):?float`
+ `getBool(string $name):?bool`
+ `getDateTime(string $name):?DateTimeInterface`
+ `getInstance(string $name, class-string<T> $className):?T`

Common areas you will see this interface used:

+ Database rows
+ User input (from the query string or posted form data)
+ Session and cookie storage
+ PHP.Gt's [DataObject](https://www.php.gt/dataobject) repository.

`NullableTypeSafeGetter` trait
------------------------------

A lot of repositories within PHP.Gt that utilise this class were repeating the same getter code, so this trait was introduced to remove the repetition. All getter functions of the interface are implemented, introducing a protected helper function `getNullableType` which removes the repetition of checking null values before casting them. The `getNullableType` function also allows a callback to be passed as the type parameter, allowing more complex nullable types to be constructed.
