function allerAPage(numeroPage)
	{
	document.forms[0].numeroPage.value = numeroPage;
	document.forms[0].fonction.value="allerPage";
	document.forms[0].submit();	
	}

function pagePrecedente()
	{
	document.forms[0].fonction.value="pagePrecedente";
	document.forms[0].submit();	
	}

function pageSuivante()
	{
	document.forms[0].fonction.value="pageSuivante";
	document.forms[0].submit();
	}