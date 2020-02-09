/*-------------------------*/

/*---- fill the selects ---*/

/*---- The days will have the value D or DD (depending on the dayMask) and the text DD ---*/
/*---- The months will have the value YYYYMM or MMM YYYY (depending on the monthYearMask) and the text MMMMMM YY---*/

/*-------------------------*/


var FRENCH_MONTHS = new Array("Janvier","F\351vrier","Mars","Avril","Mai","Juin","Juillet","Ao\373t","Septembre","Octobre","Novembre","D\351cembre");
var FRENCH_MONTHS_SHORT = new Array("JAN", "FEV", "MAR", "AVR", "MAI", "JUN", "JUL", "AOU", "SEP", "OCT", "NOV", "DEC");
var FRENCH_DAYS = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

function fillDepDay(idSelectDepDay, dateMonth, selectedDay, firstOptionText, firstOptionValue, dayMask)
{
//dateMonth is a Date variable with the month and year correct.
var nextMonth = new Date(dateMonth);
// var firstDay = nextMonth.getDate();
var firstDay = 1;
nextMonth.setMonth(nextMonth.getMonth()+1);
nextMonth.setDate(1); //we go to the first day of the next month
nextMonth.setDate(nextMonth.getDate()-1); //we go to the last day of the actual month
var nbrOfDaysMyMonth=nextMonth.getDate();

var selectDepDay = document.getElementById(idSelectDepDay);

var dayString;
var daySelected;
var newOptions = new Array();

//clean all the options:
var optionsLength = selectDepDay.options.length;
for (var i = 0; i<optionsLength; i++ )
selectDepDay.options[0] = null;

var optionOffset = 0;
if (firstOptionText != "" ){
var mySelectOption = new Option(firstOptionText,firstOptionValue);
selectDepDay.options[0] = mySelectOption;
optionOffset = 1;
if (selectedDay == firstOptionText)
selectDepDay.options[0].selected = true;
}

var selectIndex = 0;
for (var myDay=firstDay; myDay<= nbrOfDaysMyMonth; myDay++)
{

//we pass from the D format to the DD format if necessary
if (dayMask == "tempJour")
dayString = (myDay<10?"0":"")+myDay;
else
dayString = myDay;

daySelected = false;
if(myDay == selectedDay){
daySelected = true;
selectDepDay.value = myDay;
}
//if the day to select is to hight for this month, we select the last day of the month.
if(nbrOfDaysMyMonth < selectedDay && myDay == nbrOfDaysMyMonth ){
daySelected = true;
selectDepDay.value = myDay;
}
//For info: new Option([text[, value[, defaultSelected[, selected]]]])
var mySelectOption = new Option(dayString,dayString,daySelected);
//we recreate the options from the select:
selectDepDay.options[selectIndex+optionOffset] = mySelectOption;
selectDepDay.options[selectIndex+optionOffset].selected = daySelected;
selectIndex++;
}
//clean the last options:
while(selectDepDay.options.length > nbrOfDaysMyMonth-firstDay+1+optionOffset)
selectDepDay.options[selectDepDay.options.length-1] = null;
}
function fillDepMonth(idSelectDepMonth, nbrOfMonths, firstOptionText, firstOptionValue, selectedMonthDate, monthYearMask){
var today = new Date();
today.setDate(1);
var selectDepMonth = document.getElementById(idSelectDepMonth);
var monthString;
var monthSelected;
var newOptions = new Array();
var optionOffset = 0;
if (firstOptionText != "" ){
var mySelectOption = new Option(firstOptionText,firstOptionValue);
selectDepMonth.options[0] = mySelectOption;
optionOffset = 1;
}
for (var i= 1; i<=nbrOfMonths; i++)
{
monthSelected = false;
if ( firstOptionText == "" && selectedMonthDate != "" && today.getMonth() == selectedMonthDate.getMonth() && today.getYear() == selectedMonthDate.getYear() ) {
monthSelected=true;
}
var twoLastDigitsYear = ""+today.getFullYear(); //we convert the number to a string
twoLastDigitsYear = twoLastDigitsYear.substring(twoLastDigitsYear.length-2,twoLastDigitsYear.length);
var monthText = FRENCH_MONTHS[today.getMonth()]+" "+twoLastDigitsYear;
var monthValue = "";

if(monthYearMask == "MMM YYYY" ){
monthValue = FRENCH_MONTHS_SHORT[today.getMonth()]+" "+today.getFullYear();
}
else{ //monthYearMask == "YYYYMM"
var numericMonth = today.getMonth()+1; //month goes from 0 to 11
var monthString = (numericMonth<10?"0":"")+numericMonth;
monthValue = ""+today.getFullYear()+""+monthString;
}
//For info: new Option([text[, value[, defaultSelected[, selected]]]])
var mySelectOption = new Option(monthText,monthValue,monthSelected);
selectDepMonth.options[i-1+optionOffset] = mySelectOption;
selectDepMonth.options[i-1+optionOffset].selected = monthSelected;

today.setMonth(today.getMonth()+1); //we increment the month for the next iteration
}
}
function fillDepMonthShort(idSelectDepMonth, nbrOfMonths, firstOptionText, firstOptionValue, selectedMonthDate, monthYearMask){
var today = new Date();
today.setDate(1);
var selectDepMonth = document.getElementById(idSelectDepMonth);
var monthString;
var monthSelected;
var newOptions = new Array();
var optionOffset = 0;
if (firstOptionText != "" ){
var mySelectOption = new Option(firstOptionText,firstOptionValue);
selectDepMonth.options[0] = mySelectOption;
optionOffset = 1;
}
for (var i= 1; i<=nbrOfMonths; i++)
{
monthSelected = false;
if ( firstOptionText == "" && selectedMonthDate != "" && today.getMonth() == selectedMonthDate.getMonth() && today.getYear() == selectedMonthDate.getYear() ) {
monthSelected=true;
}
var twoLastDigitsYear = ""+today.getFullYear(); //we convert the number to a string
twoLastDigitsYear = twoLastDigitsYear.substring(twoLastDigitsYear.length-2,twoLastDigitsYear.length);
var monthText = FRENCH_MONTHS_SHORT[today.getMonth()]+" "+today.getFullYear();
var monthValue = "";

if(monthYearMask == "MMM YYYY" ){
monthValue = FRENCH_MONTHS_SHORT[today.getMonth()]+" "+today.getFullYear();
}
else{ //monthYearMask == "YYYYMM"
var numericMonth = today.getMonth()+1; //month goes from 0 to 11
var monthString = (numericMonth<10?"0":"")+numericMonth;
monthValue = ""+today.getFullYear()+""+monthString;
}
//For info: new Option([text[, value[, defaultSelected[, selected]]]])
var mySelectOption = new Option(monthText,monthValue,monthSelected);
selectDepMonth.options[i-1+optionOffset] = mySelectOption;
selectDepMonth.options[i-1+optionOffset].selected = monthSelected;
today.setMonth(today.getMonth()+1); //we increment the month for the next iteration
}
}
function refillDepDay(idSelectDepMonth, idSelectDepDay, firstOptionText, firstOptionValue, dayMask, monthYearMask){
var selectDepDay = document.getElementById(idSelectDepDay);
var selectedDay = selectDepDay.value;
var selectDepMonth = document.getElementById(idSelectDepMonth);
var monthYear = selectDepMonth.value;
var year = 0;
var numericMonth = 0;

if(monthYearMask == "MMM YYYY" ){
var month = monthYear.substring(0,monthYear.indexOf(" "));
year = monthYear.substring(monthYear.indexOf(" ")+1, monthYear.length);
for(var i=0; i< FRENCH_MONTHS_SHORT.length; i++)
if(FRENCH_MONTHS_SHORT[i] == month)
numericMonth = i;
}
else{ //monthYearMask == "YYYYMM"
year = monthYear.substring(0,4);
numericMonth = monthYear.substring(4,6);
numericMonth = numericMonth -1; // months goes from 0 to 11
}
var dateMonth = new Date();
dateMonth.setYear(year);
dateMonth.setMonth(numericMonth);
//if the selected month is the actual one, we don't allow a departure day < today
var today = new Date();
if(today.getYear() == dateMonth.getYear() && today.getMonth() == dateMonth.getMonth() ){
//important: we cannot set the day directly because could happen that we try to set day 31 to february!!
var thisMonth = new Date(today.getYear(), today.getMonth(), 0);
var daysInActualMonth = thisMonth.getDate();

if( daysInActualMonth < selectedDay )
dateMonth.setDate(daysInActualMonth);
else
dateMonth.setDate(today.getDate());

if (today.getDate() > dateMonth.getDate() ){
//we change the selected day
selectedDay = today.getDate();
}
}else
dateMonth.setDate(1);
fillDepDay(idSelectDepDay, dateMonth, selectedDay, firstOptionText, firstOptionValue, dayMask);
}
function fillDayOfTheWeek(idDayOfTheWeek, idSelectDay, idSelectMonthYear, dayMask, monthYearMask){
//revcover the date:
var selectDay = document.getElementById(idSelectDay);
var selectedDay = selectDay.value;
var selectMonth = document.getElementById(idSelectMonthYear);
var monthYear = selectMonth.value;
var year = 0;
var numericMonth = 0;
if(monthYearMask == "MMM YYYY" ){
var month = monthYear.substring(0,monthYear.indexOf(" "));
year = monthYear.substring(monthYear.indexOf(" ")+1, monthYear.length);
for(var i=0; i< FRENCH_MONTHS_SHORT.length; i++)
if(FRENCH_MONTHS_SHORT[i] == month)
numericMonth = i;
}
else{ //monthYearMask == "YYYYMM"
year = monthYear.substring(0,4);
numericMonth = monthYear.substring(4,6);
numericMonth = numericMonth -1; // months goes from 0 to 11
}
var myDate = new Date(Date.UTC(year,numericMonth,selectedDay,0,0,0));
var selectDayOfTheWeek = document.getElementById(idDayOfTheWeek);
selectDayOfTheWeek.value = FRENCH_DAYS[myDate.getDay()];
}
function getDateWithMask(idDay, idYearMonth, maskMonth){

var myDay = document.getElementById(idDay).value;
// myDay = parseInt(myDay,10); //that will eliminate a possible 0 before the number. Ex: "01" will be 1.
var yearMonth = document.getElementById(idYearMonth).value;
var myYear = 0;
var myMonth = 0;

if(maskMonth == "MMM YYYY" ){
var monthInLetters = yearMonth.substring(0,yearMonth.indexOf(" "));
myYear = yearMonth.substring(yearMonth.indexOf(" ")+1, yearMonth.length);

for(var i=0; i< FRENCH_MONTHS_SHORT.length; i++)
if(FRENCH_MONTHS_SHORT[i] == monthInLetters)
myMonth = i;
}
else{ //monthYearMask == "YYYYMM"
myYear = yearMonth.substring(0,4);
myMonth = yearMonth.substring(4,6);
myMonth = parseInt(myMonth,10) -1; // months goes from 0 to 11
}
var myDate = new Date(Date.UTC(myYear,myMonth,myDay,0,0,0));
 return myDate;
}