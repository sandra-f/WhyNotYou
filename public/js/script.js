/*
Choix limités à 4 pour la catégorie Valeurs du formulaire de préférences
*/

var limit = 4;
$('input.single-checkbox').on('change', function(evt) {
   if($(this).siblings(':checked').length >= limit) {
       this.checked = false;
   }
});