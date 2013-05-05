function Valid(TheForm)
{  // Validation d'un formulaire
MyForm = document.getElementById(TheForm);
for( i=0 ; i < MyForm.length ; i++)
  {
  for( j=0 ; j < Variables.length ; j++ )
    {
    if( Variables[j][0] == MyForm.elements[i].name)
      {
      switch( Variables[j][1] )
        {
        case 'text':
          if( (Variables[j][2] == 1) && (MyForm.elements[i].value.length < 1) )
            {
            alert('Champs obligatoire');
            MyForm.elements[i].focus();
            return false;
            }
          break;

        case 'mail': // mail phone int
          // Champs vide et pas obligatoire
          if( (Variables[j][2] == 0) && (MyForm.elements[i].value.length < 1) )
            return true;
	  p1 = MyForm.elements[i].value.indexOf('@');
	  p2 = MyForm.elements[i].value.lastIndexOf('.');
          if( !((p1 > -1) && (p2 > -1) && (p1 < p2)) ) 
            {
            alert('Email non valide!');
            MyForm.elements[i].focus();
            return false;
            }
          break;

        case 'int':
          if( isNaN(MyForm.elements[i].value) )
            {
            alert("N'est pas un chiffre !");
            MyForm.elements[i].focus();
            return false;
            }
          break;
        }
      } // endif
    }
  }
return( true );
}

