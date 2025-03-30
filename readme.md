# Instruções

1- Editar o arquivo .env do laravel que está localizado na pasta backend-api

2- Executar o comando : cp .env.example .env

3- Caso utilize o mailtrap como cliente de teste de e-mails modifique as seguintes variaveis no .env

MAIL_USERNAME=XXXXX

MAIL_PASSWORD=XXXXX

4- Caso utilize outro modifique essas

MAIL_MAILER=XXXXX

MAIL_HOST=XXXXX

MAIL_PORT=XXXXX

MAIL_USERNAME=XXXXX

MAIL_PASSWORD=XXXXX

5- Utilize o comando docker-compose up -d --build para executar o docker.

6- Acessa a rota de login: http://localhost:5173/login

7- Você pode utilizar o administrador criado pelo seeder ou se registrar: admin@tray.net 123456789

