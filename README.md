
# Framerate

A forum created with Laravel, Inertia and VueJS

## Local Environment

Download the project
```bash
git clone 
```

Copy the .env.example file and change as necessary
```bash
cp .env.example .env
```

Install dependencies
```bash
composer install
```

Upgrade the server with Laravel Sail
```bash
sail up -d
```

Generate a new key if it does not exist
```bash
sail artisan key:generate
```

Run front-end development
```bash
sail npm run dev
```

And access the url [http://localhost](http://localhost) in the browser


## Stack used

**Front-end:** VueJs with Composition API

**Back-end:** Laravel 10 and Inertia

**Devops:** Docker

