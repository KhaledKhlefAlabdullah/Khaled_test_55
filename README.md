# Satreps dev Back end

This repository contains the back-end code for the satreps-dev project. The back-end is built using the Laravel
framework and can be easily set up using Docker.

## Getting Started

Follow the instructions below to set up and run the project locally using Docker.

### Prerequisites

- Docker: Ensure you have Docker installed on your machine. You can download and install Docker
  from [https://www.docker.com/get-started](https://www.docker.com/get-started).

### Installation

1. Clone the repository to your local machine:

   ```bash
   git clone http://vmi33328.contaboserver.net:1000/root/satreps-dev-back-end.git
   ```

2. Navigate to the project directory:

   ```bash
   cd satreps-dev-back-end
   ```

3. Copy the `.env.example` file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```

4. Update the `.env` file with your preferred configuration settings, including database credentials.

### Running with Docker

1. Build the Docker images and start the containers:

   ```bash
   docker-compose up -d --build
   ```

2. Generate an application key:

   ```bash
   php artisan key:generate
   ```

3. Run database migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

4. The Laravel application should now be running at [http://localhost:8080](http://localhost:8080).

### Stopping the Application

To stop the application and shut down the Docker containers, run:

```bash
docker-compose down
```

### Accessing Logs

To access the logs of the running containers, you can use the following command:

```bash
docker-compose logs -f
```

### Troubleshooting

If you encounter any issues during the setup process, please check the logs for any error messages. If you're unable to
resolve the issue, feel free to open an issue on this repository.

## Contributing

Contributions are welcome! If you find any bugs or have suggestions for improvement, please open an issue or create a
pull request.

---
