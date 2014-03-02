<div class="row"><h1>Page des résultats des votes</h1></div>

<div class="row">
  <h2>Vote pour ta liste préféré</h2>
  <div class="col-md-6 col-md-offset-3">
    <a href="<?php echo $this->Html->url(array('controller' => 'Votes','action' => 'voter',1)); ?>" role="button" class="btn btn-primary btn-block">Listérique</a>
    <a href="<?php echo $this->Html->url(array('controller' => 'Votes','action' => 'voter',2)); ?>" role="button" class="btn btn-primary btn-block">Régliste</a>
    <a href="<?php echo $this->Html->url(array('controller' => 'Votes','action' => 'voter',3)); ?>" role="button" class="btn btn-primary btn-block">Plus Belle la Liste</a>
  </div>
</div>
