/**
 * Created by Goran on 5/14/2016.
 */
function dodaj(){

	var a = parseInt(document.getElementById('uKorpu').value);
	a++;
	document.getElementById('uKorpu').value = a;

}
function oduzmi(){

	var a = parseInt(document.getElementById('uKorpu').value);
	if(a === 0) {return;}
	a--;
	document.getElementById('uKorpu').value = a;

}


