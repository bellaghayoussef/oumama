<h2>Bienvenue, {{ $user->name }}!</h2>

<p>Votre compte a été créé avec succès. Voici vos informations de connexion :</p>

<ul>
    <li>Email : {{ $user->email }}</li>
    <li>Mot de passe : {{ $plainPassword }}</li>
</ul>

<p>Nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
