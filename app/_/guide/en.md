# PHP Framework
A simple framework based on the *concept* [yii2](https://github.com/yiisoft/yii2-app-advanced). 
Written from scratch, without peeping *( I set myself a task: write a framework on my own)* 
  
**dubious advantages of the project :)**
- no dependencies
- conceptually similar to Yii2
- low weight
- simplicity

## Structure
The project imitates the structure to a greater extent [yii2](https://github.com/yiisoft/yii2-app-advanced), but not completely.
```
  app/
  ├── _                 # project core
  ├── config            # Dirrectory with app settings
  │   ├── params.php    # component Settings
  │   ├── routes.php    # configuring routes
  │   └── setups.php    # Settings containing private data
  ├── controllers       # Controllers of your app
  ├── models            # used models of the project
  │   └── source        # source files for models
  ├── satic             # project Static
  │   ├── css           #    Styles
  │   ├── docs          #    Documents
  │   ├── fonts         #    Fonts
  │   ├── img           #    Images
  │   └── js            #    js
  └── views             # Views/Performances
      ├── layouts       #    Dirrectory for view wrappers
      └── site          #    templates for the `site`controller
```

*to be continued...* :)