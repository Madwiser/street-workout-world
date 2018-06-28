<section>
<form class="form-horizontal" action='ajoutUtilisateur' method="POST">
  <fieldset>
    <div id="legend">
      Register
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="login">Username</label>
      <div class="controls">
        <input type="text" id="username" name="login" placeholder="" class="input-xlarge">
        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
      </div>
    </div>
       <div class="control-group">
      <!-- nom -->
      <label class="control-label" for="nom">Nom</label>
      <div class="controls">
        <input type="text" id="nom" name="nom" placeholder="" class="input-xlarge">
        <p class="help-block"></p>
      </div>
    </div>
      
       <div class="control-group">
      <!-- prenom -->
      <label class="control-label" for="prenom">Prenom</label>
      <div class="controls">
        <input type="text" id="prenom" name="prenom" placeholder="" class="input-xlarge">
        <p class="help-block">Please provide your E-mail</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="passe">Password</label>
      <div class="controls">
        <input type="password" id="passe" name="passe" placeholder="" class="input-xlarge">
        <p class="help-block">Password should be at least 4 characters</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm"></label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
        <p class="help-block">Please confirm password</p>
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success">Register</button>
      </div>
    </div>
  </fieldset>
</form>
</section>
