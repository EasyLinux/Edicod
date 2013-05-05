<!-- Fonction de menu -->
function MenuToggle(id)
{
if( document.getElementById('Sub'+id).style.display == 'none' )
  {
  document.getElementById('Sub'+id).style.display = 'block';
  document.getElementById('Fold'+id).src = '/img/menu/minus.png';
  }
else
  {
  document.getElementById('Sub'+id).style.display = 'none';
  document.getElementById('Fold'+id).src = '/img/menu/plus.png';
  }
}
<!-- Fonction de menu -->

