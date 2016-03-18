# Generate API after download composer dev-requirements
nml_ver=$(git describe)

# Generate Api in: build/api
vendor/bin/apigen generate

# Set identity
git config --global user.email "travis@travis-ci.org"
git config --global user.name "Travis"

# Checkout to GitHub pages to update API
git remote add travis https://${GH_TOKEN}@github.com/nelson6e65/php_nml.git > /dev/null
git checkout -b apigen travis/gh-pages

# Clean current (old) api directory
rm -rf api

# Bring generated (new) api directory
cp -rf build/api api && rm -rf build/api

# Push generated files
git add --all .
git commit -m "ApiGen: API updated ($nml_ver)."
git push --quiet > /dev/null
