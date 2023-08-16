#!/bin/bash

PRE_PUSH_HOOK=".git/hooks/pre-push"

# Create pre-push hook if it doesn't exist
if [ ! -f "$PRE_PUSH_HOOK" ]; then
    cat > "$PRE_PUSH_HOOK" <<EOL
#!/bin/bash

# Run Laravel Sail tests
./vendor/bin/sail artisan test

# Capture the exit code of the previous command
result=\$?

# Exit with the result code
exit \$result
EOL

    chmod +x "$PRE_PUSH_HOOK"
    echo "Pre-push hook has been installed successfully."
else
    echo "Pre-push hook already exists. No action taken."
fi