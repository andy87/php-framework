# PHP Framework
Делается с нуля, своими силамы, бес подглядываний, для демонстрации своего codeStyle и видения разработки
*( поставил перд собой задачу: написать фреймворк своими силами - это же всегда интересно )*  
За основу была взята *концепция* фреймворка [yii2](https://github.com/yiisoft/yii2-app-advanced).  
*framework в процессе разработки...*  
  
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
  #будет позднее
```



### Внутрение зависимости и настройка фремворка

- Namespace'ы начинаются с `_` (нижнего подчёркивания)  
- Всё "мясо" фреймворка лежит в дирректории `app`  
- правила роутинга настрайваются в `app/config/routes.php`
- контроллеры/экшоны в `routes.php` указываются в `lowercase`, при имени контроллера/экшона `CamelCase` имя пишется через тире  
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
Из консоли используя `cd` направляемся в дирректорию `app` в ней используем для генерации файлов, следующие команды: 

- **Генерация контроллера**  
`_ create/controller MyProfile`  
Будет сгенерирован файл: */app/controllers/MyProfileController.php* ([шаблон](/app/_/templates/generator/controller.tpl))  

- **Генерация представления/шаблона**  
`_ create/view landingPage mainPAge`  
Будет сгенерирован файл: */app/views/landing-page/main-page.php* ([шаблон](/app/_/templates/generator/view.tpl))  

- **Генерация модели**  
`_ create/model BestCar table_car`  
Будут сгенерированы 2 файла: */app/models/source/BestCar.php* ([шаблон](/app/_/templates/generator/model-source.tpl)), */app/models/BestCar.php* ([шаблон](/app/_/templates/generator/model.tpl))  

- **Генерация модуля**  
`_ create/module Test`  
Будет сгенерирован файл: */app/modules/Test.php* ([шаблон](/app/_/templates/generator/module.tpl))  

- **Генерация миграций**  
`_ create/migrate Skill`  
можно добавить дполнительные параматры `Имя таблицы`, `Комментарий к таблице`  
**Пример:** `_ create/migrate Skill table_name "Комментарий к таблице"`  
Будет сгенерирован файл: */app/migrations/m000000_000000_Skill.php* ([шаблон](/app/_/templates/generator/migration.tpl))  

### Миграции

прикол в том что я не планировал вводить миграции, а в ходе работы вдруг захотелось. Пришлось их в прямом смысле слова - вкорячить. 
Бога ради не хотел я костыли делать, но один всёже пришлось связаный с CLI.

- **Просмотр списка не зарегистрированных миграцый**  
`_ migrate/list`  
**Пример:**  
```
Migration pending list:
 - m200509_203019_skill
 - m200509_203029_soft
```

- **Выполнить все не зарегистрированные миграции**  
`_ migrate`  
**Пример:**  
```
Migrations:
 - table `table_1` exists!
 - table `table_2` created
 - table `table_3` SQL error
```

### Модели

Реализованы методы **модели**
- one() - возвращает одну подходящюю под запрос моделб (Объект)
- all() - возвращает все подходящие под запрос модели (Объект)
- get() - возвращяет объект Record для дальнейшего вызова методов
- getAll() - возвращяет все записи из таблицы
- select() - указатель какие поля надо вернуть
- where() - усбовия выборки
- andWhere() - дополнительные условия
- limit() - установка limit в SQL запросе
- order() - установка order в SQL запросе
- asArray() - возвращает ответ в виде массива
- asArrayValue() - возвращает массив со значениями( без кючей )
  - (позже будет добавлено) orWhere()  
  - (позже будет добавлено) leftJoin()
  
##### Where
примеры:
```php
    Model::get()->where(['id' => 1]); 
    // WHERE `id` = 1

    Model::get()->where(['name' => 'Admin']); 
    // WHERE `name` = 'Admin'

    Model::get()->where(['id' => [1,2,3,4,5]]); 
    // WHERE `id` IN(1,2,3,4,5)

    Model::get()->where(['email', 'is NOT', NULL]); 
    // WHERE `email` is NOT NULL

    Model::get()->where(['email', '=', '2@mail.ru']); 
    // WHERE `email` = '2@mail.ru'
```

Примеры: 
```php
    $model = User::get()->where(['id' => 1])->one();
    // return: Object User
    //  -> public $username = 'and_y87'
    //  -> public $email = 'e@mail.ru'

    $model = User::get()->where(['id' => 1])->asArray()->one();
    // return: Array(
    //  'username = 'and_y87',
    //  'email' = 'e@mail.ru' )

    $model = User::get()->where(['id' => 1])->asArrayValue()->one();
    // return: Array(
    //  'and_y87',
    //  'e@mail.ru' )

    $model = User::get()->where(['id','<=', 3])->all();
    // return: Array(
    //  Object User $username ='and_y87', $email ='e@mail.ru' ]
    //  Object User $username ='Admin', $email ='bbb@mail.ru' ]
    //  Object User $username ='User', $email ='ccc@mail.ru' ] )

    $model = User::get()->where(['id','<=', 3])->asArray()->all();
    // return: Array(
    //  [ 'username' => 'and_y87', 'email' => 'e@mail.ru' ]
    //  [ 'username' => 'Admin', 'email' => 'bbb@mail.ru' ]
    //  [ 'username' => 'User', 'email' => 'ccc@mail.ru' ] )

    $model = User::get()->where(['id','<=', 3])->asArrayValue()->all();
    // return: Array(
    //  [ 'and_y87', 'e@mail.ru' ]
    //  [ 'Admin', 'bbb@mail.ru' ]
    //  [ 'User', 'ccc@mail.ru' ] )
```

### Логика приложения

Запрос попадает в точку входа `main.php`  
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
- [init()](/app/_/guide/ru/Controller.md#method_init)   
- [rules()](/app/_/guide/ru/Controller.md#method_rules)   
- [beforeAction()](/app/_/guide/ru/Controller.md#method_beforeAction)  
- `$controller->{Action()->target}()`  
- [afterAction()](/app/_/guide/ru/Controller.md#method_beforeAction)  
- [App](/app/_/guide/ru/App.md)::[display()](/app/_/guide/ru/App.md#method_display)   - отдаёт ответ ( text/json/link)
 исходя из формата ответа ( 
[App](/app/_/guide/ru/App.md)::[$response](/app/_/guide/ru/Response.md)->[format](/app/_/guide/ru/Response.md#params_format))  
 
 Совершается действие:
 * в браузер отдаётся текст
 * совершает редирект


### сомнительные преимущества проекта :)
- отсутствие зависимостей
- концептуально похож на Yii2
- мало весит
- простота

## Требования

- php7.0 *или выше*
- MySQL5.5 *или выше*


# Фреймворк в разработке
![php-framework](https://repository-images.githubusercontent.com/260773735/6b62c100-911b-11ea-88f3-90e4777322e0)
Возможно обнаружение:
- нерабочего/отсутствующего функционала
- баги/ошибки
