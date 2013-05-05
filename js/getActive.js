/**
 * Ce script permet de savoir sur quel ligne
 * l'utilisateur désire agir
 **/
RadioSelected=0;

function SetActive(Value)
{  // Fonction appelée lors d'un click de sélection
	RadioSelected=Value;
}

function GetActive()
{  // Lire la ligne cochée
	return RadioSelected;
}

