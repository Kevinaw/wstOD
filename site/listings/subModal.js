function show_window(){
    try{
      document.getElementById('popupMask').style.display='block';
      document.getElementById('popupContainer').style.display='block';
    } catch(err){}
}
function hide_window(){
    document.getElementById('popupMask').style.display='none';
    document.getElementById('popupContainer').style.display='none';
}
function paypal_clicked(id){
    window.location = 'paypal_clicked.php?id=' + id;
}