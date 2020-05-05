
## Статика JS/CSS

Вставляется в документ благодаря методам:  
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

$this - в шаблонах указывает на экземпляр объекта View  
Конкретные методы вывода статики:
$this->renderCss();
