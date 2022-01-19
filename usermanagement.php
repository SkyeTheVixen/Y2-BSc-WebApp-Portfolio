<?php
    $currentPage="usermanagement";
    $title="User Management | VD Training";
    $pathHead="res/";
    $pageRedirect="";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/header.php"); 
    include("res/php/navbar.php");
?>


<!-- Main Content -->
<div class="container">
    <!-- Table of Users -->
    <div class="row mt-5">
        <table class="mt-5 table table-striped table-hover" id="userTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Access Level</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        $sql = "SELECT * FROM `tblUsers`";
                        $run = mysqli_query($connect, $sql);

                        while($result = mysqli_fetch_assoc($run))
                        {
                    ?>
                <tr>
                    <td><?=$result["UUID"]?></td>
                    <td><?=$result["FirstName"]?></td>
                    <td><?=$result["LastName"]?></td>
                    <td><?=$result["Email"]?></td>
                    <td><?=$result["JobTitle"]?></td>
                    <td><?=$result["AccessLevel"]?></td>
                    <td><a data-id="<?=$result["UUID"]?>" class="editUser"><i class="fa fa-pencil"></i></a>
                    </td>
                    <td><a class="delUUID" data-id="<?=$result["UUID"]?>"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <?php
                            }
                        ?>
                </tr>
            </tbody>
        </table>
        <!-- End Table of Users -->
    </div>

    <button class="px-3 btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>


    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addUserForm">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="firstNameInput" class="form-label">First Name</label>
                            <input type="text" required class="form-control" id="firstNameInput">
                        </div>
                        <div class="mb-3">
                            <label for="lastNameInput" class="form-label">Last Name</label>
                            <input type="text" required class="form-control" id="lastNameInput">
                        </div>
                        <div class="mb-3">
                            <label for="jobTitleInput" class="form-label">Job Title</label>
                            <input type="text" required class="form-control" id="jobTitleInput">
                        </div>
                        <div class="mb-3">
                            <label for="accessLevelSelect" class="form-label">Access Level</label>
                            <select class="form-select" required id="accessLevelSelect" aria-label="selectAccessLevel">
                                <option selected>Access Level</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email address</label>
                            <input type="email" required class="form-control" id="emailInput">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addUserBtn">Add User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Add User Modal -->
</div>
<!-- End Main Content -->


<?php
    include("res/php/footer.php");
?>