module.exports = {
    apps: [
        {
            name: "laravel-serve",
            script: "artisan",
            interpreter: "php",
            args: "serve --host=0.0.0.0 --port=8000",
            cwd: ".", // Asegúrate de que esté en la raíz del proyecto
            env: {
                APP_ENV: "local",
                APP_DEBUG: true,
                DB_DATABASE: "api_sanctum",
                DB_USERNAME: "root",
                DB_PASSWORD: "",
                REVERB_APP_ID: "964752",
                REVERB_APP_KEY: "9ri8262cyqzlgdy3jny5",
                REVERB_APP_SECRET: "u61cwo6fahs86kh2jtqn",
            },
        },
        {
            name: "laravel-queue",
            script: "artisan",
            interpreter: "php",
            args: "queue:work",
            cwd: ".",
            env: {
                APP_ENV: "local",
                APP_DEBUG: true,
            },
        },
        {
            name: "laravel-reverb",
            script: "artisan",
            interpreter: "php",
            args: "reverb:start",
            cwd: ".",
            env: {
                APP_ENV: "local",
                REVERB_HOST: "localhost",
                REVERB_PORT: "8080",
                REVERB_SCHEME: "http",
            },
        },
    ],
};
