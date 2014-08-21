<!--

function isCookieAllowed(){
   setCookie('cookie_allowed',1,10); 
   if(readCookie('cookie_allowed') != 1) {alert('This operation requires that your browser accepts cookies! Please turn on cookies accepting.'); return false; }; 
   return true; 
}

function setCookie(name,value,days) {
   if (days) {
      var date = new Date();
      date.setTime(date.getTime()+(days*24*60*60*1000));
      var expires = '; expires='+date.toGMTString();
   }
   else var expires = '';
   document.cookie = name+'='+value+expires+'; path=/';
}

function readCookie(name) {
   var nameEQ = name + '=';
   var ca = document.cookie.split(';');
   for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
   }
   return null;
}

// textarea maxlength checking
function setMaxLength() {
   var x = document.getElementsByTagName('textarea');
   var counter = document.createElement('span'); //div
   counter.className = 'counter';
   for (var i=0;i<x.length;i++) {
      if (x[i].getAttribute('maxlength')) {
	 var counterClone = counter.cloneNode(true);
	 counterClone.relatedElement = x[i];
	 counterClone.innerHTML = '&nbsp;<span>0</span>/'+x[i].getAttribute('maxlength')+'&nbsp;';
	 x[i].parentNode.insertBefore(counterClone,x[i].nextSibling);
	 x[i].relatedElement = counterClone.getElementsByTagName('span')[0];
	 x[i].onkeyup = x[i].onchange = checkMaxLength;
	 x[i].onkeyup();
      }
   }
}

function checkMaxLength() {
   var maxLength = this.getAttribute('maxlength');
   var currentLength = this.value.length;
   
   if (currentLength > maxLength){
      this.relatedElement.className = 'toomuch';
      this.value = this.value.substring(0,maxLength);
      currentLength = maxLength;   
   }else{
      this.relatedElement.className = '';
   }
   this.relatedElement.firstChild.nodeValue = currentLength;   
   // not innerHTML
}

// hide/unhide Filtering
function hideUnHideFiltering(type, unique_prefix){
   if(!isCookieAllowed()) return false;
   unique_prefix = (unique_prefix == null) ? '' : unique_prefix;
   if(type == 'hide'){
      document.getElementById(unique_prefix+'searchset').style.display = 'none'; 
      document.getElementById(unique_prefix+'a_hide').style.display = 'none'; 
      document.getElementById(unique_prefix+'a_unhide').style.display = ''; 
      setCookie(unique_prefix+'hide_search',1,10); 
   }else{
      document.getElementById(unique_prefix+'searchset').style.display = ''; 
      document.getElementById(unique_prefix+'a_hide').style.display = ''; 
      document.getElementById(unique_prefix+'a_unhide').style.display = 'none'; 
      setCookie(unique_prefix+'hide_search',0,10); 
   }
   return true;
}

//-->