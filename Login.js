// Cette fonction code le mot de passe en MD5 
// puis valide le formulaire. 
// @todo 	réaliser fonction plus sécurisée en transmettant une variable depuis le serveur
function Send()
{
// Crype le mot de passe
MD5pwd = MD5(document.getElementById('Password').value);
// Efface le mot de passe en clair
document.getElementById('Password').value = '';
// Assigne le bon champs
document.getElementById('MD5Pass').value = MD5pwd;
// Envoie le formulaire
document.login.submit();
}

