
## Application

#### class App

###### Params


| Свойства        | Тип       | Описание          |
| --------------- |:------------------:|:-------------|
| **$params**     | *array*  | параметры астроек полученые из  \app\config\params.php 
| **$alias**      | *array*  | пути в основные дирректории проекта 
| **$paramsList** | *array*  | Объект содержащий список свойств объекта App() 
| **$request**    | *object* | Объект содержащий данные запроса 
| **$route**      | *object* | Объект содержащий данные маршрута 
| **$controller** | *object* | Объект содержащий данные контроллера  
| **$view**       | *object* | Объект содержащий данные представления 
| **$response**   | *object* | Объект содержащий данные ответа на запрос

###### Methods
* *App::setCharset( **string** )*  
Setup charset for all applications 
***Example***:  
App::setAlias( **'utf-8'** )

* *App::getAlias( **string** )*  
path to resource
***Example***:  
App::getAlias( **'@views'** ) => `DOCUMETN_ROOT`/app/views  
App::getAlias( **'@models/Good' . PHP** ) => `DOCUMETN_ROOT`/app/models/Good.php 
