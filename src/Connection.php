<?php
/**
 * @file
 */

namespace itarato\MicPhpFtp;

class Connection {

  private $host;

  /**
   * @var int
   */
  private $port;

  /**
   * @var int
   */
  private $timeout;

  /**
   * @var resource
   */
  private $ftpResource;

  public function __construct($host, $port = 21, $timeout = 90) {
    $this->host = $host;
    $this->port = $port;
    $this->timeout = $timeout;
  }

  public function __destruct() {
    if ($this->ftpResource) ftp_close($this->ftpResource);
  }

  public function connect() {
    if (!($this->ftpResource = @ftp_connect($this->host, $this->port, $this->timeout))) {
      throw new ConnectionException("Cannot connect to {$this->host}:{$this->port}.");
    }

    return $this;
  }

  public function login($userName, $password) {
    if (!ftp_login($this->ftpResource, $userName, $password)) {
      throw new ConnectionException('Cannot login.');
    }

    return $this;
  }

  public function ls($dir = './') { return ftp_nlist($this->ftpResource, $dir); }

  public function cd($dir) { return ftp_chdir($this->ftpResource, $dir); }

  public function pwd() { return ftp_pwd($this->ftpResource); }

  public function get($src, $dest, $mode = FTP_BINARY) { ftp_get($this->ftpResource, $dest, $src, $mode); }

}
