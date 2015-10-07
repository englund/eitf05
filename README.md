# eitf05
Webshop Project in the course EITF05

## Configurations

### php.ini
```
# These settings are the dafult on a Ubuntu 15.04 server but we list these security settings anyway:
expose_php = Off
display_errors = Off
log_errors = On
```

### apache2.conf
```
ServerTokens Prod # make server response header field send back only Apache
```

### virtual host
```
<VirtualHost *:80>
	DocumentRoot /var/www/eitf05
    ServerName localhost

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

    ServerSignature Off
</VirtualHost>

<VirtualHost *:443>
	DocumentRoot /var/www/eitf05
    ServerName localhost

    SSLEngine on
    SSLCertificateFile /var/www/eitf05/ssl/ecofruit.crt
    SSLCertificateKeyFile /var/www/eitf05/ssl/ecofruit.key

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

    ServerSignature Off
</VirtualHost>
```
