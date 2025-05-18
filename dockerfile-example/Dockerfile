# это инструкция по сборке образа
# базовый образ - за основу данного образа будет взят postgres
FROM postgres

# окружение postgres - то, что передавали через флаг '-e'
ENV POSTGRES_USER=postgres
ENV POSTGRES_PASSWORD=postgres
ENV POSTGRES_DB=user_db

# перемещение ddl/dml-инициализации в нужную директорию контейнера
# перемещение файла 'init.sql'
COPY ./init.sql /docker-entrypoint-initdb.d/