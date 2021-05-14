document.getElementById("menuIcon").onclick=function(){
    var navArea=document.getElementsByTagName("nav")[0];
    
    this.classList.toggle("change");
    
    if (navArea.style.maxHeight=="200px"){
        navArea.style.maxHeight="0px";
    }else{
        navArea.style.maxHeight="200px";
    }

}