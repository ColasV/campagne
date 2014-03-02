<?php

App::uses('AppController', 'Controller');

class VotesController extends AppController {
  public $components = array('Session');
  public $helpers = array('Html', 'Form', 'Session');

  public function index() {

  }

  /**
  * Fonction qui va se charger d'effectuer le vote d'un utilisateur
  * Deux cas :
  *    - L'utilisateur n'est pas authentifié, on lui demande de le faire
  *    - L'utilisateur s'est authentifié, on vérifie celle-ci et on vote  *
  *
  **/
  public function voter($id = -1) {
    if ($this->request->is('post')) {
        $user = $this->request->data['login']['username'];
        $passwd = $this->request->data['login']['password'];

        if($this->isEnsimag($user,$passwd)) {

            if(!in_array($id, array(1,2,3))){
              $this->Session->setFlash('La liste existe pas, retente ta chance','default',array('class'=>'alert alert-danger'));
            } else {

            }

        } else {
          $this->Session->setFlash('Mauvais identifiant','default',array('class'=>'alert alert-danger'));
        }


    } else {
        $this->render('login');
    }







  }



  private function isEnsimag($user,$mdp) {
    $url = "https://intranet.ensimag.fr";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $user.":".$mdp);
    $result = curl_exec($ch);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    if(curl_exec($ch) === false)
    {
        return false;
    }
    else
    {
        return true;
    }

    curl_close($ch);
  }
}
