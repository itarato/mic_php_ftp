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

  /**
   * Connection constructor.
   *
   * @param $host
   * @param int $port
   * @param int $timeout
   */
  public function __construct($host, $port = 21, $timeout = 90) {
    $this->host = $host;
    $this->port = $port;
    $this->timeout = $timeout;
  }

  public function __destruct() {
    if ($this->ftpResource) ftp_close($this->ftpResource);
  }

  /**
   * @return $this
   * @throws \itarato\MicPhpFtp\ConnectionException
   */
  public function connect() {
    if (!($this->ftpResource = @ftp_connect($this->host, $this->port, $this->timeout))) {
      throw new ConnectionException("Cannot connect to {$this->host}:{$this->port}.");
    }

    return $this;
  }

  /**
   * @param $userName
   * @param $password
   * @return $this
   * @throws \itarato\MicPhpFtp\ConnectionException
   */
  public function login($userName, $password) {
    if (!ftp_login($this->ftpResource, $userName, $password)) {
      throw new ConnectionException('Cannot login.');
    }

    return $this;
  }

  /**
   * @return bool
   */
  public function setPassiveModeOn() { return ftp_pasv($this->ftpResource, TRUE); }

  /**
   * @param string $dir
   * @return string[]
   */
  public function ls($dir = './') { return ftp_nlist($this->ftpResource, $dir); }

  /**
   * @param $dir
   * @return bool
   */
  public function cd($dir) { return ftp_chdir($this->ftpResource, $dir); }

  /**
   * @return string
   */
  public function pwd() { return ftp_pwd($this->ftpResource); }

  /**
   * @param $src
   * @param $dest
   * @param $mode
   * @return bool
   */
  public function get($src, $dest, $mode = FTP_BINARY) { return ftp_get($this->ftpResource, $dest, $src, $mode); }

}
