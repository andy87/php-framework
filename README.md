# PHP Framework
Простой фреймворк взявший за основу *концепцию* [yii2]( https://github.com/yiisoft/yii2-app-advanced ).  
Написан с нуля, без подглядывания *( поставил перд собой задачу: написать фреймворк своими силами )*
    
    
**сомнительные преимущества проекта : )**  
- отсутствие зависимостей
- концептуально похож на Yii2
- мало весит
- простота

## Иерархия приложения  
Проект в большей степени подражает структуре [yii2]( https://github.com/yiisoft/yii2-app-advanced ), но не полностью.
```
  📁 app
  ├── 📁 _                       # ядро проекта
  ├── 📁 config                  # Дирректория с настройками приложения
  │   ├── 📄 params.php          # Настройки компонентов
  │   ├── 📄 routes.php          # Настройка маршрутов
  │   └── 📄 setups.php          # Настройки содержащие приватные данные
  ├── 📁 controllers             # Контроллеры вашего приложения
  │   └── 📄 SiteController.php  #    Контроллер Site
  ├── 📁 models                  # Используемые модельки проекта 
  │   └── 📁 source              #    Исходные файлы моделек
  ├── 📁 satic                   # Статика проекта
  │   ├── 📁 css                 #    Стили
  │   ├── 📁 docs                #    Документы
  │   ├── 📁 fonts               #    Шрифты
  │   ├── 📁 img                 #    Картинки
  │   └── 📁 js                  #    js
  └── 📁 views                   # Вьюхи/Представления
      ├── 📁 layouts             #    Дирректория для обёрток вьюх
      └── 📁 site                #    шаблоны для контроллера `site`
```

#### Иерархия ядра  
```
  📁 _
  ├── 📁 base                    # Базовые класы для наследований
  │   └── 📁 prototype           #     диррекория содержащая traits 
  ├── 📁 components              # дирриктория с азовыми компонентами фреймворка
  │   └── 📁 main                #     Основные компоненты App() 
  ├── 📁 guide                   # дирриктория с гайдами
  │   ├── 📁 en                  #     гайд на Английсков
  │   └── 📁 ru                  #     гайд на Русском
  ├── 📁 helpers                 # вспомогательные компоненты
  ├── 📁 runtime                 # файлы генерируемые фрейморком
  │   ├── 📁 cache               #     кеш
  │   └── 📁 logs                #     логи
  ├── 📁 setups                  # настройки фреймворка
  │   ├── 📄 autoload.php        #     настройка автозагрузки классов
  │   └── 📄 const.php           #     Список констант
  └── 📁 templates               # шаблоны ошибок
```


## Установка

Используя консоль в связке с командой `cd` проникаете в дирректорию с будующим проектом и используете команду

`git clone https://github.com/andy87/php-framework .`

#####Apache
При использовании web-сервера `Apache` в корне проекта требуется наличие файла `.htaccess`  
минимальное содержимое:
```
AddDefaultCharset utf-8 

<IfModule mod_autoindex.c>
   Options -Indexes
</IfModule>

<IfModule mod_rewrite.c>

   Options +FollowSymlinks
   RewriteEngine On

   RewriteCond %{REQUEST_URI}      ^/(js|css|img|docs|fonts|static)
   RewriteRule ^js/(.*)$            app/static/js/$1       [L]
   RewriteRule ^css/(.*)$           app/static/css/$1      [L]
   RewriteRule ^img/(.*)$           app/static/img/$1      [L]
   RewriteRule ^docs/(.*)$          app/static/docs/$1     [L]
   RewriteRule ^fonts/(.*)$         app/static/fonts/$1    [L]
   RewriteRule ^static/(.*)$        app/static/$1    [L]

   RewriteCond %{REQUEST_URI}       !^/app/static/
   RewriteCond %{REQUEST_FILENAME}  !favicon.ico

   RewriteCond %{REQUEST_FILENAME}  !-f [OR]
   RewriteCond %{REQUEST_FILENAME}  !-d

   RewriteRule ^(.*)$               app/$1

</IfModule>

# При желании
ErrorDocument 404 /app/_/templates/error_404.php
# ... 403/500/502/504/508

```
#####Nginx
При использовании web-сервера `Nginx` минимальные настройки следующие:
```
server {
    charset utf-8;
    
    listen 80 default_server;
    listen [::]:80 default_server;
    
    server_name mysite.local; #имя вашего домена
    root        /app;

    index       index.php;
    
    access_log  /app/_/runtime/logs/access.log;
    error_log   /app/_/runtime/logs/error.log;
    
    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php$is_args$args;
    }
    
    # При желании
    #error_page 404 /app/_/templates/errors/404.php;
    # ... 403/500/502/504/508
    
    # deny accessing php files for the /assets directory
    location ~ ^/(static|js|css|img|docs|fonts)/.*\.php$ {
        deny all;
    }
   
    location ~ \.php$ {
       include snippets/fastcgi-php.conf;
       fastcgi_pass unix:/run/php/php7.2-fpm.sock;
    }
}   
```


## Структура приложения

[App]( /app/_/guide/ru/App.md )  
-- [$params]( /app/_/guide/ru/App.md#params__params )  
-- [$aliases]( /app/_/guide/ru/App.md#params__aliases )  
-- [Request()]( /app/_/guide/ru/App.md#params__request )  
------ [Server()]( /app/_/guide/ru/Request.md#params__server )  
------ [Get()]( /app/_/guide/ru/Request.md#params__get )  
------ [Post()]( /app/_/guide/ru/Request.md#params__post )  
------ [Files()]( /app/_/guide/ru/Request.md#params__files )  
------ [Session()]( /app/_/guide/ru/Request.md#params__session )  
------ [Cookie()]( /app/_/guide/ru/Request.md#params__cookie )  
-- [Route()]( /app/_/guide/ru/App.md#params__route )  
-- [Controller()]( /app/_/guide/ru/App.md#params__controller )  
------ [Action()]( /app/_/guide/ru/Controller.md#params__action )  
-- [Response()]( /app/_/guide/ru/App.md#params__response )  
-- [View()]( /app/_/guide/ru/App.md#params__view )  
 
## Логика приложения

Запрос попадает в точку входа `index.php`  
Создаётся экземпляр класса [App()]( /app/_/guide/ru/App.md ), устанавливаются все его свойства  
-- создаёт экземпляр класса [Route()]( /app/_/guide/ru/Route.md )  
---- Ищется подходящее правило в [Route]( /app/_/guide/ru/Route.md )::[$rules]( /app/_/guide/ru/Route.md#param__rules )  
---- Из найденного rules Задаются ID для:    
------ [Route]( /app/_/guide/ru/Route.md )::[$controller]( /app/_/guide/ru/Route.md#param__controller )  
------ [Route]( /app/_/guide/ru/Route.md )::[$action]( /app/_/guide/ru/Route.md#param__action )  
-- создаёт экземпляр класса [Controller()]( /app/_/guide/ru/Controller.md )  
---- устанавливается свойство [$id]( /app/_/guide/ru/Controller.md#params__id )  
---- устанавливается свойство [$target]( /app/_/guide/ru/Controller.md#params__target )  
---- создаёт экземпляр класса [Action()]( /app/_/guide/ru/Action.md )  
------ устанавливается свойство [$id]( /app/_/guide/ru/Action.md#params__id )  
------ устанавливается свойство [$target]( /app/_/guide/ru/Action.md#params__target )  
Создаётся экземпляр пользовательского контроллера по имени [Controller]( /app/_/guide/ru/Controller.md )::[$target]( /app/_/guide/ru/Controller.md#params__target ).   
далее у пользовательского контроллера последовательно вызывается методы:  
у контроллера [Controller]( /app/_/guide/ru/Controller.md )::[$target]( /app/_/guide/ru/Controller.md#params__target ) последовательно вызывается методы:  
- [init()]( /app/_/guide/ru/Controller.md#method__init )   
- [rules()]( /app/_/guide/ru/Controller.md#method__rules )   
- [beforeAction()]( /app/_/guide/ru/Controller.md#method__beforeAction )  
- `$controller->{Action()->target}()`  
- [afterAction()]( /app/_/guide/ru/Controller.md#method__beforeAction )  
- [App]( /app/_/guide/ru/App.md )::[display()]( /app/_/guide/ru/App.md#method_display )   - отдаёт ответ ( text/json/link )

 исходя из формата ответа ( 
[App]( /app/_/guide/ru/App.md )::[$response]( /app/_/guide/ru/Response.md )->[format]( /app/_/guide/ru/Response.md#params__format ) )  
 Совершает действие:
 * в браузер отдаётся текст
 * совершает редирект


## Требования
- php5.2 *или выше*
- MySQL 5.5 *или выше*

*framework в процессе разработки...*