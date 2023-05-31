# relokiaTest
Тестове завдання PHP Developer
1. Розібратися що таке Help Desk система?.
2. Зареєструвати платформу Zendesk. 
3. Розглянути функціонал обраної системи.
  >Особливу увагу звернути на такі сутності, як Group, Agents, Company, Contact, Ticket. З'ясувати, яка сутність до якої має зв'язки, та чому. 
4. Встановити PhpStorm, Insomnia.
  >Зрозуміти що це за інструменти та для чого. Використовувати їх в процесі виконання завдання.
5. Розібратися що таке Docker, Docker-compose та xDebug, для чого це, як вони працюють.
6. Запустити за допомогою docker-compose два контейнери, nginx та php 7.4, та встановити xdebug в php контейнер. Налаштувати xDebug в PhpStorm і використовувати його для профілювання коду. 
7. Встановити composer (пакетний менеджер). За допомогою composer встановити бібліотеку Guzzle.
8. Підключити autoloader через composer.
9. Написати скрипт, використовуючи принципи ООП, який буде зберігати всі Tickets (умовно у вас більше 10 000 тисяч тікетів) за допомогою API (використовувати бібліотеку Guzzle) із вибраної вами платформи, а також їхні головні сутності. Результатом, повинен бути запис цих тікетів в csv файл. 
  > Headers csv file:
  > Ticket ID, Description, Status, Priority, Agent ID, Agent Name, Agent Email, Contact ID, Contact Name, Contact Email, Group ID, Group Name, Company ID, Company Name, Comments. !!!!!!

# Початкові Налаштування
В папці src є фал .env_exempl. Його потрібно переіменувати в .env і заповнити для отримання доступу по токену на платформу Zendesk. 

Змінні для заповнення:
1. API_SUBDOMAIN - Домен вашої платформи https://{буде тут}.zendesk.com
2. API_EMAIL - пошта адміністратора
3. API_TOKEN - токен який потрібно створити в адмінпанелі (Admin Center -> Apps and integrations -> APIs)

Після налаштувань запустити файл index.php. Він збереже всі задачі в файлик databse.csv


