<?php

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '' );

if(isset($_POST['forminscription']))
{
        $user_name = htmlspecialchars($_POST['user_name']);    
        $telephone = htmlspecialchars($_POST['telephone']);
        $mail= htmlspecialchars($_POST['mail']);
        $mdp = md5($_POST['mdp']);
        $confirm = md5($_POST['confirm']);
    //Vérification de la complétion de chaque champ
    if(!empty($_POST['user_name']) AND !empty($_POST['telephone']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['confirm']) AND !empty($_POST['user_name']) AND !empty($_POST['pannel']))
    {
        
        
        
        //Vérification de la longueur du pseudo (moins de 255 caractères)
        $user_namelength = strlen($user_name);
    
        if ($user_namelength<=5)
        {
            //if pseudo non-existant
                //Filtrage de l'email
                if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    $reqmail = $bdd -> prepare("SELECT * FROM membres WHERE mail = ?");
                    $reqmail-> execute (array($mail));
                    $mailexist=$reqmail -> rowCount();
                    if($mailexist==0)
                    { 
                        //Confirmation du mot de passe et de son double
                        if($mdp == $confirm)
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(user_name,mail,telephone,mdp) VALUES(?, ?, ?, ?)");
                            $insertmbr->execute(array($user_name,$mail,$telephone,$mdp));
                            header('location:../sit/index.html');
                        }
                        else 
                        {
                            $erreur ="Vos mots de passes ne correspondent pas !"; 
                        }
                    }
                    else   
                    {
                        $erreur= "Adresse mail déjà utilisée!";
                    }

                }
                else
                {
                    $erreur ="Mail incorrect";
                }
            
            //else pseudo deja existant
        }
        else
        {
            $erreur ="Votre pseudo ne doit pas dépasser 255 caractères!";
        }
    }
    else
    {
        $erreur = "Tout les champs doivent être complétés!";
    }
} 

   
     
    
    
?> 
<!doctypehtml>
<head>
    <meta charset="utf-8">
<title> Formulaire html</title>
</head>

<body>
    <div align="center" id="header">
            <h1>Formulaire PickMyClub:</h1>
            <br /><br /><br />
            <p1> Maintenant, entres tes informations :</p1>
    
<br /> 
<form method="post">
   <div id="formulaire">
    <div>
        <label for="name">Pseudo</label>
        <input type="text" id="name" name="user_name" value="<?php if(isset($user_name)){echo $user_name; }?>"> 
    </div> 
    
     <div>
        <label for="tel">Téléphone:</label>
        <input type="text" id="tel" name="telephone" value="<?php if(isset($telephone)){echo $telephone; }?>"> 
    </div>
    
     <div>
        <label for="mail">E-mail:</label>
        <input type="mail" id="mail" name="mail" value="<?php if(isset($mail)){echo $mail; }?>"> 
    </div>
    
    <div>
        <label for="mdp">Mot de passe:</label>
         <input type="password" id="motdepasse" name="mdp" >
    </div>
    <div>
        <label for="confirmation">confirme ton mot de passe:</label>
        <input type="password" id="mdpconfirm"
        name="confirm">
    </div>
    <div align="center">
    <section>
    <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="inputGroupFileAddon01">Photo de profil:</span>
  </div>
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
  
    <button class="btn btn-outline-secondary" type="button" id="inputGroupFileAddon04">Choisir</button>
  </div>
  </div>
    <h2>Comment nous as tu connu?</h2>
    <p>
      <label for="ref">
        <span>Référence:</span>
      </label>
      <select id="reseau" name="pannel">
        <option value="rc">Réseaux sociaux</option>
        <option value="media">Médias</option>
        <option value="familyorother">Entourage</option>
      </select>
        </p>
</section>
    </div>
    </div>
    
    <div align="center">
        <input id="btnInscription" name="forminscription"type="submit" value="Devenir membre" />
    </div>
</form> 
<?php
    if (isset($erreur))
        echo "<font color=red>".$erreur."</font";
    ?>
    </div>
<style>
    #btnInscription{
        background-color: darkgray;
        border-color: aliceblue;
    }
    
#formulaire{
  margin: 0 auto;
  width: 400px;
  padding: 1em;
  border: 1px solid #CCC;
  border-radius: 1em;
}
form div + div {
  margin-top: 1em;
}
label {
  display: inline-block;
  width: 90px;
  text-align: right;
}
input, textarea {
  font: 1em sans-serif;
  width: 300px;
  box-sizing: border-box;
  border: 1px solid #999;
  border-color: rosybrown;
  background-color: burlywood;
}
input:focus, textarea:focus {
  border-color: #000;
}
textarea {
  vertical-align: top;
  height: 5em;
}
.button {
  padding-left: 90px; 
}
button {
  margin-left: .5em;
}
    label {
  display: inline-block;
  width: 90px;
  text-align: right;
}
</style>

</body>