name: Run 3 Min

on:
  workflow_dispatch:

jobs:
  Run3Min:
    runs-on: ubuntu-latest
    environment: Cricket

    steps:
    - name: Checkout repository
      uses: actions/checkout@v2

    - name: Set up PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.1'  # Specify the PHP version you need

    - name: Install Composer
      run: |
        sudo apt update
        sudo apt install -y php php-cli php-curl php-json php-mbstring php-xml git
        curl -sS https://getcomposer.org/installer | php
        sudo mv composer.phar /usr/local/bin/composer
        composer --version  # Verify Composer installation

    - name: Run PHP script in a loop every 5 minutes
      run: |
        while true; do
          curl ${{ secrets.FOOTBALL_PORTAL_URL }}/create_channels/start_workflows.php | php
          curl ${{ secrets.FOOTBALL_PORTAL_URL }}/create_channels/delete_expired.php | php
          sleep 180  # Sleep for 5 minutes
        done
