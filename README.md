## Talenavi Technical Test (Todo List API)

### How to run project in local:
- clone the project
```
git clone https://github.com/kiritoriq-bot/talenavi-tech-test.git
```
- go to the app dir
```
cd talenavi-tech-test
```
- create .env files by copying .env.example
```
cp .env.example .env
```
- and then setup your database configurations
- install composer by running:
```
composer install
```
- after all done, run commands below:
```
php artisan key:generate
php artisan migrate
```
- serve to localhost by running command:
```
php artisan serve
```
- or you can specify in which port the project have to run
```
php artisan serve --port=your-port
```
The project will run in localhost:your-port

### App Demo Presentation
1. Build Create Todo List API
- request body
  ![image.png](.github/images/create-todos-body.png)
- response
  ![image.png](.github/images/create-todos-response.png)
2. Build Export Todo List to Excel API
- test 1 request
  ![image.png](.github/images/export-todos-request-1.png)
- test 1 result
  ![image.png](.github/images/export-todos-result-1.png)
- test 2 request
  ![image.png](.github/images/export-todos-request-2.png)
- test 2 result
  ![image.png](.github/images/export-todos-result-2.png)
3. Build Get Todo List Chart API
- chart status
  ![image.png](.github/images/get-chart-status.png)
- chart priority
  ![image.png](.github/images/get-chart-priority.png)
- chart assignee
  ![image.png](.github/images/get-chart-assignee.png)
