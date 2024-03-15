document.addEventListener('DOMContentLoaded', function () {
    console.log('Document ready!');
  
    var currentUrl = window.location.href;
    var examId = currentUrl.split('/').pop();
    console.log(examId);
  
    // Perform AJAX request using XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('GET', `/exam/get-data-to-mark/${examId}`, true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('AJAX request completed!');
        var response = JSON.parse(xhr.responseText);
        
        let studentsHtml = '';
        let index = 1;
        response.forEach(function (item) {
          studentsHtml += '<tr class="text-left">\
            <td class="text-left"><p class="text-xs text-secondary mb-0"> ' + index++ + ' </p></td>\
            <td class="text-left"><p class="text-xs text-secondary mb-0"> ' + item.studentName + ' </p></td>\
            <td class="text-left"><p class="text-xs text-secondary mb-0"> ' + (item.score !== null ? item.score : '<input type="text" class="form-control" id="' + item.scoreUuId + '" name="" placeholder="">' ) + ' </p></td>\
          </tr>';
        });
  
        document.getElementById("data-here").innerHTML = studentsHtml;
  
        // Attach event handler after appending HTML
        document.getElementById("data-here").addEventListener('mouseenter', function (event) {
          if (event.target.id && event.target.id.startsWith('scoreUuId')) {
            console.log('Mouseenter event triggered!');
            setScore(event.target.id);
          }
        });
      }
    };
    xhr.send();
  });
  
  function setScore(scoreUuId) {
    alert(scoreUuId);
  }
  