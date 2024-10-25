# Инициализация

1. Выполнить команду

```bash
docker-compose up --build
```

2. Выполнить обращение к mysql

```bash
docker exec -it mysql_db mysql -uuser -ppassword mouse_db
```

3. Ввести sql-запрос из файла `api\query.sql`. Ожидаемый ответ:

> Query OK, 0 rows affected

4. Потом открыть `Postman`

5. Указать сайт http://localhost:80

6. Написать по одному запросу (ручке) на методы GET и POST - для POST значения передавать в BODY в качестве JSON объекта

7. Протестировать эти методы (сначала создание - POST, потом получение - GET)
