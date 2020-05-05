
## Static JS/CSS

Insert in to document with methods:  
```html
<html>
    <head>
        <? $this->head(); ?>
    </head>
    <body>
        <? $this->body(); ?>

        <?= $content ?>

        <? $this->footer(); ?>
    </body>
</html>
```

$this - link to object View
