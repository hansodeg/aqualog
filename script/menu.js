
/*funksjon som må implementeres for kunne bruke interaktiv-
sidemeny i hvert renseanlegg*/
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
  }
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0px";
     document.getElementById("main").style.marginLeft = "0";
  }
