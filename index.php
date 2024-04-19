<?php
$servername="localhost";
$username="root";
$password="";
$database="crud_app";
$tablename="notes";
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("There is an error occur----->".mysqli_connect_error($conn));
}else{
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(($_POST['realsno2'])!=NULL){
            $realsno=$_POST['realsno2'];
            $sql="DELETE FROM `$tablename` WHERE `sno` = $realsno;";
            $result=mysqli_query($conn,$sql);
        if($result){
            header("location: index.php");
            exit();
        }
    }
        if(($_POST['realsno'])!=NULL){
            $realsno=$_POST['realsno'];
            echo "is set: $realsno";
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            $title=$_POST['title'];
            $description=$_POST['description'];
            // echo " title is : $title  desc is: $description"; isset($_POST['realsno'])
            $sql="UPDATE `$tablename` SET `title` = '$title', `description` = '$description' WHERE`sno` = $realsno;";
            echo "SQL Query: $sql";
            $result=mysqli_query($conn,$sql);
            if($result){
                header("location: index.php");
                exit();
            }
            
            
        }else{
            $title=$_POST['title'];
        $description=$_POST['description'];
        $sql="INSERT INTO `$tablename` (`title`, `description`, `time`) VALUES ('$title', '$description', current_timestamp());";
        $result=mysqli_query($conn,$sql);
        if($result){
            header("location: index.php");
            exit();
        }
        }
        
        
        
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myNoTeS-schedule your tasks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">
</head>

<body>


    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-book"></i>
                <strong>MyNoTeS</strong>
            </a>
        </div>
    </nav>

    <div class="container my-5">
        <h3>ADD YOUR NOTE</h3>
        <form action="/crudapp/index.php" method="post" id="notesForm">
            <div class="mb-3">
                <label for="title" class="form-label">Note-Title</label>
                <input type="text" name="title" class="form-control" id="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note-Description</label>
                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
            </div>
            <input type="hidden" name="realsno" id="realsno">
            <input type="hidden" name="realsno2" id="realsno2">
            <button type="submit" class="btn btn-info">Submit</button>
        </form>
    </div>



    <div class="container mb-5">
        <h3>your notes summary-----</h3>
        <?php
        $tablename="notes";
           $sql="SELECT * FROM $tablename";
           $result=mysqli_query($conn,$sql);
           $num=mysqli_num_rows($result);
           if($num>0){
           
               

                echo '<table class="table" id="myTable">
                <thead>
                  <tr>
                    <th scope="col">sno</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                    <th scope="col" style="display:none;">real sno.</th>
                  </tr>
                </thead>
                <tbody>';
                
              $sno = 1; // Initializing the sno variable  . $rows['title'] .  . $rows['description'] .
            while ($rows = mysqli_fetch_assoc($result)) {
                 echo '<tr>
                <th scope="row">' . $sno . '</th>
                <td>' . $rows['title'] . '</td>
                <td>' . $rows['description'] . '</td>
                <td>        
                   <button type="button" class="btn btn-info edit_btn" id="edit_btn'.$sno.'">Edit</button>
                   <button type="button" class="btn btn-info delete_btn" id="edit_btn'.$sno.'">Delete</button>
                </td>
                <td style="display:none;">' . $rows['sno'] . '</td>
                </tr>';
                 $sno++; 
            }
       
           }else{
               
               echo "THERE IS NOT A SINGLE ENTRY IN THE DATABASE";
           }

        ?>
        <hr>
    </div>






    <!-- script tag of bootstrap -->
    <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        let edit_btn=document.querySelectorAll('.edit_btn');
        let delete_btn=document.querySelectorAll('.delete_btn');
        delete_btn.forEach((button)=>{
            button.addEventListener('click',()=>{
                if(button.innerHTML=='Delete'){
                    let title_td=button.parentNode.parentNode.querySelectorAll('td');
                    let realsno=title_td[3].textContent;
                    let realsnoid=document.getElementById('realsno2');
                    realsnoid.value=realsno;
                    document.getElementById('notesForm').submit();

                }
                


            })
        });
        edit_btn.forEach((button)=>{
            button.addEventListener('click',()=>{
            // const xhr=new XMLHttpRequest();
            // xhr.open('POST','index.php',true);
            // xhr.send;
                if(button.innerHTML=='Edit'){
                    let title_td=button.parentNode.parentNode.querySelectorAll('td');
                title_td[0].innerHTML='<input type="text" name="title" class="form-control" placeholder="enter your new title">'
                title_td[1].innerHTML='<input type="text" name="description" class="form-control" placeholder="enter your new description">'
                button.innerHTML="Save";
                }else{
                    let title_td=button.parentNode.parentNode.querySelectorAll('td');
                    let newTitle = title_td[0].querySelector('input').value;
                    let newDescription = title_td[1].querySelector('input').value;
                    console.log('hiii ',newTitle);
                    console.log('hiii ',newDescription);
                    title_td[0].innerHTML=newTitle;
                    title_td[1].innerHTML=newDescription;

                    let title=document.getElementById('title');
                    let desc=document.getElementById('description');
                    title.value=newTitle;
                    desc.textContent=newDescription;



                    let realsno=title_td[3].textContent;
                    console.log('hiii ',realsno);
                    let realsnoid=document.getElementById('realsno');
                    realsnoid.value=realsno;
                    document.getElementById('notesForm').submit();
                    button.innerHTML="Edit";
                }
                


            })
        });
    </script>
    

</body>

</html>