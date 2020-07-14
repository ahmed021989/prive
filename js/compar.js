 
	function compar()
{
var sdate1 = document.getElementById('date_entre').value
var date1 = new Date();
date1.setDate(sdate1.substr(8,2));
date1.setMonth(sdate1.substr(5,2));
date1.setFullYear(sdate1.substr(0,4));
date1.setHours(0);
date1.setMinutes(0);
date1.setSeconds(0);
date1.setMilliseconds(0);
var d1=date1.getTime()
 
var sdate2 = document.getElementById('date_sortie').value
var date2 = new Date();
date2.setDate(sdate2.substr(8,2));
date2.setMonth(sdate2.substr(5,2));
date2.setFullYear(sdate2.substr(0,4));
date2.setHours(0);
date2.setMinutes(0);
date2.setSeconds(0);
date2.setMilliseconds(0);
var d2=date2.getTime()
 
//si la date d'arrviée et superieur a la date de depart en afficher un message d'erreur
if(d1  >  d2)
{  
    alert('Vous avez selectionné une date incorrect!!' )

        return false;
      
}
else 
{
form.onsubmit;
}


if(form.date_entre.value == "") {
      alert(" Le champ de date est vide !!! ");
     
      return false;
}
 
}

 
