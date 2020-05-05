
## Приложение
#### Класс App
###### Свойства


| Свойства        | Тип       | Описание          |
| --------------- |:------------------:|:-------------|
| **$params**     | *array*  | параметры астроек полученые из  \app\config\params.php 
| **$alias**      | *array*  | пути в основные дирректории проекта 
| **$paramsList** | *array*  | Объект содержащий список свойств объекта App() 
| **[$request](Request.md)**    | *object* | Объект содержащий данные запроса 
| **[$route](Route.md)**      | *object* | Объект содержащий данные маршрута 
| **[$controller](Controller.md)** | *object* | Объект содержащий данные контроллера  
| **[$response](Response.md)**       | *object* | Объект содержащий данные представления 
| **[$view](/app/_/guide/ru/View.md)**   | *object* | Объект содержащий данные ответа на запрос

###### Методы
* **App::setCharset( *string* )**  
Метод задаёт кодировку сразу представлению и ответу  
***Пример***:  
App::setAlias( 'utf-8' )

* **App::getAlias( *string* )**  
метод принимает строку и отдаёт полный путь до необходимого файла  
***Пример***:  
App::getAlias( '@views' ) => DOCUMETN_ROOT . /app/views  
App::getAlias( '@models/Good' . PHP ) => DOCUMETN_ROOT . /app/models/Good.php
