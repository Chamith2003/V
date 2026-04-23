
document.getElementById('registrationForm').addEventListener('submit', function(e) {
  const location1 = document.getElementById('location1').value;
  const location2 = document.getElementById('location2').value;
  const location3 = document.getElementById('location3').value;

  if (location1 && location2 && location1 === location2) {
    e.preventDefault();
    alert('Please select different districts. 1st and 2nd choices cannot be the same.');
    return false;
  }
  
  if (location1 && location3 && location1 === location3) {
    e.preventDefault();
    alert('Please select different districts. 1st and 3rd choices cannot be the same.');
    return false;
  }
  
  if (location2 && location3 && location2 === location3) {
    e.preventDefault();
    alert('Please select different districts. 2nd and 3rd choices cannot be the same.');
    return false;
  }
});
