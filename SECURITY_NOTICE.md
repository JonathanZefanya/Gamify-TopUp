# DATABASE CONFIGURATION TEMPLATE

## SECURITY NOTICE
This file (client.sql) has been removed from git tracking for security reasons.
It contained exposed API secrets that have been cleaned from the repository history.

## Setup Instructions
1. Copy your actual client.sql file to this directory
2. Replace ALL API keys and secrets with environment variables or secure configuration
3. Never commit files containing real API keys to git

## For Flutterwave Configuration
Replace hardcoded values like:
- "Public_Key":"FLWPUBK_TEST-xxxxx" 
- "Secret_Key":"FLWSECK_TEST-xxxxx"
- "Encryption_Key":"FLWSECK_TESTxxxxx"

With environment variable references or secure configuration management.

## Security Best Practices
- Use environment variables for API keys
- Use Laravel's config system for sensitive data
- Never commit .env files
- Regenerate any exposed API keys immediately