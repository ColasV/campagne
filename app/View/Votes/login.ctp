<div class="alert alert-info">
<p>Utilise tes identifiants Ensimag pour te connecter !</p>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
<?php
echo $this->Form->create('login',array('class'=>'form'));
echo $this->Form->input('username',array('class'=>'form-control'));
echo $this->Form->input('password',array('class'=>'form-control'));

/* Code captcha */
$publickey = "6LddPfASAAAAADqEjngHBrB-D8HE4CDNkcE24T2u"; // you got this from the signup page
echo recaptcha_get_html($publickey);
echo $this->Form->submit('Connexion',array('class'=>'btn btn-default'));

?>
</div>
</div>
