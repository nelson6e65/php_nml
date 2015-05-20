# [CakePHP Utility Classes](https://github.com/cakephp/utility) (partial)

This is a partial copy ([v3.0.5](https://github.com/cakephp/utility/releases/tag/3.0.5)) of a library that provides a range of utility classes that are used throughout the CakePHP framework for use in [PHP: Nelson Martell Library](https://github.com/nelson6e65/php_nml).

## What's in the toolbox?

### Text

The Text class includes convenience methods for creating and manipulating strings.

```php
Text::insert(
    'My name is :name and I am :age years old.',
    ['name' => 'Bob', 'age' => '65']
);
// Returns: "My name is Bob and I am 65 years old."

$text = 'This is the song that never ends.';
$result = Text::wrap($text, 22);

// Returns
This is the song
that never ends.
```

Check the [official Text class documentation](http://book.cakephp.org/3.0/en/core-libraries/text.html)
