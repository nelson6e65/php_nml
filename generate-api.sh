# Get ApiGen.phar
wget http://www.apigen.org/apigen.phar

# Generate Api in temporal dir: ../tmp/api
php apigen.phar generate

# Prepare git dir
mkdir -p ../gh-pages
cd ../gh-pages

# Set identity
git config --global user.email "travis@travis-ci.org"
git config --global user.name "Travis"

# Add branch
git init
git remote add origin https://${GH_TOKEN}@github.com/nelson6e65/php_nml.git > /dev/null
git pull
git checkout gh-pages

# Bring generated api
mv -f ../tmp/api api

# Push generated files
git add .
git commit -m "API updated"
git push origin gh-pages -q > /dev/null
