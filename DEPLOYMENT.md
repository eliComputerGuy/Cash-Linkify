# Cash Linkify - Render Deployment Guide

## Prerequisites

1. **GitHub Repository**: Ensure your project is pushed to GitHub
2. **Render Account**: Sign up at [render.com](https://render.com)
3. **Database**: Set up a PostgreSQL database (you can use Render's PostgreSQL service)

## Step-by-Step Deployment

### 1. Prepare Your Repository

Ensure these files are in your repository:
- `render.yaml` - Render configuration
- `Dockerfile` - Docker configuration
- `docker/apache.conf` - Apache configuration
- `deploy.sh` - Deployment script

### 2. Create Render Account

1. Go to [render.com](https://render.com)
2. Sign up with your GitHub account
3. Connect your GitHub repository

### 3. Deploy Web Service

1. **Click "New +"** → **"Web Service"**
2. **Connect your GitHub repository**
3. **Configure the service**:
   - **Name**: `cash-linkify`
   - **Environment**: `Docker`
   - **Build Command**: (Leave empty - Docker will handle this)
   - **Start Command**: (Leave empty - Docker will handle this)

### 4. Set Environment Variables

Add these environment variables in Render dashboard:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-generated-key
APP_URL=https://your-app-name.onrender.com
DB_CONNECTION=pgsql
DB_HOST=your-postgresql-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
LOG_CHANNEL=stack
```

### 5. Set Up Database

1. **Create PostgreSQL Database**:
   - Click "New +" → "PostgreSQL"
   - Choose your plan (Free tier available)
   - Note the connection details

2. **Update Environment Variables** with your database details

### 6. Deploy

1. **Click "Create Web Service"**
2. **Wait for deployment** (5-10 minutes)
3. **Check logs** for any errors

### 7. Post-Deployment Setup

After successful deployment:

1. **Run migrations**: Use Render's shell or add to build command
2. **Seed database**: Run `php artisan db:seed`
3. **Set up storage**: Ensure storage link is created

## Environment Variables Reference

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_ENV` | Application environment | `production` |
| `APP_DEBUG` | Debug mode | `false` |
| `APP_KEY` | Application encryption key | `base64:...` |
| `APP_URL` | Application URL | `https://app.onrender.com` |
| `DB_HOST` | Database host | `your-postgresql-host` |
| `DB_DATABASE` | Database name | `cash_linkify` |
| `DB_USERNAME` | Database username | `user` |
| `DB_PASSWORD` | Database password | `password` |

## Troubleshooting

### Common Issues

1. **Build Fails**:
   - Check composer.json for errors
   - Ensure all dependencies are in `require` (not `require-dev`)

2. **Database Connection**:
   - Verify database credentials
   - Check if database is accessible from Render

3. **Storage Issues**:
   - Ensure storage directory is writable
   - Check if storage link is created

4. **500 Errors**:
   - Check application logs
   - Verify APP_KEY is set
   - Ensure all environment variables are configured

### Useful Commands

```bash
# Check application logs
php artisan log:clear

# Clear all caches
php artisan optimize:clear

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link
```

## Performance Optimization

1. **Enable Caching**:
   - Config cache: `php artisan config:cache`
   - Route cache: `php artisan route:cache`
   - View cache: `php artisan view:cache`

2. **Optimize Autoloader**:
   - `composer install --optimize-autoloader --no-dev`

3. **Use CDN** for static assets

## Security Checklist

- [ ] `APP_DEBUG=false`
- [ ] Strong `APP_KEY`
- [ ] Secure database credentials
- [ ] HTTPS enabled
- [ ] Environment variables set
- [ ] File permissions correct

## Support

For issues:
1. Check Render logs
2. Review Laravel logs
3. Verify environment variables
4. Test locally with production settings
