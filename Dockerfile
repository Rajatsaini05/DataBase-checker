# Use your pushed Docker image as the base image
FROM RajatSaini/laravel-octane:latest

COPY . .
# Install Laravel Octane and its dependencies
RUN composer require laravel/octane --with-all-dependencies

# Set up cron jobs (ensure cron.conf is correct)
# COPY cron.conf /etc/cron.d/cron.conf
# RUN chmod 0644 /etc/cron.d/cron.conf && crontab /etc/cron.d/cron.conf

# Ensure entrypoint script is executable
RUN chmod +x Docker/entrypoint.sh

# Expose the port that Laravel Octane will listen on
EXPOSE 80
ENV PORT=80

# Start the entrypoint script
ENTRYPOINT [ "Docker/entrypoint.sh" ]
