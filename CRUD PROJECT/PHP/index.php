<?php
session_start();
require 'dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="bg-primary">
<?php
require 'message.php';
?>
<div id="viewstudent_message"></div>
    <!-- STUDENT TABLE -->
    <div class="container-fluid p-5 position-absolute top-50 start-50 translate-middle">
        <div class= "row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Students Database
                            <!-- Button trigger add student modal -->
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addStudentsModal">
                            Add Students
                            </button>
                        </h2>
                    </div>
                    <div class="card-body table-responsive" id="tblStud">
                        <table id="studentTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Firstname</th>
                                    <th scope="col">Lastname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                <tr>
                                    <!-- FOR CHECKING ONLY -->
                                    <th scope="row" colspan="5">Loading...</th> 
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="addstudent_message"></div>
                <form id="addStudents">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label for="firstname" class="form-label">Firstname<span class="text-danger"> *</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter firstname" required/>
                            </div>
                            <div class="col-6 mb-2">
                                <label for="lastname" class="form-label">Lastname<span class="text-danger"> *</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter lastname" required/>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Email<span class="text-danger"> *</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com" required/>
                        </div>
                        <div class="mb-2">
                            <label for="phone" class="form-label">Mobile<span class="text-danger"> *</span></label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter 11 digit mobile number" required/>
                        </div>
                        <div class="mb-2">
                            <label for="course" class="form-label">Course<span class="text-danger"> *</span></label>
                            <input type="text" name="course" id="course" class="form-control" placeholder="Enter course" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="myBtn" onclick="addStudents()" class="btn btn-primary mb-3">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Student Modal -->
    <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Student Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="response_message"></div>
                <form id="viewStudents">
                    <div class="modal-body">
                        <div id="viewModal"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="editstudent_message"></div>
                <form id="editStud">
                    <div class="modal-body">
                        <div id="editModal"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- AJAX METHOD -->
    <script>
        // ADDING STUDENT TO THE DATABASE DONE
        function addStudents() {
            let xmlhttp = new XMLHttpRequest();

            // Instantiating the request object
            xmlhttp.open("POST", "add_student.php", true);
            // Defining event listener for readystatechange event
            xmlhttp.onreadystatechange = function() {

                if (this.readyState === 4 && this.status === 200){
                    // Here is the response
                    document.getElementById("addstudent_message").innerHTML = this.responseText;
                    document.getElementById("addStudents").reset();
                    loadTable();
                }
            };

            // Retrieving the form data
            let addStudent = document.getElementById("addStudents");
            let addStud = new FormData(addStudent);

            // Sending the request to the server
            xmlhttp.send(addStud);
            
        }
        // ADDING STUDENT TO THE DATABASE DONE

        // SHOWING THE WHOLE TABLE AJAX DONE
        function loadTable() {
            var xmlhttp = new XMLHttpRequest();

            // Instantiating the request object
            xmlhttp.open("GET", "loadtable.php", true);
            xmlhttp.send();
            // Defining event listener for readystatechange event
            xmlhttp.onreadystatechange = function() {

                if (this.readyState === 4 && this.status === 200)
                {
                    // Here is the response
                    var data = JSON.parse(this.responseText);

                    var table = "";

                    for (var i = 0; i < data.length; i++){
                        var dbID = data[i].id;
                        var firstname = data[i].firstname;
                        var lastname = data[i].lastname;
                        var email = data[i].email;
                        var phone = data[i].phone;
                        var course = data[i].course;

                        table += '<tr>'; 
                        table += '<td>' + dbID + '</td>';
                        table += '<td>' + firstname + '</td>';
                        table += '<td>' + lastname + '</td>';
                        table += '<td>' + email + '</td>';
                        table += '<td>' + phone + '</td>';
                        table += '<td>' + course + '</td>';
                        table += '<td><button type="button" class="btn btn-outline-info mx-1" data-bs-toggle="modal" data-bs-target="#viewStudentModal" onclick="viewStudent('+ dbID +')">View</button>';
                        table += '<button type="button" class="btn btn-outline-warning mx-1" data-bs-toggle="modal" data-bs-target="#editStudentModal" onclick="editStudent('+ dbID +')">Edit</button>';
                        table += '<button type="submit" class="btn btn-outline-danger mx-1"  onclick="delStudent('+ dbID +')">Del</button></td>';
                        table += "</tr>";

                        
                    }
                    document.getElementById("data").innerHTML = table;
                    
                }
            };
        }
        loadTable();
        // SHOWING THE WHOLE TABLE AJAX DONE

        // DELETE STUDENT DONE WITH AJAX
        function delStudent(delStud) {
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "delstudent.php?id=" + delStud, true);
            xhttp.send(JSON.stringify({ 
                "id": delStud
            }));
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                loadTable();
                } 
            };
        }
        // DELETE STUDENT DONE WITH AJAX
        
        //VIEW STUDENT FINISHED
        function viewStudent(dbID){
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let student = JSON.parse(this.responseText);

                    let output = "";
                    for(var i in student){
                        output += 
                            '<div class="row">' +
                                '<div class="col-6 mb-2">' +
                                    '<label for="firstname" class="form-label">Firstname</label>' + 
                                    '<input type="text" value="'+ student[i].firstname + '" name="firstname" id="firstname" class="form-control"/>' +
                                '</div>' + 
                                '<div class="col-6 mb-2">' +
                                    '<label for="lastname" class="form-label">Lastname</label>' + 
                                    '<input type="text" value="'+ student[i].lastname + '" name="lastname" id="lastname" class="form-control"/>' +
                                '</div>' + 
                            '</div>' +
                            '<div class="mb-2">' +
                                '<label for="email" class="form-label">Email</label>' + 
                                '<input type="email" value="'+ student[i].email + '" name="email" id="email" class="form-control"/>' + 
                            '</div>' + 
                            '<div class="mb-2">' +
                                '<label for="phone" class="form-label">Mobile</label>' +
                                '<input type="number" value="'+ student[i].phone + '" class="form-control" name="phone" id="phone"/>' +
                            '</div>' +
                            '<div class="mb-2">' +
                                '<label for="course" class="form-label">Course</label>' +
                                '<input type="text" value="'+ student[i].course + '" name="course" id="course" class="form-control"/>' +
                            '</div>';
                    }

                    document.getElementById("viewModal").innerHTML = output;
                }
            };                                    
            xhttp.open("GET", "view_student.php?id=" + dbID, true);
            xhttp.send();
        }
        //VIEW STUDENT FINISHED

        // EDIT/UPDATE STUDENTN NOT DONE YET
        function editStudent(dbID){
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let student = JSON.parse(this.responseText);

                    let output = "";
                    for(var i in student){
                        output += 
                            '<div class="row">' +
                                '<div class="col-6 mb-2">' +
                                    '<label for="firstname" class="form-label">Firstname</label>' + 
                                    '<input type="text" value="'+ student[i].firstname + '" name="firstname" id="firstname" class="form-control"/>' +
                                '</div>' + 
                                '<div class="col-6 mb-2">' +
                                    '<label for="lastname" class="form-label">Lastname</label>' + 
                                    '<input type="text" value="'+ student[i].lastname + '" name="lastname" id="lastname" class="form-control"/>' +
                                '</div>' + 
                            '</div>' +
                            '<div class="mb-2">' +
                                '<label for="email" class="form-label">Email</label>' + 
                                '<input type="email" value="'+ student[i].email + '" name="email" id="email" class="form-control"/>' + 
                            '</div>' + 
                            '<div class="mb-2">' +
                                '<label for="phone" class="form-label">Mobile</label>' +
                                '<input type="number" value="'+ student[i].phone + '" class="form-control" name="phone" id="phone"/>' +
                            '</div>' +
                            '<div class="mb-2">' +
                                '<label for="course" class="form-label">Course</label>' +
                                '<input type="text" value="'+ student[i].course + '" name="course" id="course" class="form-control"/>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                                '<button type="submit" onclick="updateStudents('+student[i].id+')" class="btn btn-primary mb-3">Update Student</button>' +
                            '</div>';
                            loadTable();
                    }
                    document.getElementById("editModal").innerHTML = output;
                }
            };                                    
            xhttp.open("GET", "view_student.php?id=" + dbID, true);
            xhttp.send();
        }
        // FINISHED
        function updateStudents(dbID) {
            let xmlhttp = new XMLHttpRequest();

            // Instantiating the request object
            xmlhttp.open("POST", "update_student.php?id="+ dbID, true);
            // Defining event listener for readystatechange event
            xmlhttp.onreadystatechange = function() {

                if (this.readyState === 4 && this.status === 200){
                    console.log("SUCCESS");
                    // Here is the response
                    document.getElementById("editstudent_message").innerHTML = this.responseText;
                    loadTable();
                }
            };

            // Retrieving the form data
            let updtStud = document.getElementById("editStud");
            let update = new FormData(updtStud);
            
            // Sending the request to the server
            xmlhttp.send(update);
            
        }
        // EDIT/UPDATE STUDENTN NOT DONE YET

    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>