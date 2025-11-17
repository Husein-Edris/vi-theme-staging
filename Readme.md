# VI Theme Repository

This repository is part of a WordPress website deployed on AWS EC2 instances. It is specifically concerned with the code changes in the path `/var/www/html/wp-content/themes/vi-theme`.

## Branches

- **main-prod**: This branch is used for production deployments.
- **main-uat**: This branch is used for UAT (User Acceptance Testing) deployments.

## GitHub Actions

The repository uses GitHub Actions to automate the deployment process. When code is pushed to either of the main branches, the corresponding GitHub Action is triggered to deploy the WordPress theme to the appropriate environment.

- **main-prod**: Deploys the theme to the production EC2 instance.
- **main-uat**: Deploys the theme to the UAT EC2 instance.

Both workflows perform the following steps:
1. Checkout the repository.
2. Set up SSH keys for secure access to the EC2 instances.
3. Backup the existing theme on the server.
4. Deploy the new theme content.
5. Restart the Nginx server to apply changes.
6. Clear the Cloudfront cache to ensure the latest version is served.

This setup ensures that any changes pushed to the respective branches are automatically deployed to the correct environment, streamlining the development and deployment process.