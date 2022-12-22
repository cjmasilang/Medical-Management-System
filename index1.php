<?php
session_start();
	if(!isset($_SESSION['doctorID'])){
    header ("Location: Login.php");
		}
  include_once 'Header.php';
  include_once 'config/database.php';
  include_once 'classes/patient.php';
  
  
  $database = new Database();
  $db = $database -> getConnection();
  $patient = new Patient($db);
  $stmt = $patient->readAllPatient();

  echo "  
     <div>
      <h2>Patient</h2>
        <button type='button' class='btn btn-primary' onclick=window.location.href='patientAdd.php'>Patient Registration</button>
		
      </div>
    <br>

    <table class='table table-striped'>
      <thead>
        <tr>
          <th scope='col'>#</th>
           <th scope='col'>First</th>
           <th scope='col'>Last</th>
           <th scope='col'>middle</th>
		  <th scope='col'>surffix</th>
          <th scope='col'>Action</th>
        </tr>
      </thead>

      <tbody>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
        echo"
        <tr>
        <td scope='col'>{$patientID}</td>
        <td scope='col'>{$firstName}</td>
        <td scope='col'>{$lastName}</td>
		 <td scope='col'>{$middleName}</td>
		<td scope='col'>{$suffix}</td>
        <td scope='col'><a class='btn btn-primary' href='patientEdit.php?patientID={$patientID}'role='button'>Edit</a>
                        <font color = 'white'<a delete-id='{$patientID}' class='btn btn-primary delete-object'>Delete</a></font>
        </td>

        </tr>";    
        }
        echo "</tbody>
        </table>"; 
?>

<script>
  $(document).on('click', '.delete-object', function(){
    var id = $(this).attr('delete-id');
    var q = confirm("Are you sure?");

    if (q == true){
      $.post('patientDelete.php', { 
        patientID: id
      }, function(data){
        location.reload();
      }).fail(function() {
        alert('Unable to delete.');
      });
    }

    return false;
  });
</script>

<?php
   include_once 'footer.php';
?>