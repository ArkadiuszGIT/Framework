
$.validator.addMethod('validPassword',
    function(value, element, param) {

        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }

        return true;
    },
    'Hasło musi zawierać conajmniej jedną literę i jeden numer'
);

Number.prototype.round = function(miejsc)
{
	return +(Math.round(this+"e+"+miejsc) + "e-"+miejsc);
}

function data()
{
		var dzisiaj = new Date();
		
		var dzien = dzisiaj.getDate();
		var miesiac = dzisiaj.getMonth()+1;
		var rok = dzisiaj.getFullYear();
		
		if (dzien<10) dzien = "0"+dzien;
		
		if (miesiac<10) miesiac = "0"+miesiac;
		
		document.getElementById("date").value = rok+"-"+miesiac+"-"+dzien;
		
}

var myMap = new Map();
myMap.set(1, "Styczeń");
myMap.set(2, "Luty");
myMap.set(3, "Marzec");
myMap.set(4, "Kwiecień");
myMap.set(5, "Maj");
myMap.set(6, "Czerwiec");
myMap.set(7, "Lipiec");
myMap.set(8, "Sierpień");
myMap.set(9, "Wrzesień");
myMap.set(10, "Październik");
myMap.set(11, "Listopad");
myMap.set(12, "Grudzień");

function dataBilans()
{
		var dzisiaj = new Date();
		
		var miesiac = dzisiaj.getMonth()+1;
		var rok = dzisiaj.getFullYear();
		
		$('#h1').html("Bilans z " + myMap.get(miesiac) + " " + rok);
}
function dataPreviousBilans()
{
		var dzisiaj = new Date();
		
		var miesiac = dzisiaj.getMonth();
		var rok = dzisiaj.getFullYear();
		
		$('#h1').html("Bilans z " + myMap.get(miesiac) + " " + rok);
}
function dataCurrentYear()
{
		var dzisiaj = new Date();
		
		var miesiac = dzisiaj.getMonth();
		var rok = dzisiaj.getFullYear();
		
		$('#h1').html("Bilans z " + rok + " roku");
}
function obliczBilans()
{
		var liczba1;
		if ( isNaN(parseFloat($('#sumaPrzychodow').html()))) {
			liczba1 = 0;
		} else {
			liczba1 = parseFloat($('#sumaPrzychodow').html());
		}
		var liczba2;
		if ( isNaN(parseFloat($('#sumaWydatkow').html()))) {
			liczba2 = 0;
		} else {
			liczba2 = parseFloat($('#sumaWydatkow').html());
		}
		
		var liczba = liczba1 + liczba2;
		
		//<?php $sumaPrzychodow + $sumaWydatkow;?>
		
		liczba = liczba.round(2);
		$('#bilans').html("Bilans przychodów i wydatków w wybranym okresie: " + " " + liczba + " zł");
			
		if (liczba>0) 
		{
			document.getElementById("errorBalance").innerHTML="Gratulacje. Świetnie zarządzasz finansami!";
			$('#errorBalance').css('color', "#428C42");
		}
		else if (liczba<0) document.getElementById("errorBalance").innerHTML="Uważaj, Wpadasz w długi!";
		
}
