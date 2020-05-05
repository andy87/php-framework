# PHP Framework
Простой фреймворк взявший за основу *концепцию* [yii2](https://github.com/yiisoft/yii2-app-advanced).  
Написан с нуля, без подглядывания *( поставил перд собой задачу: написать фреймворк своими силами )*
    
**сомнительные преимущества проекта :)**  
- отсутствие зависимостей
- концептуально похож на Yii2
- мало весит
- простота

## Иерархия приложения  
Проект в большей степени подражает структуре [yii2](https://github.com/yiisoft/yii2-app-advanced), но не полностью.
```
  app/
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
  _
  ├── 📁 base            # Базовые класы для наследований
  │   └── 📁 prototype   #     диррекория содержащая traits 
  ├── 📁 components      # дирриктория с компонентами фреймворка
  ├── 📁 guide           # дирриктория с гайдами
  │   ├── 📁 en          #     гайд на Английсков
  │   └── 📁 ru          #     гайд на Русском
  ├── 📁 helpers         # спомогательные компоненты
  ├── 📁 runtime         # файлы генерируемые фрейморком
  │   ├── 📁 cache       #     кеш
  │   └── 📁 logs        #     логи
  └── 📁 setups          # настройки фреймворка
  └── 📁 templates       # шаблоны ядра
```


## Структура приложения

[App](/app/_/guide/ru/App.md)  
-- [$params](/app/_/guide/ru/App.md#params_params)  
-- [$aliases](/app/_/guide/ru/App.md#params_aliases)  
-- [$request](/app/_/guide/ru/Request.md)  
------ [$server](/app/_/guide/ru/Library.md)  
------ [$get](/app/_/guide/ru/Library.md)  
------ [$post](/app/_/guide/ru/Library.md)  
------ [$files](/app/_/guide/ru/Library.md)  
------ [$session](/app/_/guide/ru/Session.md)  
------ [$cookie](/app/_/guide/ru/Cookie.md)  
-- [$route](/app/_/guide/ru/Route.md)  
-- [$controller](/app/_/guide/ru/Controller.md)  
------ [$action](/app/_/guide/ru/Action.md)  
-- [$response](/app/_/guide/ru/Response.md)  
-- [$view](/app/_/guide/ru/View.md)  
 
## Логика приложения

  назначаются свойства:
Логика приложения  
Запрос попадает в точку входа `index.php`  
создаётся создаётся экземпляр класса [App](/app/_/guide/ru/App.md)  
в 
 
создаёт экземпляр вызываемого [Controller](/app/_/guide/ru/Controller.md)  
у контроллера последовательно вызывается :  
- [init()](/app/_/guide/ru/Controller.md#method__init)   
- [beforeAction()](/app/_/guide/ru/Controller.md#method__beforeAction)  
- [App](/app/_/guide/ru/App.md)::[$controller](/app/_/guide/ru/Controller.md)->[action](/app/_/guide/ru/Controller.md#params__action)->[getName](/app/_/guide/ru/Action.md#method__getName)()  
- [afterAction()](/app/_/guide/ru/Controller.md#method__beforeAction)  
- action() - отдаёт ответ (text/json/link)
- [App](/app/_/guide/ru/App.md)::[display()](/app/_/guide/ru/App.md#method_display)  

 исходя из формата ответа (
[App](/app/_/guide/ru/App.md)::[$response](/app/_/guide/ru/Response.md)->[format](/app/_/guide/ru/Response.md#params__format) )  
 Совершает действие:
 * в браузер отдаётся текст
 * совершает редирект

*to be continued...* :)






