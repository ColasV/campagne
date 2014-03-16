<div class="alert alert-info">
<p>Utilise tes identifiants Ensimag pour te connecter !</p>
</div>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
<?php
echo $this->Form->create('login',array('class'=>'form'));
echo $this->Form->input('username',array('class'=>'form-control'));
echo $this->Form->input('password',array('class'=>'form-control'));
echo $this->Form->submit('Connexion',array('class'=>'btn btn-default'));

?>
</div>
</div>
