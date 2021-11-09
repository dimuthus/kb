

// var currentTime = moment();
// var user_id= (<?php echo json_encode(Yii::$app->user->id); ?>)











var user_id=1
console.log(user_id)
var firstloginurl="http://localhost/auxfinal/frontend/web/scimstaff/firstlogin?userid="+user_id
// alert(firstloginurl)
fetch(firstloginurl




).then(function(data){
console.log("user id= "+user_id)
return data.json()
 })
.then(function(data){
	console.log("data== "+data)
var logintime= data.substr(10,data.length-1) 
// data.substr(10,data.logdate.length-1)    
 $("#firstlogin").html(logintime)
//console.log(data.logdate)
 
 

 })
.catch(function(e){


})
// clearInterval(auxtimer)
var handle=setInterval(function(){
 fetch(firstloginurl).then(function(data){

 return data.json()
 }).then(function(data){
var time=data;

processresponse(time);



 })




 },1000);




// alert(user_id)
// var currentTime = moment();
var url=" https://localhost/auxfinal/frontend/web/auxlog/insert"
var firstlogin= "";
// auxbuttonclick(0);
// $("#buttonactive").attr("disabled","true")

var auxbtn= document.getElementsByClassName('auxbtn')
auxbtn.addEventListener('click',function(e){


auxbuttonclick(e.target.value)


})

$('.auxbtn').click(function(e){



})

$('.activebutton').click(function(e){

this.disabled=true

activebuttonClick($('.newclass').val())

})



function activebuttonClick(){
 document.getElementsByClassName('activebutton').disabled=true
for (var i = 1; i < 10000; i++)
        {window.clearInterval(i);}
handle=setInterval(function(){
 fetch(firstloginurl).then(function(data){

 return data.json()
 }).then(function(data){
var time=data;

processresponse(time);



 })




 },1000);


var auxnodes= $(".auxbtn");
var auxbuttons=Object.values(auxnodes)
console.log("axbtn"+auxbuttons);
auxbuttons.pop();
var AuxCode=$(".newclass").attr("value");

auxbuttons.map(function(aux,index){

if(index==AuxCode){
console.log("index is "+index)

aux.removeAttribute('disabled');
fetch("http://localhost/auxfinal/frontend/web/auxlog/insert",{
method:'PUT',
body: JSON.stringify({
UserID:user_id,
AuxCode:AuxCode


})


}).then(function(data){

return data.json();

}).then(function(data){

// console.log("data "+data)
var t= getElapsedTime(data);
// console.log(t)
var timedata= t.Hours +" : " + t.Minutes + " : " +t.Seconds
$("#spantime"+index).html(timedata);
aux.classList.remove("newclass");

}).catch(function(e){

console.log(e)

})


}

aux.removeAttribute('disabled');
})




}




//// function that is called on clicking any of the aux buttons
function auxbuttonclick(auxnumber){


$(".activebutton").removeAttr('disabled')
var auxnodes= $(".auxbtn");
var auxbuttons=Object.values(auxnodes)
auxbuttons.pop();
try{
auxbuttons.map(function(aux,index){


if(index==auxnumber ){

var AuxCode=index;
var AuxPressTime= new Date()
var UserID=user_id;

aux.disabled=true
//console.log(aux.style.color)
aux.className+=" newclass";
// aux.style.color="green"
fetch("http://localhost/auxfinal/frontend/web/auxlog/insert",{
method:'POST',
// mode:'cors',
cache:'no-cache',
credentials:'same-origin',

redirect:'follow',
referrer:'no-referrer',
body: JSON.stringify({
UserID:UserID,
AuxCode:AuxCode
})

})
.then(function(data){

 return data.json();


 })
.then(function(data){
	console.log(data)
     clearInterval(handle);
  var auxtimer=   setInterval(function(){



fetch("http://localhost/auxfinal/frontend/web/auxlog/change?user_id="+user_id+"&auxCode="+AuxCode).then(function(data){

return data.json();

}).then(function(data){
console.log("auxpresstime"+data)

processresponse(data);



})


     }
,1000)
    
    //var auxtimer= setInterval(processresponse(),1000)
    


}).catch(function(err){

    console.log(err)

})




}else{

aux.disabled=true;
aux.classList.remove("newclass")

}
//console.log(selection)
})
} catch(e){

    console.log(e)
}






}


//////////////////////////////////////////////////

function processresponse(time){

var s= new Date(time)
//console.log(time)
// console.log(data.logdate)
 //console.log(moment.from(time));
 var t=getElapsedTime(s);
//console.log(t)
 // console.log(t.Minutes);
 $("#elapsedTimehour").html(t.Hours)
$("#elapsedTimeminute").html(t.Minutes)
if(t.Seconds<10){

$("#elapsedTimesec").html( "0"+ t.Seconds)  
}
else{
$("#elapsedTimesec").html(t.Seconds)
}
if(t.Minutes<10){

$("#elapsedTimeminute").html( "0"+  t.Minutes)  
}
else{
$("#elapsedTimeminutes").html(t.Minutes)
}
if(t.Hours<10){

$("#elapsedTimehour").html("0"+ t.Hours)    
}
else{
$("#elapsedTimehour").html(t.Hours)
}


 }


function getElapsedTime(time){


var today= new Date();
var secondDate= new Date(time);
var delta= Math.abs(today-secondDate) / 1000;

var days = Math.floor(delta / 86400);
//console.log(days)
delta -= days * 86400;

// calculate (and subtract) whole hours
var hours = Math.floor(delta / 3600) % 24;
//consol.log(hours)
delta -= hours * 3600;

// calculate (and subtract) whole minutes
var minutes = Math.floor(delta / 60) % 60;

delta -= minutes * 60;

// what's left is seconds
var seconds = Math.floor(delta % 60); 

//console.log(hours + ": " +minutes+" : "+ Math.floor(seconds))

// var hours= today.getHours()-secondDate.getHours();
// var minutes= today.getMinutes()-secondDate.getMinutes();
// var seconds= today.getSeconds()- secondDate.getSeconds();


// var seconds= new Date(new Date()-secondDate).getSeconds();
//  var minutes=new Date(new Date()).getMinutes()
//  var hours= new Date( today.getTime()-secondDate.getTime()).getHours();
 //console.log(hours)
//console.log(hours + ": " +minutes+" : "+ seconds)

// console.log(new Date(new Date())+" "+time )
// console.log(diffDate.getHours())
// console.log(diffDate)

return {

Hours:   hours,
Minutes: minutes,
Seconds: seconds                                                                                             
}
//"2019-10-22T08:29:21.784Z"


// return "Elapsed Time: Years: " + (diffDate.getFullYear() - 1970) + ",  " 
// + diffDate.getMonth() + ",  " + (diffDate.getDate() - 1) + ", Hours: " + diffDate.getHours() + ", Minutes: " + diffDate.getMinutes() 
// + ", Seconds: " + diffDate.getSeconds();




}




 




///////////////////////////////////////////////////////////////////////////////////////////////
var auxcode= $(this).val();
var requrl= url 













//alert("hello");








//alert("hello");


