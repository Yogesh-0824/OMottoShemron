<script>
var xmlhttp;
        function loadXMLDoc(url,cfunc)
        {
            if (window.XMLHttpRequest)
              {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=cfunc;
            xmlhttp.open("POST",url,true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send();

        }
        function addSaleButtonPressed()
        {
           alert("Some Error occured.");
            
          document.getElementById("content").innerHTML=
          "<table>
          <tr>
            <td>
              test
            </td>
          </tr>
          </table>";
         // document.getElementById("saveButton"+feedback_id).style.display="none";
          //document.getElementById("historyButton"+feedback_id).style.display="block";
        }
        function addSaleToDB()
        {
            loadXMLDoc("saveresponse.php",function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {   
                    document.getElementById("responseTable"+feedback_id).innerHTML=xmlhttp.responseText;
                    document.getElementById("saveButton"+feedback_id).style.display="none";
                    document.getElementById("historyButton"+feedback_id).style.display="block";
                }
              });
        }
</script>