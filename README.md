# GSES2 BTC application - Software Engineering School 3.0 Case

## UI Demo
![demo](https://github.com/maxmyk/gses2-btc-application/blob/master/github-media/demo.png?raw=true)

## Usage

### Importing

```
git clone https://github.com/maxmyk/gses2-btc-application
cd gses2-btc-application
```

### Docker

You should compile the project first using

```
./compile.sh
```

Then run it using

```
./run.sh
```

Or you can type the commands in manually

```
sudo docker build -t gses2-btc-application -f docker/Dockerfile .
sudo docker run -p 80:80 gses2-btc-application
```

Now you can access it on ```http://localhost/```.


### Direct method

Also, you can run it directly from the folder by starting the PHP server

```
sudo php -S localhost:80
```

## General description

#### Functionality:
* Gets the current BTC to UAH ratio.
* Allows users to sign up for email notifications on exchange rate changes.
* Implements a request that sends the current rate to all subscribed users.

#### API Endpoints:
* /rate - GET: Retrieves the current BTC to UAH ratio.
* /subscribe - POST: Allows users to subscribe for email notifications.
* /sendEmails - POST: Sends the current rate to all subscribed users.

#### Data Storage:
* All data required for the application is stored in files.
* Project tree:
```
.
├── api
│   └── index.php
├── compile.sh
├── css
│   └── style.css
├── data
│   └── emails.txt
├── docker
│   └── Dockerfile
├── github-media
│   └── demo.png
├── index.html
├── js
│   └── script.js
├── readme.md
└── run.sh
```

#### Docker:
* Dockerfile is included.

## Important :exclamation:

* You need to have a mail server and configured SMTP to use.
* "Документацію потрібно дотримуватись повною мірою". Accordingly, I commented out several parts of the code regarding responses.