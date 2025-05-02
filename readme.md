
# NEO Data Analysis Project

## Introduction 👋

Welcome to my small project! This application allows users to analyze Near-Earth Object (NEO) data, which is fetched from NASA's NEO API: [https://api.nasa.gov/neo/rest/v1](https://api.nasa.gov/neo/rest/v1).

## Getting Started

To begin, you'll need to copy the `.env.example` file to create a fresh `.env` file with the necessary environment variables for the application. Additionally, be sure to generate an API key by signing up at [NASA's API page](https://api.nasa.gov/).

Next, ensure that the default queue is running to execute the scheduled cron jobs properly. You can do this by running the following command:

```bash
php artisan queue:work
```

## Frontend Overview

For authentication, I'm using Laravel's latest authentication features, which provide a robust and flexible authentication system. The frontend components for authentication are provided out of the box by Laravel’s new auth system.

The only custom component I’ve built is the `Dashboard.tsx` component. The rest of the frontend UI components come from Laravel’s built-in authentication system and associated frontend packages.
