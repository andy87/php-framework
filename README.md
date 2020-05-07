# PHP Framework

Простой фреймворк, буквально почти самый простой в мире.
За основу была взята *концепция* фреймворка [yii2](https://github.com/yiisoft/yii2-app-advanced). 
Написан с нуля, своими силамы, для демонстрации своего codeStyle, используемых концепций, паттернов и т.п. 
*( поставил перд собой задачу: написать фреймворк своими силами - это же всегда интересно )*
  
**сомнительные преимущества проекта :)**  
- отсутствие зависимостей
- концептуально похож на Yii2
- мало весит
- простота



## Иерархия приложения 
 
Проект в большей степени подражает структуре yii2, но не полностью.
```
  📁 app
  ├── 📁 _                       # ядро проекта
  ├── 📁 config                  # Дирректория с настройками приложения
  │   ├── 📁 setups              # Дирректория с настройками для конкретного хоста ( HOST_NAME )
  │   │   └── 📄 localhost.php   # Приватные настройки с реквизитами для подключений (Пример: HOST_NAME localhost )
  │   ├── 📄 params.php          # Настройки компонентов
  │   ├── 📄 routes.php          # Настройка маршрутов
  ├── 📁 controllers             # Контроллеры вашего приложения
  │   └── 📄 SiteController.php  #    Пример: Контроллер Site
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
  
для тех кто в теме и кому интересно что у фреймворка ~~под лифчиком~~ под капотом.
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
      └── 📁 generator           #     генерируемые шаблоны
      └── 📁 errors              #     страницы ошибок 403/404/500/502/504/502
```



### Установка

Используя консоль в связке с командой `cd` проникаете в дирректорию с будующим проектом и используете команду

`git clone https://github.com/andy87/php-framework .`



#### Apache 
 
При использовании web-сервера `Apache`   
в корне проекта требуется наличие файла `.htaccess` с минимальным содержимым:
```
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
ErrorDocument 404 /app/_/templates/errors/404.php
# ... 403/500/502/504/508
```



#### Nginx  

При использовании web-сервера `Nginx`  
минимальные настройки:
```
server {
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



### Внутрение зависимости и настройка фремворка

- Namespace'ы начинаются с `_` (нижнего подчёркивания)  
- Всё "мясо" фреймворка лежит в дирректории `app`  
- правила роутинга настрайваются в `app/config/routes.php`
- контроллеры/экшоны в `routes.php` указываются в `lowercase`, при имени `CamelCase` через тире  
**Пример:** роут `uri => main-server/restart-now` вызовит контроллер `MainServerController` экшон `actionRestartNow` 
- Настройки подключения для домена настрайваются в `app/config/setups/ {HOST_NAME} .php`    
- Models настледуется от `BaseModels`  
- Controller настледуется от `BaseController`  
- Имена Controller'ов имеют суфикс `Controller`  
**Пример:** контроллер `Main` имеет имя файла класса `MainController`  
- Имена Action'ов имеют префикс `action`  
**Пример:** экшон `Login` имеет имя метода `actionLogin`  
- экшон должен вернуть  
-- для вывода **HTML** - результат **render()**  
-- для вывода **JSON** - возвращать **renderJson()** либо **return array**  


### Генерация файлов
Из консоли используя `cd` направляемся в дирректорию `app` в ней используем для генерации фалйов, следующие команды: 

##### Генерация контроллера  
`_ create/controller Profile` 
 
##### Генерация представления/шаблона  
`_ create/view landing main` 

##### Генерация модели  
`_ create/model Access`  
 
##### Генерация модуля  
`_ create/module Test`  

### Логика приложения

Запрос попадает в точку входа `index.php`  
Создаёть экземпляр класса [App()](/app/_/guide/ru/App.md)  
Устанавливаются все свойства [App()](/app/_/guide/ru/App.md)  
В экземпляре класса [Route()](/app/_/guide/ru/Route.md)   
- Ищется подходящее правило в [Route](/app/_/guide/ru/Route.md)::[$rules](/app/_/guide/ru/Route.md#param__rules)  
- Из подхзодящего правила Задаются ID для:    
- [Route](/app/_/guide/ru/Route.md)::[$controller](/app/_/guide/ru/Route.md#param__controller)  
- [Route](/app/_/guide/ru/Route.md)::[$action](/app/_/guide/ru/Route.md#param__action)  

Создаёт экземпляр класса [Controller()](/app/_/guide/ru/Controller.md)  
- устанавливается свойство [$id](/app/_/guide/ru/Controller.md#params_id)  
- устанавливается свойство [$target](/app/_/guide/ru/Controller.md#params_target)  
- создаёт экземпляр класса [Action()](/app/_/guide/ru/Action.md)  
- устанавливается свойство [$id](/app/_/guide/ru/Action.md#params_id)  
- устанавливается свойство [$target](/app/_/guide/ru/Action.md#params_target)  

Создаётся экземпляр пользовательского контроллера по имени [Controller](/app/_/guide/ru/Controller.md)::[$target](/app/_/guide/ru/Controller.md#params_target). 
далее у пользовательского контроллера последовательно вызывается методы:  
у контроллера [Controller](/app/_/guide/ru/Controller.md)::[$target](/app/_/guide/ru/Controller.md#params_target) последовательно вызывается методы:  
- [init()](/app/_/guide/ru/Controller.md#method_init)   
- [rules()](/app/_/guide/ru/Controller.md#method_rules)   
- [beforeAction()](/app/_/guide/ru/Controller.md#method_beforeAction)  
- `$controller->{Action()->target}()`  
- [afterAction()](/app/_/guide/ru/Controller.md#method_beforeAction)  
- [App](/app/_/guide/ru/App.md)::[display()](/app/_/guide/ru/App.md#method_display)   - отдаёт ответ ( text/json/link)
 исходя из формата ответа ( 
[App](/app/_/guide/ru/App.md)::[$response](/app/_/guide/ru/Response.md)->[format](/app/_/guide/ru/Response.md#params_format))  
 
 Совершает действие:
 * в браузер отдаётся текст
 * совершает редирект



## Требования

- php5.2 *или выше*
- MySQL 5.5 *или выше*

*framework в процессе разработки...*