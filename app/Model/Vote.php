<?php

App::uses('AppModel', 'Model');

class Vote extends AppModel {

  private $date;
  private $pseudo;
  private $ip;
  private $liste;


  public function setDate($date) {
    $this->date = $date;
  }

  public function setPseudo($pseudo) {
    $this->pseudo = $pseudo;
  }

  public function setIp($ip) {
    $this->ip = $ip;
  }

  public function setListe($liste) {
    $this->liste = $liste;
  }

  public function getData() {
    $array = array('Vote' => array(
      'date' => $this->date,
      'pseudo' => $this->pseudo,
      'ip' => $this->ip,
      'liste' => $this->liste,
    ));

    return $array;

  }

}
