#========= REQUISITOS DEL SISTEMA =========
"php": "^8.2",

#========== INSTALACION PASOS ======
1-clonar repositorio: https://github.com/luisdaniel9986/larave-mid-level-project-task-api-luisDanielAlvaLujan
2-ejecutar: composer install

3-coloca el .env: 
 ->está en .env_example, construir .env y copiar el contenido.

4-ejecutar migraciones:
php artisan migrate:fresh --seed


#======== PROBAR FILTROS DINÁMICOS ======
-> API PROJECTS:
Route::get('/projects',[ProjectController::class,'getAll']);
-probar con:  http://127.0.0.1:8000/api/projects?name=PROJECTNAME

#====== ACCEDER A DOCUMENTATION DE SWAGGER =====
http://127.0.0.1:8000/api/documentation
levantar con: php artisan l5-swagger:generate







