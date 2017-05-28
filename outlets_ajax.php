<script>
var xmlhttp, comments, owner_id_var, feedback_id_var;
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
            xmlhttp.send("comments="+comments+"&owner_id="+owner_id_var+"&feedback_id="+feedback_id_var);

        }
        function updateData(feedback_id,owner_id)
        {
            comments = document.getElementById("commentsId"+feedback_id).value;
            if (comments == "")
                return;
            owner_id_var = owner_id;
            feedback_id_var = feedback_id;
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