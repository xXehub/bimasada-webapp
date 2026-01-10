# Deploying this Laravel app to Heroku

This document explains the recommended steps to deploy the project to Heroku.

## 1. Create the Heroku app
1. Install Heroku CLI and log in:
   - `heroku login`
2. Create a new app:
   - `heroku create your-app-name`

## 2. Set buildpacks (Node first, then PHP)
Heroku needs Node to build frontend assets (Vite) and PHP to run Laravel.

```bash
heroku buildpacks:set heroku/nodejs -a your-app-name
heroku buildpacks:add --index 2 heroku/php -a your-app-name
```

## 3. Set required config vars
At minimum set:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` (generate locally and `heroku config:set APP_KEY=base64:...`)
- `DATABASE_URL` (Heroku Postgres add-on provides this)
- `FILESYSTEM_DRIVER=s3` (if using S3)
- `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET` (if S3)
- `QUEUE_CONNECTION=redis` (if using Redis)
- `REDIS_URL` (if using Heroku Redis)

Example to set APP_KEY:
```bash
# generate locally
php artisan key:generate --show
# set on heroku
heroku config:set APP_KEY="base64:..." -a your-app-name
```

## 4. Add a Heroku Postgres and Redis (optional)
```bash
heroku addons:create heroku-postgresql:hobby-dev -a your-app-name
heroku addons:create heroku-redis:hobby-dev -a your-app-name
```

## 5. Filesystem & Storage
Heroku filesystem is ephemeral — use S3 for persistent storage and set `FILESYSTEM_DRIVER=s3`.

## 6. Build & Release behavior
- The Node buildpack will run and run `npm install` and build. We added a `heroku-postbuild` script so Vite builds will run on Heroku.
- The `Procfile` contains a `release` process that runs `php artisan migrate --force` automatically on each deployment.

## 7. Running jobs & scheduler
- The `Procfile` includes a `worker` process for `queue:work`. Scale with:
  `heroku ps:scale worker=1 -a your-app-name`
- For the Laravel scheduler, use the Heroku Scheduler add-on or run a worker that runs `php artisan schedule:run` every minute.

## 8. Deploy
Push your branch to Heroku:
```bash
git push heroku main
```

## 9. Post-deploy checks
- Check logs: `heroku logs --tail -a your-app-name`
- Run one-off commands if needed:
  - `heroku run php artisan migrate --force -a your-app-name`
  - `heroku run php artisan db:seed -a your-app-name`
  - `heroku run php artisan storage:link -a your-app-name`

---
If you want, I can also add a small Ci workflow or `heroku.yml` — tell me which you'd prefer (manual CLI vs GitHub integration).