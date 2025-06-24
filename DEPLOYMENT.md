# Laravel Event Project - Google Cloud Run Deployment

This Laravel application is configured for automatic deployment to Google Cloud Run using GitHub Actions.

## 🚀 Deployment Setup

### Prerequisites
- Google Cloud Project: `winged-polygon-460206-j8`
- GitHub repository with this code
- Google Cloud Run service: `laravel-events`

### GitHub Secrets Configuration

To enable automatic deployment, add the following secret to your GitHub repository:

1. Go to your GitHub repository
2. Navigate to **Settings** → **Secrets and variables** → **Actions**
3. Click **New repository secret**
4. Add the following secret:

**Secret Name:** `GCP_SA_KEY`
**Secret Value:** Copy the entire content of the `github-actions-key.json` file that was generated during setup.

> **Note:** The service account key file contains sensitive information and should never be committed to the repository. It should only be stored securely in GitHub Secrets.

### Automatic Deployment

Once the GitHub secret is configured, the application will automatically deploy to Google Cloud Run when:

- Code is pushed to the `main` branch
- A pull request is merged to the `main` branch

### Deployment Process

The GitHub Actions workflow (`.github/workflows/deploy.yml`) performs the following steps:

1. **Build Docker Image** - Creates a containerized version of the Laravel application
2. **Push to Google Container Registry** - Stores the image in GCR
3. **Deploy to Cloud Run** - Updates the running service with the new image
4. **Run Database Migrations** - Executes Laravel migrations automatically
5. **Output Deployment URL** - Provides the live application URL

### Application URLs

- **Production:** https://laravel-events-972131782399.us-central1.run.app
- **Test Route:** https://laravel-events-972131782399.us-central1.run.app/test

### Manual Deployment (if needed)

If you need to deploy manually:

```bash
# Build and push image
gcloud builds submit --tag gcr.io/winged-polygon-460206-j8/laravel-events .

# Deploy to Cloud Run
gcloud run deploy laravel-events \
  --image gcr.io/winged-polygon-460206-j8/laravel-events \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated \
  --port 8080 \
  --memory 512Mi

# Run migrations
gcloud run jobs create laravel-migrate \
  --image gcr.io/winged-polygon-460206-j8/laravel-events \
  --region us-central1 \
  --command "php" \
  --args "artisan,migrate,--force"

gcloud run jobs execute laravel-migrate --region us-central1
```

### Features

✅ **Automatic Database Migrations** - Runs on container startup
✅ **Error Handling** - Graceful fallback when database issues occur
✅ **SQLite Database** - Lightweight and simple
✅ **Production Ready** - Optimized for Google Cloud Run
✅ **GitHub Actions CI/CD** - Automatic deployment on code changes

### Troubleshooting

- Check GitHub Actions logs for deployment issues
- View Cloud Run logs: `gcloud run services logs read laravel-events --region us-central1`
- Test basic functionality: Visit `/test` route to verify Laravel is working

### Security Notes

- The service account key should be kept secure and only stored in GitHub Secrets
- The application runs with minimal required permissions
- Database is SQLite for simplicity (consider Cloud SQL for production scale)
