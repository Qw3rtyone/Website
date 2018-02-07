      function validateAlbum(form)
      {
        fail  = validateName(form.addName.value)
        fail += validatePrice(form.addPrice.value)
        fail += validateGenre(form.addGenre.value)
        fail += validateTracks(form.addTracks.value)
      
        if (fail == "")     
            return true;
        else { 
            alert(fail); 
            return false;
        }
      }      
      function validateTrack(form)
      {
        fail  = validateName(form.addName.value)
        fail += validateDuration(form.addTime.value)
      
        if (fail == "")     
            return true;
        else { 
            alert(fail); 
            return false;
        }
      }

      function validateName(field)
      {
        if (field == "") {
            document.getElementById('Name').style.borderColor = "red";
            return "No Name was entered.\n";
        }else if (/[^a-zA-Z0-9-.\s!()]/.test(field)){
            document.getElementById('Name').style.borderColor = "red";
            return "Invalid Name\n";
        }else{
            document.getElementById('Name').style.borderColor = "green";
            return "";
        }
        
      }

      function validatePrice(field)
      {
        if (field == ""){
            document.getElementById('Price').style.borderColor = "red";
            return "No Price was entered.\n";
        }
        else if (/[^0-9.]/.test(field)){
            document.getElementById('Price').style.borderColor = "red";  
            return "Invalid Price\n";
        }else{
            document.getElementById('Price').style.borderColor = "green";
            return "";
        }
        
      }

      function validateGenre(field)
      {
        if (field == ""){
            document.getElementById('Genre').style.borderColor = "red";
            return "No Genre was entered.\n";
        }else if (/[^a-zA-Z-.\s!()]/.test(field)){
            document.getElementById('Genre').style.borderColor = "red";
            return "Invalid genre\n";
        }else{
            document.getElementById('Genre').style.borderColor = "green";
            return "";
        }
      }

      function validateTracks(field)
      {
        if (field == ""){
            document.getElementById('Tracks').style.borderColor = "red";
            return "A number of Tracks was not entered.\n"
        }else if (/[^0-9]/.test(field)){
            document.getElementById('Tracks').style.borderColor = "red";
            return "Invalid number of tracks\n"
        }else{
            document.getElementById('Tracks').style.borderColor = "green";
            return "";
        }
      }
      function validateDuration(field)
      {
        if (field == ""){
            document.getElementById('Time').style.borderColor = "red";
            return "No duration was entered.\n"
        }else if (/[^0-9]/.test(field)){
            document.getElementById('Time').style.borderColor = "red";
            return "Invalid Duration\n"
        }else{
            document.getElementById('Time').style.borderColor = "green";
            return "";
        }
      }


