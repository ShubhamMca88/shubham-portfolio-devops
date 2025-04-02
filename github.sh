#!/bin/bash

# Variables
REPO_DIR="/home/shubham/Documents/Projects/shubham-portfolio"
COMMIT_MESSAGE="update"
BRANCH_NAME="main"

# Ensure the repository directory path is quoted to handle spaces
cd "$REPO_DIR" || { 
    echo "Failed to navigate to repository directory: $REPO_DIR"
    exit 1
}

# Check for uncommitted changes or untracked files
if git diff-index --quiet HEAD -- && [ -z "$(git ls-files --others --exclude-standard)" ]; then
    echo "No changes detected. Nothing to commit."
    exit 0
fi

# Add changes to git
git add .

# Check if a commit message is passed as an argument
if [ -z "$1" ]; then
    git commit -m "$COMMIT_MESSAGE"
else
    git commit -m "$1"
fi

# Push changes to GitHub
git push origin "$BRANCH_NAME"

# Clear the screen
clear

echo "Changes pushed to GitHub successfully."

# -------------------------------------------------------------------
# chmod +x git_to_github.sh         # Make the script executable
# ./git_to_github.sh                # Run the script
