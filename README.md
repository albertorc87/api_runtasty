# Api y panel con symfony4

## Panel

Para acceder al panel lo debes hacer desde la página principal, por ejemplo si tienes configurado tu localhost sería así http://localhost/

Aparecen dos inputs y habrá que rellenar al menos uno para que se active el botón de búsqueda.

## Api

La url de acceso a la api es esta:

http://localhost/api/v1/find

La api puede recibir tres parámetros que son estos:

* ingredients
* search
* page

Para que funcione al menos ingredients o search deben tener datos.

Los datos se envía mediante post, si los intentas enviar por get mostrará un error.

Ejemplo de respuesta válida:

```json
{
    "status": "Success",
    "code": 200,
    "msg": "OK",
    "results": [
        {
            "title": "Creamy Scrambled Eggs Recipe Recipe",
            "href": "http://www.grouprecipes.com/43522/creamy-scrambled-eggs-recipe.html",
            "ingredients": "onions",
            "thumbnail": "http://img.recipepuppy.com/373064.jpg"
        },
        {
            "title": "Blue Ribbon Meatloaf",
            "href": "http://www.eatingwell.com/recipes/meatloaf.html",
            "ingredients": "onions",
            "thumbnail": "http://img.recipepuppy.com/694321.jpg"
        },
        {
            "title": "Spaghetti with Clams & Corn",
            "href": "http://www.eatingwell.com/recipes/spaghetti_clams_corn.html",
            "ingredients": "onions",
            "thumbnail": "http://img.recipepuppy.com/698569.jpg"
        },
    ]
}
```

Ejemplo de respuesta errónea:

```json
{
    "status": "Error",
    "code": 400,
    "msg": "You must at least the param \"ingredients\" or \"search\""
}
```

## Test unitarios

La api dispone de test unitarios, para usarlos simplemente lanza el siguiente comando:

```
php bin/phpunit
```

El script del test se encuentra en la carpeta:

```
tests/Controller/Api/V1/FindControllerTest.php
``` 
