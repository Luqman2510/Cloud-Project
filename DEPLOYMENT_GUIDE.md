# Laravel Event Project - Google Cloud Deployment Guide

## 🚀 Option 1: Google Cloud Run (Recommended)

### Prerequisites
1. Install Google Cloud SDK: https://cloud.google.com/sdk/docs/install
2. Docker installed on your machine
3. Google Cloud Project created

### Step 1: Setup Google Cloud
```bash
# Login to Google Cloud
gcloud auth login

# Set your project ID (replace with your actual project ID)
gcloud config set project YOUR_PROJECT_ID

# Enable required APIs
gcloud services enable run.googleapis.com
gcloud services enable cloudbuild.googleapis.com
gcloud services enable sqladmin.googleapis.com
```

### Step 2: Setup Database (Cloud SQL)
```bash
# Create MySQL instance
gcloud sql instances create laravel-db \
    --database-version=MYSQL_8_0 \
    --tier=db-f1-micro \
    --region=us-central1

# Create database
gcloud sql databases create laravel_events --instance=laravel-db

# Create user
gcloud sql users create laravel-user \
    --instance=laravel-db \
    --password=YOUR_SECURE_PASSWORD
```

### Step 3: Configure Environment
Create a `.env.production` file:
```env
APP_NAME="Laravel Event Project"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-url.run.app

LOG_CHANNEL=stderr

DB_CONNECTION=mysql
DB_HOST=YOUR_CLOUD_SQL_IP
DB_PORT=3306
DB_DATABASE=laravel_events
DB_USERNAME=laravel-user
DB_PASSWORD=YOUR_SECURE_PASSWORD

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
```

### Step 4: Build and Deploy
```bash
# Build the Docker image
docker build -t gcr.io/YOUR_PROJECT_ID/laravel-events .

# Push to Google Container Registry
docker push gcr.io/YOUR_PROJECT_ID/laravel-events

# Deploy to Cloud Run
gcloud run deploy laravel-events \
    --image gcr.io/YOUR_PROJECT_ID/laravel-events \
    --platform managed \
    --region us-central1 \
    --allow-unauthenticated \
    --port 8080 \
    --memory 512Mi \
    --env-vars-file .env.production
```

### Step 5: Run Migrations
```bash
# Get the service URL
SERVICE_URL=$(gcloud run services describe laravel-events --region=us-central1 --format="value(status.url)")

# Run migrations (you'll need to create a migration endpoint or use Cloud Shell)
gcloud run services update laravel-events \
    --region=us-central1 \
    --command="php,artisan,migrate,--force"
```

## 🔧 Option 2: Google Kubernetes Engine (GKE)

### Prerequisites
Same as Cloud Run plus:
```bash
gcloud services enable container.googleapis.com
```

### Step 1: Create GKE Cluster
```bash
gcloud container clusters create laravel-cluster \
    --zone=us-central1-a \
    --num-nodes=2 \
    --machine-type=e2-medium
```

### Step 2: Create Kubernetes Manifests
Create `k8s/deployment.yaml`:
```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: laravel-app
spec:
  replicas: 2
  selector:
    matchLabels:
      app: laravel-app
  template:
    metadata:
      labels:
        app: laravel-app
    spec:
      containers:
      - name: laravel-app
        image: gcr.io/YOUR_PROJECT_ID/laravel-events
        ports:
        - containerPort: 8080
        env:
        - name: APP_ENV
          value: "production"
        - name: DB_HOST
          value: "YOUR_CLOUD_SQL_IP"
---
apiVersion: v1
kind: Service
metadata:
  name: laravel-service
spec:
  selector:
    app: laravel-app
  ports:
  - port: 80
    targetPort: 8080
  type: LoadBalancer
```

### Step 3: Deploy to GKE
```bash
# Get cluster credentials
gcloud container clusters get-credentials laravel-cluster --zone=us-central1-a

# Apply manifests
kubectl apply -f k8s/deployment.yaml

# Get external IP
kubectl get services
```

## 🔍 Troubleshooting

### Common Issues:
1. **Port Configuration**: Cloud Run uses PORT environment variable
2. **Database Connection**: Ensure Cloud SQL IP is whitelisted
3. **File Permissions**: Make sure storage/ and bootstrap/cache/ are writable
4. **Environment Variables**: Use Cloud Run environment variables or Kubernetes secrets

### Logs:
```bash
# Cloud Run logs
gcloud run services logs read laravel-events --region=us-central1

# GKE logs
kubectl logs deployment/laravel-app
```

## 💰 Cost Optimization

### Cloud Run:
- Pay per request
- Automatic scaling to zero
- Best for variable traffic

### GKE:
- Pay for nodes running
- More control over resources
- Best for consistent traffic

## 🔐 Security Considerations

1. **Environment Variables**: Use Google Secret Manager
2. **Database**: Enable SSL connections
3. **Authentication**: Consider Google Identity-Aware Proxy
4. **HTTPS**: Automatically provided by Cloud Run/GKE

## 📝 Next Steps

1. Set up CI/CD with Google Cloud Build
2. Configure monitoring with Google Cloud Operations
3. Set up backup strategy for Cloud SQL
4. Configure custom domain
