# Get ApiGen.phar
[[ ! -f "apigen.phar" ]] && wget http://www.apigen.org/apigen.phar

nml_ver=$(git describe)

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

# Clean current api (old)
rm -rf api

# Bring generated api (updated)
cp -rf ../tmp/api api && rm -rf ../tmp/api

# Push generated files
git add --all .
git commit -m "API updated ($nml_ver)"
git push origin gh-pages -q > /dev/null
