function showResult(str) {
    if (str.length==0) {
        document.getElementById("products").innerHTML="";
        document.getElementById("products").style.border="0px";
        return;
    }
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            document.getElementById("products").innerHTML=this.responseText;
            document.getElementById("products").style.border="1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET","./models/LiveSearch.php?q="+str,true);
    xmlhttp.send();
}