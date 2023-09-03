# Fountain Parser

[![Fountain CI](https://github.com/stovak/fountain/actions/workflows/ci.yml/badge.svg)](https://github.com/stovak/fountain/actions/workflows/ci.yml)

Fountain is a simple markup syntax that allows screenplays to be written, edited, and shared in plain, human-readable text. Fountain allows you to work on your screenplay anywhere, on any computer, using any software that edits text files.

For more details on Fountain see http://fountain.io.

## Getting started

The simple version for parsing a screenplay text straight into HTML:

```php
    $input = "My fountain input text.";
    $screenplay = new \Fountain\Screenplay();
    $html = $screenplay->parse($input);
```

The longer version is that Fountain first creates a collection of Elements, which you may use for other purposes.
Once the Fountain Elements have been parsed, the FountainTags class determines the correct HTML tags to print. 

```php
    $input = "My fountain input text.";
    // determine fountain elements
    $fountainElements = (new \Fountain\FountainParser())->parse($input);
    // parse fountain elements into html
    $html = (new \Fountain\FountainTags())->parse($fountainElements);
```

## Listening for render events

It is possible to listen for render events. This is useful if you want to do something with the HTML before it is returned.

```php
$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
$eventDispatcher->addListener('fountain.render', function (\Fountain\Event\RenderEvent $event) {
    $event->setHtml(str_replace('horse', 'cat', $event->getHtml()));
});
// Create a new screenplay programmatically...
$it = new \Fountain\Screenplay($eventDispatcher);
$it->elements()->addElement(new NewLine());
$it->elements()->addElement($headExpected);
$it->elements()->addElement(new Action());
$it->elements()->last()->setText("John goes to see a man about a horse.");
$it->elements()->addElement(new Character());
$it->elements()->last()->setText("JOHN");
$it->elements()->addElement(new Parenthetical());
$it->elements()->last()->setText("(to himself)");
$it->elements()->addElement(new Dialogue());
$it->elements()->last()->setText("I wonder if he has any horses for sale.");
// Print that screenplay...
echo (string)$it;
```

## Mentions
The code has been built upon the previous work of these contributors.

 * [Daniel Sheilds](https://github.com/tao/fountain)
 * [Alex King (PHP port)](https://github.com/alexking/Fountain-PHP)
 * [Yousefi & John August (original Objective-C version)](https://github.com/nyousefi/Fountain)
