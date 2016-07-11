Micro PHP FTP Tool
==================

Super micro FTP tool for PHP.

Example
-------

```PHP
$conn = new \itarato\MicPhpFtp\Connection('my.ftp.server.com');

$conn->connect()->login('admin', 'monkey');

$conn->cd('./myfolder');

$listing = $conn->ls();
```
