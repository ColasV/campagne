<?php

App::uses('AppController', 'Controller');
App::uses('Vote', 'Model');
App::import('Lib', 'Captcha');

class VotesController extends AppController {
  public $components = array('Session');
  public $helpers = array('Html', 'Form', 'Session');


  /* Index de notre site
  * On se charge ici de calculer les valeurs pour le graphique
  *
  *
  */
  public function index() {

  /* Recupère le nombre de vote pour chaque liste au total */
  for($i = 1 ; $i <= 3 ; $i++) {
    $conditions = array('Vote.liste' => $i);
    $donnees = $this->Vote->find('count',array('conditions'=>$conditions));
    $this->set('liste_'.$i,$donnees);
  }

  /* On recupère maintenant le nombre de vote dans une même heure pour chaque liste */
  $liste_1 = $this->Vote->query('SELECT COUNT(*) as c,date FROM votes WHERE liste = 1 GROUP BY date ORDER BY date');
  $liste_2 = $this->Vote->query('SELECT COUNT(*) as c,date FROM votes WHERE liste = 2 GROUP BY date ORDER BY date');
  $liste_3 = $this->Vote->query('SELECT COUNT(*) as c,date FROM votes WHERE liste = 3 GROUP BY date ORDER BY date');

  $this->set(array('liste1' => $liste_1,'liste2' => $liste_2,'liste3' => $liste_3));

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
        $user = trim(strtolower($this->request->data['login']['username']));
        $passwd = $this->request->data['login']['password'];

        if($this->isEnsimag($user,$passwd)) {

            if(!in_array($id, array(1,2,3))) {
              $this->Session->setFlash('La liste existe pas, retente ta chance','default',array('class'=>'alert alert-danger'));
              return $this->redirect(
                array('controller' => 'Votes', 'action' => 'index')
              );
            } else {
              /* On vérifie d'abord que la personne n'a pas voté dans la dernière heure */
              $conditions = array("Vote.pseudo" => $user, "Vote.date" => date('Y-m-d H:0:0',time()));
              $old = $this->Vote->find('first', array('conditions' => $conditions));

              if($old) {
                $this->Session->setFlash('Tu as déjà voté, reviens dans une heure!','default',array('class'=>'alert alert-danger'));
                return $this->redirect(
                  array('controller' => 'Votes', 'action' => 'index')
                );
              } else {
                /* On cree un Objet de type Vote */
                $vote = new Vote();
                $vote->setDate(date('Y-m-d H:0:0',time()));
                $vote->setPseudo($user);
                $vote->setIp($this->request->clientIp());
                $vote->setListe($id);

                /* Code captcha */
                //$privatekey = "6LddPfASAAAAAK4whq9aR9Y2tf8uubD_xYjbfpdT";
                //$resp = recaptcha_check_answer ($privatekey,
                //$_SERVER["REMOTE_ADDR"],
                //$_POST["recaptcha_challenge_field"],
                //$_POST["recaptcha_response_field"]);




                if ($this->request->clientIp() == '176.31.119.176' OR $this->request->clientIp() == '46.193.0.139' ) {
                  $this->Session->setFlash('On arrête de scripter','default',array('class'=>'alert alert-danger'));
                  return $this->redirect(
                    array('controller' => 'Votes', 'action' => 'index')
                  );
                } else {
                    $this->Vote->save($vote->getData());
                    $this->Session->setFlash('Ton vote a été pris en compte','default',array('class'=>'alert alert-success'));
                    return $this->redirect(
                      array('controller' => 'Votes', 'action' => 'index')
                    );

                }




                }
          }

        } else {
          $this->Session->setFlash('Mauvais identifiant','default',array('class'=>'alert alert-danger'));
          return $this->redirect(
            array('controller' => 'Votes', 'action' => 'voter',$id)
          );
        }


    } else {
        /* Si on a pas de formulaire, alors on propose de s'authentifier */
        $this->render('login');
    }
}

/**
* Fonction qui se charge de vérifier l'authentification des élèves
* sur le portail Ensimag
*
*/

  private function isEnsimag($user,$mdp) {
    $url = "https://intranet.ensimag.fr";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $user.":".$mdp);
    $result = curl_exec($ch);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    if(curl_exec($ch) === false) {
        return false;
    } else {
        return true;
    }

    curl_close($ch);
  }
}
